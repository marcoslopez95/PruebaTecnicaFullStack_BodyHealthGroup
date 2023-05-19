<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    private $admin;
    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::firstWhere('name', 'Admin');
        $this->admin = User::factory()->create();
        $this->admin->roles()->attach([$role->id]);

        Sanctum::actingAs(
            $this->admin,
            ['*']
        );
    }

    public function test_create_roles_with_guard_name_for_api(): void
    {

        // ----- Create a Role with guard_name
        $response = $this
            ->postJson(route('api.v1.roles.store'), [
                'name'       => $name = $this->faker->word(),
                'guard_name' => $guard_name = $this->faker->word(),
            ]);

        $response->assertNoContent();

        $role = Role::firstWhere('name', $name);
        $this->assertModelExists($role);
        $this->assertEquals($guard_name, $role->guard_name);
    }

    public function test_create_roles_without_guard_name_for_api(): void
    {
        $response = $this
            ->postJson(route('api.v1.roles.store'), [
                'name'       => $name = $this->faker->word(),
            ]);

        $response->assertNoContent();

        $role = Role::firstWhere('name', $name);
        $this->assertModelExists($role);
        $this->assertEquals('web', $role->guard_name);
    }

    public function test_not_create_role_for_api_because_problem_with_validations(): void
    {
        $response = $this->postJson(route('api.v1.roles.store'), []);

        $errors = [
            'name'
        ];
        $response->assertJsonValidationErrors($errors);
    }

    public function test_show_role_by_id_for_api(): void
    {
        $role = Role::create([
            'name' => $this->faker->word(),
            'guard_name' => 'web'
        ]);

        $response = $this->getJson(route('api.v1.roles.show', ['role' => $role->id]));

        $response->assertOk()
            ->assertJson([
                "data" => [
                    'id' => $role->id,
                    'name' => $role->name,
                    'guard_name' => $role->guard_name
                ],
                "message" => __('generals.success-show', ['name' => 'Role'])
            ]);
    }

    public function test_index_role_for_api(): void
    {
        Role::create([
            'name' => $this->faker->word(),
            'guard_name' => 'web'
        ]);

        $response = $this->getJson(route('api.v1.roles.index'));

        $roles = Role::all();
        $response->assertOk()
            ->assertJson([
                "data" => $roles->map(function ($roleIterable) {
                    return [
                        'id' => $roleIterable->id,
                        'name' => $roleIterable->name,
                        'guard_name' => $roleIterable->guard_name
                    ];
                })->toArray(),
                "message" => __('generals.success-index', ['name' => 'Role'])
            ]);
    }

    public function test_update_role_with_guard_name_for_api(): void
    {
        $role = Role::create([
            'name' => $this->faker->word(),
            'guard_name' => $this->faker->word()
        ]);

        $response = $this->putJson(route('api.v1.roles.update', ['role' => $role->id]), [
            'name'       => $name = $this->faker->word(),
            'guard_name' => $guard_name = $this->faker->word(),
        ]);

        $response->assertNoContent();
        $role->refresh();
        $this->assertEquals($name, $role->name);
        $this->assertEquals($guard_name, $role->guard_name);
    }

    public function test_update_role_without_guard_name_for_api(): void
    {
        $role = Role::create([
            'name' => $this->faker->word(),
            'guard_name' => $this->faker->word()
        ]);

        $response = $this->putJson(route('api.v1.roles.update', ['role' => $role->id]), [
            'name'       => $name = $this->faker->word(),
            'guard_name' => '',
        ]);

        $response->assertNoContent();
        $role->refresh();
        $this->assertEquals($name, $role->name);
        $this->assertEquals('web', $role->guard_name);
    }

    public function test_not_update_role_for_api_because_problem_with_validations(): void
    {
        $role = Role::create([
            'name' => $this->faker->word(),
            'guard_name' => $this->faker->word()
        ]);
        $response = $this->putJson(route('api.v1.roles.update', ['role' => $role->id]), []);

        $errors = [
            'name'
        ];
        $response->assertJsonValidationErrors($errors);
    }

    public function test_destroy_role_for_api(): void
    {
        $role = Role::create([
            'name' => $this->faker->word(),
            'guard_name' => $this->faker->word()
        ]);

        $response = $this->deleteJson(route('api.v1.roles.destroy', ['role' => $role->id]));

        $response->assertNoContent();
    }

    public function test_not_destroy_role_for_api_because_validations(): void
    {
        $role = Role::create([
            'name' => $this->faker->word(),
            'guard_name' => 'web'
        ]);
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->deleteJson(route('api.v1.roles.destroy', ['role' => $role->id]));

        $response->assertStatus(422)
            ->assertSimilarJson(
                [
                    'code' => 422,
                    'title' => __('generals.errors-validations.destroy', ['name' => 'Role']),
                    'errors' => __('generals.errors-validations.destroy', ['name' => 'Role']),
                ]
            );
    }
}
