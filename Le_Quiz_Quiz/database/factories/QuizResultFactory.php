<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), 
            
            'theme_id' => Theme::factory(), 
            
            'score' => $this->faker->numberBetween(0, 10),
            'total_questions' => 10,
            
        ];
    }
}