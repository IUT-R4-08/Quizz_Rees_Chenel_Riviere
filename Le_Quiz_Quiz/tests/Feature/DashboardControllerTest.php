<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\QuizResult;
use App\Models\Theme;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase; 

    /** @test */
    public function test_an_unauthenticated_user_is_redirected_to_login()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function test_dashboard_displays_only_the_logged_in_users_results_and_calculates_correct_average()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $theme = Theme::factory()->create();

        QuizResult::factory()->create([
            'user_id' => $user->id,
            'theme_id' => $theme->id,
            'score' => 8,
            'total_questions' => 10, 
        ]);
        QuizResult::factory()->create([
            'user_id' => $user->id,
            'theme_id' => $theme->id,
            'score' => 5,
            'total_questions' => 10, 
        ]);

        QuizResult::factory()->create([
            'user_id' => $otherUser->id,
            'theme_id' => $theme->id,
            'score' => 10,
            'total_questions' => 10,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);

        $response->assertViewHas('results', function ($results) use ($user) {
            return $results->count() === 2 && 
                   $results->where('user_id', '!=', $user->id)->isEmpty();
        });

        $response->assertViewHas('average', 65.0);
    }

    /** @test */
    public function test_dashboard_does_not_crash_if_a_quiz_has_zero_questions()
    {
        $user = User::factory()->create();
        $theme = Theme::factory()->create();

        QuizResult::factory()->create([
            'user_id' => $user->id,
            'theme_id' => $theme->id,
            'score' => 0,
            'total_questions' => 0,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertViewHas('average', 0.0);
    }
}