<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createUser();
        $this->createUserAdmin();
    }

    private function createUserAdmin(): void
    {
        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@admin.com',
            'password' => Hash::make('Test.123'),
        ]);

        $admin->assignRole('Admin');
    }

    private function createUser(): void
    {
        $admin = User::create([
            'name'     => 'user',
            'email'    => 'user@user.com',
            'password' => Hash::make('Test.123'),
        ]);

        $admin->roles()->attach([Role::firstWhere('name', 'User')->id]);
    }
}
