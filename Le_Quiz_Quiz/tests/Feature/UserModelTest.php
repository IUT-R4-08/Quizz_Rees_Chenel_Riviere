<?php

namespace Tests\Feature;

use App\Models\QuizResult;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_a_user_has_many_quiz_results()
    {
        $user = User::factory()->create();

        QuizResult::factory()->count(2)->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->quizResults);
        $this->assertInstanceOf(QuizResult::class, $user->quizResults->first());
    }

    /** @test */
    public function test_user_password_is_automatically_hashed()
    {
        $user = User::factory()->create([
            'password' => 'mon-mot-de-passe-secret',
        ]);

        $this->assertNotEquals('mon-mot-de-passe-secret', $user->password);
        
        $this->assertTrue(Hash::check('mon-mot-de-passe-secret', $user->password));
    }
}