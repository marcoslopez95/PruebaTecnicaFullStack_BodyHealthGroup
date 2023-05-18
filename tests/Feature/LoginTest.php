<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseTransactions;
    public function test_login_successfull_for_api(): void
    {
        $role = Role::firstWhere('name', 'User');
        $user = User::factory()->create();
        $user->roles()->attach([$role->id]);

        $response = $this->postJson(route('api.v1.login'), [
            'email'    => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                "message" => __('auth.login.successfull')
            ])
            ->assertJsonPath('data', fn(string $token) => strlen($token) >= 35)
            ;
    }

    public function test_not_login_for_api_because_problem_with_validations(): void
    {
        $response = $this->postJson(route('api.v1.register'), []);

        $errors = [
            'email',
            'password',
        ];
        $response->assertJsonValidationErrors($errors);
    }
}
