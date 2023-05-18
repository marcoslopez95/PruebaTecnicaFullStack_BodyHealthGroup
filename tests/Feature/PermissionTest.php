<?php

namespace Tests\Feature;

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

    public function test_create_permissions_for_api(): void
    {
        $role = Role::firstWhere('name', 'Admin');
        $user = User::factory()->create();
        $user->roles()->attach([$role->id]);

        Sanctum::actingAs(
            $user,
            ['*']
        );

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

        // ------- Create Permission without guard_name
        $response = $this
            ->postJson(route('api.v1.permissions.store'), [
                'name'       => $name = $this->faker->word(),
            ]);

        $response->assertNoContent();

        $permission = Permission::firstWhere('name', $name);
        $this->assertModelExists($permission);
        $this->assertEquals('web', $permission->guard_name);
    }
}
