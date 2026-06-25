<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function create(Theme $theme)
    {
        return view('admin.questions.create', compact('theme'));
    }

    public function index(Theme $theme)
    {
        $questions = $theme->questions()->with('answers')->get();

        return view('admin.questions.index', compact('theme', 'questions'));
    }

    public function store(Request $request, Theme $theme)
    {
        $request->validate([
            'question' => 'required|string',
            'answers' => 'required|array|size:4',
            'answers.*.answer' => 'required|string',
            'correct' => 'required|integer|min:0|max:3',
        ]);

        $question = $theme->questions()->create([
            'question' => $request->question,
        ]);

        foreach ($request->answers as $index => $data) {
            $question->answers()->create([
                'answer' => $data['answer'],
                'is_correct' => $index == $request->correct,
            ]);
        }

        return redirect()
            ->route('admin.questions.index', $theme)
            ->with('success', 'Question ajoutée !');
    }

    public function edit(Theme $theme, Question $question)
    {
        $question->load('answers');

        return view('admin.questions.edit', compact('theme', 'question'));
    }

    public function update(Request $request, Theme $theme, Question $question)
    {
        $request->validate([
            'question' => 'required|string',
            'answers' => 'required|array|size:4',
            'answers.*.answer' => 'required|string',
            'correct' => 'required|integer|min:0|max:3',
        ]);

        $question->update([
            'question' => $request->question,
        ]);

        $question->answers()->delete();

        foreach ($request->answers as $index => $data) {
            $question->answers()->create([
                'answer' => $data['answer'],
                'is_correct' => $index == $request->correct,
            ]);
        }

        return redirect()
            ->route('admin.questions.index', $theme)
            ->with('success', 'Question modifiée !');
    }

    public function destroy(Theme $theme, Question $question)
    {
        $question->delete();

        return redirect()
            ->route('admin.questions.index', $theme)
            ->with('success', 'Question supprimée !');
    }
}