<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\QuizResult;
use App\Models\Theme;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThemeModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_a_theme_has_many_questions()
    {
        $theme = Theme::factory()->create();

        Question::factory()->count(2)->create(['theme_id' => $theme->id]);

        $this->assertCount(2, $theme->questions);
        $this->assertInstanceOf(Question::class, $theme->questions->first());
    }

    /** @test */
    public function test_a_theme_has_many_quiz_results()
    {
        $theme = Theme::factory()->create();

        QuizResult::factory()->count(3)->create(['theme_id' => $theme->id]);

        $this->assertCount(3, $theme->results);
        $this->assertInstanceOf(QuizResult::class, $theme->results->first());
    }
}