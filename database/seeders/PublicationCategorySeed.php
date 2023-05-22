<?php

namespace Database\Seeders;

use App\Models\PublicationCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublicationCategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PublicationCategory::create([
            'name' => 'Caegoría Uno',
            'description' => 'mi primera categoría',
        ]);

        PublicationCategory::create([
            'name' => 'Caegoría 2',
            'description' => 'mi segunda categoría',
        ]);
    }
}
