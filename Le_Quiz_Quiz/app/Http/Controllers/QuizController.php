<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;
use App\Models\QuizResult;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function show(Theme $theme)
    {
        $theme->load('questions.answers');

        return view('quiz', compact('theme'));
    }

    public function submit(Request $request, Theme $theme)
    {
        $theme->load('questions.answers');

        $score = 0;

        foreach ($theme->questions as $question) {

            $selectedAnswer = $request->input('question_' . $question->id);

            $correctAnswer = $question->answers
                ->where('is_correct', true)
                ->first();

            if ($correctAnswer && $selectedAnswer == $correctAnswer->id) {
                $score++;
            }
        }

        QuizResult::create([
            'user_id' => Auth::id(),
            'theme_id' => $theme->id,
            'score' => $score,
            'total_questions' => $theme->questions->count(),
        ]);

        return view('quiz-result', [
            'theme' => $theme,
            'score' => $score,
            'total' => $theme->questions->count(),
        ]);
    }
}
