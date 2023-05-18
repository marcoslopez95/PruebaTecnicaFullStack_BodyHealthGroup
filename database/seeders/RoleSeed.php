<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = collect([
            [
                "name" =>'Admin',
                "guard_name" => 'web'
            ],
            [
                "name" =>'User',
                "guard_name" => 'api'
            ]
        ]);
        $roles->each(fn($role) => Role::create($role));
    }
}
