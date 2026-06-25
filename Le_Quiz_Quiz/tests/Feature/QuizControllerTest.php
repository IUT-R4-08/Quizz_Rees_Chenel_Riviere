<?php

namespace Tests\Feature;

use App\Models\Theme;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuizControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_displays_quiz_with_questions(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test_show@example.com',
            'password' => bcrypt('password'),
        ]);

        $theme = Theme::create([
            'nom' => 'Histoire',
            'slug' => 'histoire',
            'icone' => '📚',
            'description' => 'Quiz sur l\'histoire de France',
        ]);

        $question1 = Question::create([
            'theme_id' => $theme->id,
            'question' => 'Qui était roi en 1789 ?',
        ]);

        Answer::create([
            'question_id' => $question1->id,
            'answer' => 'Louis XVI',
            'is_correct' => true,
        ]);

        Answer::create([
            'question_id' => $question1->id,
            'answer' => 'Napoléon',
            'is_correct' => false,
        ]);

        $response = $this->actingAs($user)->get(route('quiz.show', $theme));

        $response->assertOk();
        $response->assertViewIs('quiz');
        $response->assertViewHas('theme');
    }

    public function test_submit_calculates_correct_score(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $theme = Theme::create([
            'nom' => 'Géographie',
            'slug' => 'geographie',
            'icone' => '🌍',
            'description' => 'Quiz de géographie',
        ]);

        // Question 1 : bonne réponse sélectionnée
        $q1 = Question::create([
            'theme_id' => $theme->id,
            'question' => 'Quelle est la capitale de la France ?',
        ]);

        $correct1 = Answer::create([
            'question_id' => $q1->id,
            'answer' => 'Paris',
            'is_correct' => true,
        ]);

        Answer::create([
            'question_id' => $q1->id,
            'answer' => 'Lyon',
            'is_correct' => false,
        ]);

        // Question 2 : mauvaise réponse sélectionnée
        $q2 = Question::create([
            'theme_id' => $theme->id,
            'question' => 'Quelle est la capitale de l\'Italie ?',
        ]);

        Answer::create([
            'question_id' => $q2->id,
            'answer' => 'Rome',
            'is_correct' => true,
        ]);

        $wrong2 = Answer::create([
            'question_id' => $q2->id,
            'answer' => 'Milan',
            'is_correct' => false,
        ]);

        $response = $this->actingAs($user)->post(route('quiz.submit', $theme), [
            "question_{$q1->id}" => $correct1->id,
            "question_{$q2->id}" => $wrong2->id,
        ]);

        $response->assertOk();
        $response->assertViewHas('score', 1);
        $response->assertViewHas('total', 2);
    }

    public function test_submit_persists_quiz_result(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test2@example.com',
            'password' => bcrypt('password'),
        ]);

        $theme = Theme::create([
            'nom' => 'Sciences',
            'slug' => 'sciences',
            'icone' => '🔬',
            'description' => 'Quiz scientifique',
        ]);

        $question = Question::create([
            'theme_id' => $theme->id,
            'question' => 'Quelle est la formule chimique de l\'eau ?',
        ]);

        $correctAnswer = Answer::create([
            'question_id' => $question->id,
            'answer' => 'H2O',
            'is_correct' => true,
        ]);

        $this->actingAs($user)->post(route('quiz.submit', $theme), [
            "question_{$question->id}" => $correctAnswer->id,
        ]);

        $this->assertDatabaseHas('quiz_results', [
            'user_id' => $user->id,
            'theme_id' => $theme->id,
            'score' => 1,
            'total_questions' => 1,
        ]);
    }
}
