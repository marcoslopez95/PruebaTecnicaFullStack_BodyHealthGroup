<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserTest extends TestCase
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

    public function test_create_users_for_api(): void
    {

        $roleRandom = Role::all()->random()->first();
        // ----- Create a Role with guard_name
        $response = $this
            ->postJson(route('api.v1.users.store'), [
                'name'                  => $this->faker->name(),
                'email'                 => $email = $this->faker->email(),
                'role_id'                  => $roleRandom->id,
                'password'              => $password  = $this->faker->regexify('/[Aa-Zz0-9]{6}/'),
                'password_confirmation' => $password,
            ]);

        $response->assertNoContent();

        $user = User::firstWhere('email', $email);
        $this->assertModelExists($user);
        $this->assertEquals($roleRandom->id, $user->roles[0]->id);
    }

    public function test_not_create_user_for_api_because_problem_with_validations(): void
    {
        $response = $this->postJson(route('api.v1.users.store'), []);

        $errors = [
            'name',
            'email',
            'role_id',
            'password',
        ];
        $response->assertJsonValidationErrors($errors);
    }

    public function test_show_user_by_id_for_api(): void
    {
        $role = Role::all()->random()->first();
        $user = User::factory()->create();
        $user->roles()->attach([$role->id]);
        $response = $this->getJson(route('api.v1.users.show', ['user' => $user->id]));
        $response->assertOk()
            ->assertJson([
                "data" => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => [
                        'id'   => $user->roles[0]->id,
                        'name' => $user->roles[0]->name,
                        'guard_name' => $user->roles[0]->guard_name,
                    ]
                ],
                "message" => __('generals.success-show', ['name' => 'User'])
            ]);
    }

    public function test_index_user_for_api(): void
    {
        $role = Role::all()->random()->first();
        $user = User::factory()->create();
        $user->roles()->attach([$role->id]);

        $response = $this->getJson(route('api.v1.users.index'));

        $users = User::all();
        $response->assertOk()
            ->assertJson([
                "data" => $users->map(function (User $userIterable) {
                    return [
                        'id'         => $userIterable->id,
                        'name'       => $userIterable->name,
                        'email'      => $userIterable->email,
                        'created_at' => (string) \Carbon\Carbon::parse($userIterable->created_at)->format('m-d-Y'),
                        'role'  => [
                            'id'   => $userIterable->roles[0]->id,
                            'name' => $userIterable->roles[0]->name,
                            'guard_name' => $userIterable->roles[0]->guard_name,
                        ]
                    ];
                })->toArray(),
                "message" => __('generals.success-index', ['name' => 'Users'])
            ]);
    }

    public function test_update_user_with_guard_name_for_api(): void
    {
        $role = Role::all()->random()->first();
        $user = User::factory()->create();
        $user->roles()->attach([$role->id]);
        $roleRandom = Role::all()->random()->first();

        $response = $this->putJson(route('api.v1.users.update', ['user' => $user->id]), [
            'name'                  => $this->faker->name(),
            'email'                 => $email = $this->faker->email(),
            'role_id'                  => $roleRandom->id,
            'password'              => $password  = $this->faker->regexify('/[Aa-Zz0-9]{6}/'),
            'password_confirmation' => $password,
        ]);

        $response->assertNoContent();
        $user->refresh();
        $this->assertEquals($email, $user->email);
        $this->assertEquals($roleRandom->id, $user->roles[0]->id);
    }

    public function test_not_update_user_for_api_because_problem_with_validations(): void
    {
        $role = Role::all()->random()->first();
        $user = User::factory()->create();
        $user->roles()->attach([$role->id]);
        $response = $this->putJson(route('api.v1.users.update', ['user' => $user->id]), []);

        $errors = [
            'name',
            'email',
            'role_id',
        ];
        $response->assertJsonValidationErrors($errors);
    }
}
