<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class LogoutTest extends TestCase
{

    public function test_loging_and_logout(): void
    {
        $role = Role::firstWhere('name', 'Admin');
        $user = User::factory()->create();
        $user->roles()->attach([$role->id]);

        $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $this->assertAuthenticated();

        $this->postJson(route('logout'))
            ->assertNoContent();

        $this->assertGuest();
    }
}
