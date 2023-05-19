<?php

namespace Tests\Feature;

use App\Http\Resources\Admin\Security\PermissionResource;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PermissionTest extends TestCase
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

    public function test_create_permissions_with_guard_name_for_api(): void
    {

        // ----- Create a permission with guard_name
        $response = $this
            ->postJson(route('api.v1.permissions.store'), [
                'name'       => $name = $this->faker->word(),
                'guard_name' => $guard_name = $this->faker->word(),
            ]);

        $response->assertNoContent();

        $permission = Permission::firstWhere('name', $name);
        $this->assertModelExists($permission);
        $this->assertEquals($guard_name, $permission->guard_name);
    }

    public function test_create_permissions_without_guard_name_for_api(): void
    {
        $response = $this
            ->postJson(route('api.v1.permissions.store'), [
                'name'       => $name = $this->faker->word(),
            ]);

        $response->assertNoContent();

        $permission = Permission::firstWhere('name', $name);
        $this->assertModelExists($permission);
        $this->assertEquals('web', $permission->guard_name);
    }

    public function test_not_create_permission_for_api_because_problem_with_validations(): void
    {
        $response = $this->postJson(route('api.v1.permissions.store'), []);

        $errors = [
            'name'
        ];
        $response->assertJsonValidationErrors($errors);
    }

    public function test_show_permission_by_id_for_api(): void
    {
        $permission = Permission::create([
            'name' => $this->faker->word(),
            'guard_name' => 'web'
        ]);

        $response = $this->getJson(route('api.v1.permissions.show', ['permission' => $permission->id]));

        $response->assertOk()
            ->assertJson([
                "data" => [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'guard_name' => $permission->guard_name
                ],
                "message" => __('generals.success-show', ['name' => 'Permission'])
            ]);
    }

    public function test_index_permission_for_api(): void
    {
        Permission::create([
            'name' => $this->faker->word(),
            'guard_name' => 'web'
        ]);

        $response = $this->getJson(route('api.v1.permissions.index'));

        $permissions = Permission::all();
        $response->assertOk()
            ->assertJson([
                "data" => $permissions->map(function ($permissionIterable) {
                    return [
                        'id' => $permissionIterable->id,
                        'name' => $permissionIterable->name,
                        'guard_name' => $permissionIterable->guard_name
                    ];
                })->toArray(),
                "message" => __('generals.success-index', ['name' => 'Permission'])
            ]);
    }

    public function test_update_permission_with_guard_name_for_api(): void
    {
        $permission = Permission::create([
            'name' => $this->faker->word(),
            'guard_name' => $this->faker->word()
        ]);

        $response = $this->putJson(route('api.v1.permissions.update', ['permission' => $permission->id]), [
            'name'       => $name = $this->faker->word(),
            'guard_name' => $guard_name = $this->faker->word(),
        ]);

        $response->assertNoContent();
        $permission->refresh();
        $this->assertEquals($name, $permission->name);
        $this->assertEquals($guard_name, $permission->guard_name);
    }

    public function test_update_permission_without_guard_name_for_api(): void
    {
        $permission = Permission::create([
            'name' => $this->faker->word(),
            'guard_name' => $this->faker->word()
        ]);

        $response = $this->putJson(route('api.v1.permissions.update', ['permission' => $permission->id]), [
            'name'       => $name = $this->faker->word(),
            'guard_name' => '',
        ]);

        $response->assertNoContent();
        $permission->refresh();
        $this->assertEquals($name, $permission->name);
        $this->assertEquals('web', $permission->guard_name);
    }

    public function test_not_update_permission_for_api_because_problem_with_validations(): void
    {
        $permission = Permission::create([
            'name' => $this->faker->word(),
            'guard_name' => $this->faker->word()
        ]);
        $response = $this->putJson(route('api.v1.permissions.update', ['permission' => $permission->id]), []);

        $errors = [
            'name'
        ];
        $response->assertJsonValidationErrors($errors);
    }

    public function test_destroy_permission_for_api(): void
    {
        $permission = Permission::create([
            'name' => $this->faker->word(),
            'guard_name' => $this->faker->word()
        ]);
        $response = $this->deleteJson(route('api.v1.permissions.destroy', ['permission' => $permission->id]));

        $response->assertNoContent();
    }

    public function test_not_destroy_permission_for_api_because_validations(): void
    {
        $permission = Permission::create([
            'name' => $this->faker->word(),
            'guard_name' => 'web'
        ]);
        $role = Role::create([
            'name' => $this->faker->word(),
            'guard_name' => 'web'
        ]);
        $role->givePermissionTo($permission);

        $response = $this->deleteJson(route('api.v1.permissions.destroy', ['permission' => $permission->id]));

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
