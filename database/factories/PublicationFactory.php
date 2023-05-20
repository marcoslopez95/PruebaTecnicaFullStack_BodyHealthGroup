<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publication>
 */
class PublicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->text(),
            'labels'  => $this->setLabels(),
        ];
    }

    private function setLabels(): array
    {
        $array = [];
        for ($i = 1; $i <= rand(1, 5); $i++) {
            $array[] = $this->faker->word();
        }
        return $array;
    }
}
