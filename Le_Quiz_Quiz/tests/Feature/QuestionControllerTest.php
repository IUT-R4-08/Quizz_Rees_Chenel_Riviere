<?php

namespace Tests\Feature;

use App\Models\Theme;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionControllerTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    private function makeTheme(): Theme
    {
        return Theme::create([
            'nom'         => 'Histoire',
            'slug'        => 'histoire',
            'icone'       => '📚',
            'description' => 'Quiz sur l\'histoire',
        ]);
    }

    private function makeQuestion(Theme $theme, string $text = 'Question ?'): Question
    {
        return Question::create([
            'theme_id' => $theme->id,
            'question' => $text,
        ]);
    }

    /**
     * Crée 4 réponses pour une question.
     * $correctIndex indique laquelle est correcte (0–3).
     */
    private function makeAnswers(Question $question, int $correctIndex = 0): void
    {
        foreach (['A', 'B', 'C', 'D'] as $i => $letter) {
            Answer::create([
                'question_id' => $question->id,
                'answer'      => "Réponse $letter",
                'is_correct'  => $i === $correctIndex,
            ]);
        }
    }

    /** Payload valide pour store/update. */
    private function validPayload(int $correct = 0): array
    {
        return [
            'question' => 'Quelle est la capitale de la France ?',
            'answers'  => [
                ['answer' => 'Paris'],
                ['answer' => 'Lyon'],
                ['answer' => 'Marseille'],
                ['answer' => 'Bordeaux'],
            ],
            'correct' => $correct,
        ];
    }

    private function adminUser(): User
    {
        // Adaptez le rôle selon votre implémentation (role, is_admin, etc.)
        return User::factory()->create(['role' => 'admin']);
    }

    // =========================================================================
    // create()
    // =========================================================================

    public function test_guest_cannot_access_create(): void
    {
        $theme = $this->makeTheme();

        $response = $this->get(route('admin.questions.create', $theme));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_access_create_view(): void
    {
        $theme = $this->makeTheme();

        $response = $this->actingAs($this->adminUser())
            ->get(route('admin.questions.create', $theme));

        $response->assertStatus(200);
        $response->assertViewIs('admin.questions.create');
        $response->assertViewHas('theme', $theme);
    }

    // =========================================================================
    // index()
    // =========================================================================

    public function test_guest_cannot_access_index(): void
    {
        $theme = $this->makeTheme();

        $response = $this->get(route('admin.questions.index', $theme));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_access_index_view(): void
    {
        $theme    = $this->makeTheme();
        $question = $this->makeQuestion($theme);
        $this->makeAnswers($question);

        $response = $this->actingAs($this->adminUser())
            ->get(route('admin.questions.index', $theme));

        $response->assertStatus(200);
        $response->assertViewIs('admin.questions.index');
        $response->assertViewHas('theme', $theme);
        $response->assertViewHas('questions');
    }

    public function test_index_lists_questions_of_the_theme(): void
    {
        $theme      = $this->makeTheme();
        $otherTheme = Theme::create([
            'nom'         => 'Géographie',
            'slug'        => 'geographie',
            'icone'       => '🌍',
            'description' => 'Quiz sur la géographie',
        ]);

        $this->makeQuestion($theme, 'Question du bon thème');
        $this->makeQuestion($otherTheme, 'Question d\'un autre thème');

        $response = $this->actingAs($this->adminUser())
            ->get(route('admin.questions.index', $theme));

        $questions = $response->viewData('questions');
        $this->assertCount(1, $questions);
        $this->assertEquals('Question du bon thème', $questions->first()->question);
    }

    // =========================================================================
    // store()
    // =========================================================================

    public function test_guest_cannot_store_question(): void
    {
        $theme = $this->makeTheme();

        $response = $this->post(route('admin.questions.store', $theme), $this->validPayload());

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('questions', 0);
    }

    public function test_admin_can_store_a_valid_question(): void
    {
        $theme = $this->makeTheme();

        $response = $this->actingAs($this->adminUser())
            ->post(route('admin.questions.store', $theme), $this->validPayload());

        $response->assertRedirect(route('admin.questions.index', $theme));
        $response->assertSessionHas('success', 'Question ajoutée !');
        $this->assertDatabaseCount('questions', 1);
        $this->assertDatabaseHas('questions', ['question' => 'Quelle est la capitale de la France ?']);
    }

    public function test_store_creates_exactly_four_answers(): void
    {
        $theme = $this->makeTheme();

        $this->actingAs($this->adminUser())
            ->post(route('admin.questions.store', $theme), $this->validPayload());

        $question = Question::first();
        $this->assertCount(4, $question->answers);
    }

    public function test_store_marks_correct_answer(): void
    {
        $theme = $this->makeTheme();

        $this->actingAs($this->adminUser())
            ->post(route('admin.questions.store', $theme), $this->validPayload(correct: 2));

        $question = Question::with('answers')->first();

        $this->assertDatabaseHas('answers', [
            'question_id' => $question->id,
            'answer'      => 'Marseille',
            'is_correct'  => true,
        ]);

        // Les 3 autres ne doivent pas être correctes
        $this->assertEquals(1, $question->answers->where('is_correct', true)->count());
    }

    public function test_store_fails_validation_when_question_is_missing(): void
    {
        $theme   = $this->makeTheme();
        $payload = $this->validPayload();
        unset($payload['question']);

        $response = $this->actingAs($this->adminUser())
            ->post(route('admin.questions.store', $theme), $payload);

        $response->assertSessionHasErrors('question');
        $this->assertDatabaseCount('questions', 0);
    }

    public function test_store_fails_validation_when_answers_count_is_not_four(): void
    {
        $theme   = $this->makeTheme();
        $payload = $this->validPayload();
        $payload['answers'] = [['answer' => 'A'], ['answer' => 'B']]; // seulement 2

        $response = $this->actingAs($this->adminUser())
            ->post(route('admin.questions.store', $theme), $payload);

        $response->assertSessionHasErrors('answers');
        $this->assertDatabaseCount('questions', 0);
    }

    public function test_store_fails_validation_when_an_answer_text_is_missing(): void
    {
        $theme   = $this->makeTheme();
        $payload = $this->validPayload();
        $payload['answers'][1] = ['answer' => '']; // réponse vide

        $response = $this->actingAs($this->adminUser())
            ->post(route('admin.questions.store', $theme), $payload);

        $response->assertSessionHasErrors('answers.1.answer');
        $this->assertDatabaseCount('questions', 0);
    }

    public function test_store_fails_validation_when_correct_index_is_out_of_range(): void
    {
        $theme   = $this->makeTheme();
        $payload = $this->validPayload();
        $payload['correct'] = 5; // hors de [0, 3]

        $response = $this->actingAs($this->adminUser())
            ->post(route('admin.questions.store', $theme), $payload);

        $response->assertSessionHasErrors('correct');
        $this->assertDatabaseCount('questions', 0);
    }

    // =========================================================================
    // edit()
    // =========================================================================

    public function test_guest_cannot_access_edit(): void
    {
        $theme    = $this->makeTheme();
        $question = $this->makeQuestion($theme);

        $response = $this->get(route('admin.questions.edit', [$theme, $question]));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_access_edit_view(): void
    {
        $theme    = $this->makeTheme();
        $question = $this->makeQuestion($theme);
        $this->makeAnswers($question);

        $response = $this->actingAs($this->adminUser())
            ->get(route('admin.questions.edit', [$theme, $question]));

        $response->assertStatus(200);
        $response->assertViewIs('admin.questions.edit');
        $response->assertViewHas('theme', $theme);
        $response->assertViewHas('question');
    }

    public function test_edit_view_has_question_with_answers_loaded(): void
    {
        $theme    = $this->makeTheme();
        $question = $this->makeQuestion($theme);
        $this->makeAnswers($question);

        $response = $this->actingAs($this->adminUser())
            ->get(route('admin.questions.edit', [$theme, $question]));

        $viewQuestion = $response->viewData('question');
        $this->assertTrue($viewQuestion->relationLoaded('answers'));
        $this->assertCount(4, $viewQuestion->answers);
    }

    // =========================================================================
    // update()
    // =========================================================================

    public function test_guest_cannot_update_question(): void
    {
        $theme    = $this->makeTheme();
        $question = $this->makeQuestion($theme);

        $response = $this->put(
            route('admin.questions.update', [$theme, $question]),
            $this->validPayload()
        );

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('questions', ['id' => $question->id, 'question' => 'Question ?']);
    }

    public function test_admin_can_update_a_question(): void
    {
        $theme    = $this->makeTheme();
        $question = $this->makeQuestion($theme);
        $this->makeAnswers($question);

        $response = $this->actingAs($this->adminUser())
            ->put(route('admin.questions.update', [$theme, $question]), $this->validPayload());

        $response->assertRedirect(route('admin.questions.index', $theme));
        $response->assertSessionHas('success', 'Question modifiée !');
        $this->assertDatabaseHas('questions', [
            'id'       => $question->id,
            'question' => 'Quelle est la capitale de la France ?',
        ]);
    }

    public function test_update_replaces_old_answers_with_new_ones(): void
    {
        $theme    = $this->makeTheme();
        $question = $this->makeQuestion($theme);
        $this->makeAnswers($question); // 4 anciennes réponses

        $oldAnswerIds = $question->answers()->pluck('id');

        $this->actingAs($this->adminUser())
            ->put(route('admin.questions.update', [$theme, $question]), $this->validPayload());

        // Les anciennes réponses doivent avoir disparu
        foreach ($oldAnswerIds as $id) {
            $this->assertDatabaseMissing('answers', ['id' => $id]);
        }

        // 4 nouvelles réponses doivent exister
        $this->assertCount(4, $question->fresh()->answers);
    }

    public function test_update_marks_the_correct_answer(): void
    {
        $theme    = $this->makeTheme();
        $question = $this->makeQuestion($theme);
        $this->makeAnswers($question, correctIndex: 0);

        $this->actingAs($this->adminUser())
            ->put(route('admin.questions.update', [$theme, $question]), $this->validPayload(correct: 1));

        $question->load('answers');
        $correct = $question->answers->firstWhere('is_correct', true);

        $this->assertEquals('Lyon', $correct->answer);
        $this->assertEquals(1, $question->answers->where('is_correct', true)->count());
    }

    public function test_update_fails_validation_when_question_is_missing(): void
    {
        $theme    = $this->makeTheme();
        $question = $this->makeQuestion($theme);
        $payload  = $this->validPayload();
        unset($payload['question']);

        $response = $this->actingAs($this->adminUser())
            ->put(route('admin.questions.update', [$theme, $question]), $payload);

        $response->assertSessionHasErrors('question');
        $this->assertDatabaseHas('questions', ['id' => $question->id, 'question' => 'Question ?']);
    }

    public function test_update_fails_validation_when_answers_count_is_not_four(): void
    {
        $theme    = $this->makeTheme();
        $question = $this->makeQuestion($theme);
        $payload  = $this->validPayload();
        $payload['answers'] = [['answer' => 'Seule réponse']];

        $response = $this->actingAs($this->adminUser())
            ->put(route('admin.questions.update', [$theme, $question]), $payload);

        $response->assertSessionHasErrors('answers');
    }

    // =========================================================================
    // destroy()
    // =========================================================================

    public function test_guest_cannot_destroy_question(): void
    {
        $theme    = $this->makeTheme();
        $question = $this->makeQuestion($theme);

        $response = $this->delete(route('admin.questions.destroy', [$theme, $question]));

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('questions', ['id' => $question->id]);
    }

    public function test_admin_can_delete_a_question(): void
    {
        $theme    = $this->makeTheme();
        $question = $this->makeQuestion($theme);

        $response = $this->actingAs($this->adminUser())
            ->delete(route('admin.questions.destroy', [$theme, $question]));

        $response->assertRedirect(route('admin.questions.index', $theme));
        $response->assertSessionHas('success', 'Question supprimée !');
        $this->assertDatabaseMissing('questions', ['id' => $question->id]);
    }

    public function test_destroy_also_deletes_associated_answers(): void
    {
        $theme    = $this->makeTheme();
        $question = $this->makeQuestion($theme);
        $this->makeAnswers($question);

        $answerIds = $question->answers()->pluck('id');

        $this->actingAs($this->adminUser())
            ->delete(route('admin.questions.destroy', [$theme, $question]));

        foreach ($answerIds as $id) {
            $this->assertDatabaseMissing('answers', ['id' => $id]);
        }
    }
}