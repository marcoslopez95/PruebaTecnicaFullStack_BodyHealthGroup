<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(PermissionSeed::class);
        $this->call(RoleSeed::class);
        $this->call(UserSeed::class);
        $this->call(ExternalReferenceSeed::class);
        $this->call(PublicationCategorySeed::class);
        $this->call(RegionSeed::class);
        $this->call(PublicationSeed::class);
    }
}
