<?php

namespace Database\Seeders;

use App\Models\ExternalReference;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExternalReferenceSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExternalReference::factory(10)->create();
    }
}
