<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnswerModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_an_answer_belongs_to_a_question()
    {
        $question = Question::factory()->create(['question' => 'Quelle est la capitale de la France ?']);
        
        $answer = Answer::factory()->create([
            'question_id' => $question->id,
            'answer' => 'Paris',
            'is_correct' => true,
        ]);

        $this->assertInstanceOf(Question::class, $answer->question);
        $this->assertEquals($question->id, $answer->question->id);
        $this->assertEquals('Quelle est la capitale de la France ?', $answer->question->question);
    }

    /** @test */
    public function test_is_correct_field_is_properly_casted_to_boolean()
    {
        $question = Question::factory()->create();

        $answer = Answer::factory()->create([
            'question_id' => $question->id,
            'is_correct' => 1, 
        ]);

        $this->assertIsBool($answer->is_correct);
        $this->assertTrue($answer->is_correct);
    }
}