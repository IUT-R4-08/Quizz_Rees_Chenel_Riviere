<?php

namespace App\Http\Controllers;

use App\Models\QuizResult;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $results = QuizResult::with('theme')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $average = QuizResult::where('user_id', Auth::id())
            ->get()
            ->avg(fn($r) => $r->score / max($r->total_questions, 1) * 100);

        return view('dashboard', compact('results', 'average'));
    }
}