<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        # Elements de test en attendant la base de donnée
        $themes = [
            ['nom' => 'Histoire', 'description' => 'Teste tes connaissances en histoire mondiale.', 'slug' => 'histoire'],
            ['nom' => 'Science', 'description' => 'Physique, chimie, biologie... à toi de jouer !', 'slug' => 'science'],
            ['nom' => 'Géographie', 'description' => 'Capitales, pays, fleuves et plus encore.', 'slug' => 'geographie'],
            ['nom' => 'Sport', 'description' => 'Football, tennis, JO... es-tu un expert ?', 'slug' => 'sport'],
            ['nom' => 'Cinéma', 'description' => 'Films, acteurs, réalisateurs célèbres.', 'slug' => 'cinema'],
            ['nom' => 'Musique', 'description' => 'Artistes, albums, genres musicaux.', 'slug' => 'musique'],
        ];

        return view('home', compact('themes'));
    }
}
