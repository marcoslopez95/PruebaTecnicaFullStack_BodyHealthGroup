<?php

namespace Database\Seeders;

use App\Models\ExternalReference;
use App\Models\Publication;
use App\Models\PublicationCategory;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublicationSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            Publication::factory(150)
                ->for(Region::factory()->create())
                ->for(PublicationCategory::factory()->create())
                ->for(User::factory()->create())
                ->has(ExternalReference::factory()->count(3))
                ->create();
        } catch (\Exception $e) {
        }
    }
}
