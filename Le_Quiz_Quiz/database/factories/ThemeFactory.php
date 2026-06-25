<?php

namespace Database\Factories;

use App\Models\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Theme>
 */
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
