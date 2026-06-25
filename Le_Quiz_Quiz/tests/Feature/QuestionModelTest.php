<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Theme;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_a_question_belongs_to_a_theme()
    {
        $theme = Theme::factory()->create(['nom' => 'Histoire']);
        $question = Question::factory()->create(['theme_id' => $theme->id]);

        $this->assertInstanceOf(Theme::class, $question->theme);
        $this->assertEquals($theme->id, $question->theme->id);
        $this->assertEquals('Histoire', $question->theme->nom);
    }

    /** @test */
    public function test_a_question_has_many_answers()
    {
        $question = Question::factory()->create();

        Answer::factory()->count(3)->create(['question_id' => $question->id]);

        $this->assertCount(3, $question->answers);
        $this->assertInstanceOf(Answer::class, $question->answers->first());
    }
}