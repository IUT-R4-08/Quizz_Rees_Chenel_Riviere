<?php

use Illuminate\Support\Facades\Route;

Route::get('/quiz/test', function () {
    // On simule ce que la BDD renverra plus tard
    $quizFakeData = [
        'title' => 'Quiz Culture Web',
        'questions' => [
            [
                'id' => 1,
                'text' => 'Que signifie l\'acronyme CSS ?',
                'choices' => [
                    'Cascading Style Sheets',
                    'Creative Style System',
                    'Computer Science Symbols'
                ]
            ],
            [
                'id' => 2,
                'text' => 'Quel langage utilise le framework Laravel ?',
                'choices' => [
                    'Python',
                    'PHP',
                    'JavaScript',
                    'Ruby'
                ]
            ]
        ]
    ];

    // On envoie les données à la vue 'quiz'
    return view('quiz', ['quiz' => $quizFakeData]);
});