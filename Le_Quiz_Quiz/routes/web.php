<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    Route::get('/quiz/{theme:slug}', [QuizController::class, 'show'])
        ->name('quiz.show');

    Route::post('/quiz/{theme:slug}', [QuizController::class, 'submit'])
        ->name('quiz.submit');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('themes', ThemeController::class);

    Route::get('/themes/{theme}/questions/create', [QuestionController::class, 'create'])
        ->name('questions.create');

    Route::post('/themes/{theme}/questions', [QuestionController::class, 'store'])
        ->name('questions.store');

    Route::get('/themes/{theme}/questions', [QuestionController::class, 'index'])
        ->name('questions.index');

    Route::get('/themes/{theme}/questions/{question}/edit', [QuestionController::class, 'edit'])
        ->name('questions.edit');

    Route::put('/themes/{theme}/questions/{question}', [QuestionController::class, 'update'])
        ->name('questions.update');

    Route::delete('/themes/{theme}/questions/{question}', [QuestionController::class, 'destroy'])
        ->name('questions.destroy');

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');
});



require __DIR__ . '/auth.php';
