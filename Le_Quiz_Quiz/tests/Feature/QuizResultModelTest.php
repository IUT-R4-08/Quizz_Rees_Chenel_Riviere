<?php

namespace Tests\Feature;

use App\Models\QuizResult;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuizResultModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_a_quiz_result_belongs_to_a_user()
    {
        $user = User::factory()->create(['name' => 'Kyllian']);
        $quizResult = QuizResult::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $quizResult->user);
        $this->assertEquals($user->id, $quizResult->user->id);
        $this->assertEquals('Kyllian', $quizResult->user->name);
    }

    /** @test */
    public function test_a_quiz_result_belongs_to_a_theme()
    {
        $theme = Theme::factory()->create(['nom' => 'Cybersécurité']);
        $quizResult = QuizResult::factory()->create(['theme_id' => $theme->id]);

        $this->assertInstanceOf(Theme::class, $quizResult->theme);
        $this->assertEquals($theme->id, $quizResult->theme->id);
        $this->assertEquals('Cybersécurité', $quizResult->theme->nom);
    }
}