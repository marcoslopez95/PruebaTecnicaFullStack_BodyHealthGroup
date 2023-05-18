<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /**
     * A basic feature test example.
     */
    public function test_create_user_for_api(): void
    {
        $response = $this->postJson(route('api.v1.register'), [
            'name'     => $name = $this->faker->name(),
            'email'    => $email = $this->faker->unique()->email(),
            'password' => $password = 'Test.123',
            'password_confirmation' => $password,
        ]);

        $response->assertNoContent();

        $user = User::firstWhere('email', $email);
        $this->assertModelExists($user);
        $this->assertCount(1, $user->roles);
        $this->assertEquals('User', $user->roles[0]->name);
    }

    public function test_not_create_user_for_api_because_problem_with_validations(): void
    {
        $response = $this->postJson(route('api.v1.register'), []);

        $errors = [
            'name',
            'email',
            'password',
        ];
        $response->assertJsonValidationErrors($errors);
    }
}
