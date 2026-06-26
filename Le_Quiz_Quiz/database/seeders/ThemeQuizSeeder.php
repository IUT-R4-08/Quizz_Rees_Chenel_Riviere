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

        $clair_obscur = Theme::firstOrCreate([
            'slug' => 'clair-obscur'
        ], [
            'nom' => 'Clair Obscur',
            'icone' => '🎮',
            'description' => 'Teste tes connaissances sur le jeu Clair Obscur : Expédition 33.'
        ]);

        $this->createQuestion($clair_obscur, 'Quel artiste a composé les musiques du jeu Clair Obscur Expédition 33 ?', [
            'Lorien Testard' => true,
            'Hans Zimmer' => false,
            'Boule & Bill' => false,
            'Madame Claire Obscur' => false,
        ]);

        $this->createQuestion($clair_obscur, 'Dans quel pays a été développé le jeu Clair Obscur Expédition 33 ?', [
            'Etats-Unis' => false,
            'Japon' => false,    
            'France' => true,
            'Angleterre' => false,
        ]);

        $this->createQuestion($clair_obscur, 'Dans le jeu Clair obscur, quelle est la meilleure fin ?', [
            'La fin de Verso' => false,
            'La fin de maelle' => true,
        ]);

        $this->createQuestion($clair_obscur, 'Comment s’appelle la ville de départ ?', [
            'Argelès sur Mer' => false,
            'Hyrule' => false,
            'Coruscant' => false,
            'Lumière' => true,

        ]);

        $fortnite = Theme::firstOrCreate([
            'slug' => 'fortnite'
        ], [
            'nom' => 'Fortnite',
            'icone' => '🎮',
            'description' => 'Teste tes connaissances sur l\'univers de Fortnite.'
        ]);

        $this->createQuestion($fortnite, 'Dans Fortnite, quel événement majeur a marqué la fin du Chapitre 1 en aspirant toute la carte dans un point singulier, rendant le jeu indisponible pendant plusieurs heures ?', [
            'Le Cataclysme' => false,
            'Le Trou Noir' => true,
            'La Tempête parfaite' => false,
            'Le Big Bang' => false,
        ]);

        $this->createQuestion($fortnite, 'Quel est le nom de la monnaie virtuelle utilisée dans Fortnite ?', [
            'V-Bucks' => true,
            'Coins' => false,
            'Gold Pass' => false,
            'XP Tokens' => false,
        ]);

        $this->createQuestion($fortnite, 'Quel studio développe Fortnite ?', [
            'Ubisoft' => false,
            'Riot Games' => false,
            'Activision' => false,
            'Epic Games' => true,
        ]);

        $this->createQuestion($fortnite, 'Dans le mode Battle Royale, combien de joueurs participent généralement à une partie ?', [
            '20' => false,
            '50' => false,
            '100' => true,
            '75' => false,
        ]);

        $this->createQuestion($fortnite, 'Quel élément réduit progressivement la zone jouable pendant une partie ?', [
            'La tempête' => true,
            'Le brouillard' => false,
            'Le volcan' => false,
            'Le chrono' => false,
        ]);

        $this->createQuestion($fortnite, 'Quel mode de jeu permet principalement de construire et défendre une base contre des monstres ?', [
            'Créatif' => false,
            'Sauver le monde' => true,
            'Battle Royale' => false,
            'Arène' => false,
        ]);

        $this->createQuestion($fortnite, 'Quelle couleur indique généralement une arme légendaire dans le jeu ?', [
            'Verte' => false,
            'Bleue' => false,
            'Grise' => false,
            'Orange/Dorée' => true,
        ]);

        $this->createQuestion($fortnite, 'Quel véhicule aérien a déjà été présent dans le jeu ?', [
            'Hélicoptère' => true,
            'Sous-marin volant' => false,
            'Montgolfière de combat' => false,
            'Jetpack géant' => false,
        ]);

        $this->createQuestion($fortnite, 'Quel mode permet aux joueurs de créer leurs propres cartes et mini-jeux ?', [
            'Ranked' => false,
            'Escouade' => false,
            'Créatif' => true,
            'Tempête' => false,
        ]);

        $this->createQuestion($fortnite, 'Comment appelle-t-on l’action d’éliminer tous les autres joueurs pour gagner ?', [
            'Faire un top 50' => false,
            'Obtenir une Victory Royale' => true,
            'Monter de niveau' => false,
            'Capturer un point' => false,
        ]);

        $this->createQuestion($fortnite, 'Quel objet permet souvent de se déplacer rapidement dans les airs ?', [
            'Le tremplin' => true,
            'La pioche' => false,
            'Le coffre' => false,
            'Le buisson' => false,
        ]);

        $minecraft = Theme::firstOrCreate([
            'slug' => 'minecraft'
        ], [
            'nom' => 'Minecraft',
            'icone' => '⛏️',
            'description' => 'Teste tes connaissances sur l\'univers cubique de Minecraft.'
        ]);

        $this->createQuestion($minecraft, 'Dans Minecraft, quelle dimension obscure et stérile, accessible via un portail spécifique, abrite les Shulkers ?', [
            'L’End' => true,
            'L’Abîme' => false,
            'Le Nether' => false,
            'Le Deep Dark' => false,
        ]);

        $this->createQuestion($minecraft, 'Dans Minecraft, quel outil ou bloc est indispensable pour pouvoir extraire de la redstone ou des diamants sans détruire le minerai inutilement ?', [
            'Un piston collant' => false,
            'Une pioche en fer (ou supérieur)' => true,
            'Une pioche en or' => false,
            'Une pioche en pierre' => false,
        ]);

        $this->createQuestion($minecraft, 'Dans Minecraft, quel est le mob à l’origine de la création du Creeper suite à un bug de modélisation ?', [
            'La vache' => false,
            'Le zombie' => false,
            'Le squelette' => false,
            'Le cochon' => true,
        ]);

        $this->createQuestion($minecraft, 'Dans Minecraft, quel matériau est nécessaire pour fabriquer une table d’enchantement ?', [
            'De l’obsidienne' => true,
            'De la pierre taillée' => false,
            'Du cuivre' => false,
            'De la netherite' => false,
        ]);

        $this->createQuestion($minecraft, 'Dans Minecraft, quel mob peut échanger des objets avec le joueur grâce au troc (or) ?', [
            'Le Piglin' => true,
            'Le Villageois' => false,
            'Le Wither squelette' => false,
            'Le Ravageur' => false,
        ]);

        $this->createQuestion($minecraft, 'Dans Minecraft, quel objet permet de respirer plus longtemps sous l’eau lorsqu’il est enchanté avec “Respiration” ?', [
            'Les bottes' => false,
            'Le plastron' => false,
            'Le casque' => true,
            'Le bouclier' => false,
        ]);

        $this->createQuestion($minecraft, 'Dans Minecraft, quel boss faut-il vaincre pour obtenir une étoile du Nether ?', [
            'L’Ender Dragon' => false,
            'Le Gardien' => false,
            'Le Wither' => true,
            'Le Ghast' => false,
        ]);

        $this->createQuestion($minecraft, 'Dans Minecraft, quel bloc est nécessaire pour réaliser la structure d\'un portail du Nether ?', [
            'De la roche noire' => false,
            'De la pierre lisse' => false,
            'De la glowstone' => false,
            'De l’obsidienne' => true,
        ]);

        $this->createQuestion($minecraft, 'Dans Minecraft, quel animal peut être apprivoisé avec des os ?', [
            'Le loup' => true,
            'Le chat' => false,
            'Le cheval' => false,
            'Le lama' => false,
        ]);

        $this->createQuestion($minecraft, 'Dans Minecraft, quel minerai permet de fabriquer les objets les plus résistants du jeu (supérieurs au diamant) ?', [
            'Le diamant' => false,
            'La netherite' => true,
            'L’émeraude' => false,
            'Le quartz' => false,
        ]);

        $f1 = Theme::firstOrCreate([
            'slug' => 'formule-1'
        ], [
            'nom' => 'Formule 1',
            'icone' => '🏎️',
            'description' => 'Teste tes connaissances sur la catégorie reine du sport automobile.'
        ]);

        $this->createQuestion($f1, 'En Formule 1, que signifie l’affichage d’un drapeau noir et blanc divisé en diagonale présenté à un pilote ?', [
            'Un problème mécanique dangereux sur la monoplace' => false,
            'L’obligation de laisser passer un pilote plus rapide' => false,
            'Un avertissement pour comportement antisportif ou non-respect des limites de la piste' => true,
            'Une disqualification immédiate de la course' => false,
        ]);

        $this->createQuestion($f1, 'En Formule 1, quelle innovation technique majeure introduite en 2011 permet de réduire la traînée aérodynamique de la monoplace pour faciliter les dépassements en ligne droite ?', [
            'Le DRS (Drag Reduction System)' => true,
            'Le KERS / ERS' => false,
            'Le fond plat à effet de sol' => false,
            'Le système DAS' => false,
        ]);

        $this->createQuestion($f1, 'Quel pilote est détenteur du plus grand nombre de victoires en Formule 1 (et co-détenteur du record de titres mondiaux) ?', [
            'Michael Schumacher' => false,
            'Max Verstappen' => false,
            'Lance Stroll' => false,
            'Lewis Hamilton' => true,
        ]);

        $rugby = Theme::firstOrCreate([
            'slug' => 'rugby'
        ], [
            'nom' => 'Rugby',
            'icone' => '🏉',
            'description' => 'Teste tes connaissances sur les règles et l\'histoire du ballon ovale.'
        ]);

        $this->createQuestion($rugby, 'Au rugby à XV, quelle est la sanction immédiate pour un joueur commettant un en-avant volontaire pour intercepter une passe ?', [
            'Un coup de pied de pénalité (et souvent un carton jaune)' => true,
            'Une simple mêlée pour l’équipe adverse' => false,
            'Une exclusion définitive (carton rouge) systématique' => false,
            'Un coup de pied de franc-jeu' => false,
        ]);

        $this->createQuestion($rugby, 'Dans l\'histoire du Rugby des Six Nations, qu\'indique précisément l\'obtention d\'une \'Cuillère de bois\' ?', [
            'Une pénalité collective infligée pour indiscipline flagrante' => false,
            'Le trophée du meilleur marqueur d’essais du tournoi' => false,
            'La place du dernier du classement à la fin du tournoi' => true,
            'La victoire d’une équipe n’ayant encaissé aucun essai' => false,
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