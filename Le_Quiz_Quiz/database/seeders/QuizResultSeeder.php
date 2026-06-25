<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Theme;
use App\Models\QuizResult;

class QuizResultSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'user@test.com')->first();

        if (!$user) {
            return;
        }

        $themes = Theme::all();

        foreach ($themes as $theme) {

            for ($i = 0; $i < 3; $i++) {

                $total = $theme->questions()->count();

                if ($total === 0) continue;

                $score = rand(0, $total);

                QuizResult::create([
                    'user_id' => $user->id,
                    'theme_id' => $theme->id,
                    'score' => $score,
                    'total_questions' => $total,
                ]);
            }
        }
    }
}