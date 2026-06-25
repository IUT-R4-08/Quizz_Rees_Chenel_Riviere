<?php

namespace Tests\Feature;

use App\Models\Theme;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionControllerTest extends TestCase
{
    use RefreshDatabase;

    private function makeTheme(): Theme
    {
        return Theme::create([
            'nom' => 'Histoire',
            'slug' => 'histoire',
            'icone' => '📚',
            'description' => 'Quiz sur l\'histoire',
        ]);
    }

    // ----- create() -----

    public function test_guest_cannot_access_create(): void
    {
        $theme = $this->makeTheme();

        $response = $this->get(route('admin.questions.create', $theme));

        $response->assertRedirect(route('login'));
    }

    // ----- index() -----

    public function test_guest_cannot_access_index(): void
    {
        $theme = $this->makeTheme();

        $response = $this->get(route('admin.questions.index', $theme));

        $response->assertRedirect(route('login'));
    }

    // ----- store() -----

    public function test_guest_cannot_store_question(): void
    {
        $theme = $this->makeTheme();

        $response = $this->post(route('admin.questions.store', $theme), [
            'question' => 'Une question ?',
            'answers' => [
                ['answer' => 'A'],
                ['answer' => 'B'],
                ['answer' => 'C'],
                ['answer' => 'D'],
            ],
            'correct' => 0,
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('questions', 0);
    }

    // ----- update() -----

    public function test_guest_cannot_update_question(): void
    {
        $theme = $this->makeTheme();

        $question = Question::create([
            'theme_id' => $theme->id,
            'question' => 'Question ?',
        ]);

        $response = $this->put(route('admin.questions.update', [$theme, $question]), [
            'question' => 'Modifiée ?',
            'answers' => [
                ['answer' => 'A'],
                ['answer' => 'B'],
                ['answer' => 'C'],
                ['answer' => 'D'],
            ],
            'correct' => 0,
        ]);

        $response->assertRedirect(route('login'));

        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'question' => 'Question ?',
        ]);
    }

    // ----- destroy() -----

    public function test_guest_cannot_destroy_question(): void
    {
        $theme = $this->makeTheme();

        $question = Question::create([
            'theme_id' => $theme->id,
            'question' => 'À supprimer ?',
        ]);

        $response = $this->delete(route('admin.questions.destroy', [$theme, $question]));

        $response->assertRedirect(route('login'));

        $this->assertDatabaseHas('questions', ['id' => $question->id]);
    }
}
