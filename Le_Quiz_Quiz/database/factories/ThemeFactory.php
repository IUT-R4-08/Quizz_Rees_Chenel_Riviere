<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ThemeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nom = $this->faker->unique()->word();

        return [
            'nom'         => ucfirst($nom),
            'slug'        => Str::slug($nom),
            'icone'       => $this->faker->imageUrl(100, 100, 'abstract'),
            'description' => $this->faker->sentence(),
        ];
    }
}