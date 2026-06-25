<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Theme;
use App\Models\Question;

class ThemeQuizSeeder extends Seeder
{
    public function run(): void
    {
        $histoire = Theme::firstOrCreate([
            'slug' => 'histoire'
        ], [
            'nom' => 'Histoire',
            'icone' => '📜',
            'description' => 'Teste tes connaissances en histoire.'
        ]);

        $this->createQuestion($histoire, 'En quelle année a eu lieu la Révolution française ?', [
            '1789' => true,
            '1815' => false,
            '1914' => false,
            '1492' => false,
        ]);

        $this->createQuestion($histoire, 'Qui était le premier empereur romain ?', [
            'Auguste' => true,
            'Jules César' => false,
            'Néron' => false,
            'Caligula' => false,
        ]);

        $this->createQuestion($histoire, 'En quelle année a eu lieu la chute du mur de Berlin ?', [
            '1989' => true,
            '1975' => false,
            '1991' => false,
            '1961' => false,
        ]);

        $this->createQuestion($histoire, 'Qui a découvert l’Amérique en 1492 ?', [
            'Christophe Colomb' => true,
            'Magellan' => false,
            'Vasco de Gama' => false,
            'Marco Polo' => false,
        ]);

        $science = Theme::firstOrCreate([
            'slug' => 'science'
        ], [
            'nom' => 'Science',
            'icone' => '🔬',
            'description' => 'Physique, chimie et biologie.'
        ]);

        $this->createQuestion($science, 'Quelle est la formule de l’eau ?', [
            'H2O' => true,
            'CO2' => false,
            'O2' => false,
            'NaCl' => false,
        ]);

        $this->createQuestion($science, 'Quelle planète est la plus proche du soleil ?', [
            'Mercure' => true,
            'Vénus' => false,
            'Terre' => false,
            'Mars' => false,
        ]);

        $this->createQuestion($science, 'Quel organe pompe le sang ?', [
            'Le cœur' => true,
            'Le foie' => false,
            'Le cerveau' => false,
            'Les poumons' => false,
        ]);

        $this->createQuestion($science, 'Quelle est l’unité de mesure de la force ?', [
            'Newton' => true,
            'Joule' => false,
            'Watt' => false,
            'Pascal' => false,
        ]);
    }

    private function createQuestion($theme, $questionText, array $answers)
    {
        $question = $theme->questions()->create([
            'question' => $questionText
        ]);

        foreach ($answers as $text => $isCorrect) {
            $question->answers()->create([
                'answer' => $text,
                'is_correct' => $isCorrect
            ]);
        }
    }
}