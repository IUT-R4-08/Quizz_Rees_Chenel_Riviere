# Quizz Quizz

[![Laravel Tests](https://github.com/IUT-R4-08/Quizz_Rees_Chenel_Riviere/actions/workflows/laravel.yml/badge.svg)](https://github.com/IUT-R4-08/Quizz_Rees_Chenel_Riviere/actions/workflows/laravel.yml)

## Description

**Quizz Quizz** est une application web développée avec **Laravel** permettant aux utilisateurs de tester leurs connaissances à travers différents thèmes de quizz.

Chaque thème est composé de plusieurs questions, chacune proposant quatre réponses dont une seule est correcte. Les résultats sont enregistrés afin que chaque utilisateur puisse consulter son historique et ses performances.

Le projet comprend également une interface d'administration permettant de gérer entièrement les thèmes et leurs questions.

### Fonctionnalités principales

- Authentification des utilisateurs
- Gestion des thèmes de quizz
- Gestion des questions et des réponses
- Passage des quizz
- Calcul automatique du score
- Enregistrement des résultats en base de données
- Tableau de bord personnel affichant l'historique des scores
- Interface d'administration sécurisée

---

## Contributeurs

- Chenel Noa
- Riviere Kyllian
- Rees Rémi

---

# Technologies utilisées

- PHP 8.3+
- Laravel 12
- SQLite
- Bootstrap 5
- PHPUnit
- GitHub Actions

---

# Installation

## 1. Cloner le projet

```bash
git clone https://github.com/IUT-R4-08/Quizz_Rees_Chenel_Riviere.git

cd Quizz_Rees_Chenel_Riviere
cd Le_Quiz_Quiz
```

## 2. Installer les dépendances PHP

```bash
composer install
```

## 3. Installer les dépendances JavaScript

```bash
npm install
```

## 4. Copier le fichier d'environnement

```bash
cp .env.example .env
```

Sous Windows :

```bash
copy .env.example .env
```

## 5. Générer la clé Laravel

```bash
php artisan key:generate
```

## 6. Lancer Vite

```bash
npm run dev
```

## 7. Démarrer le serveur

```bash
php artisan serve
```

Le projet sera accessible sur :

```
http://127.0.0.1:8000
```

---

# Initialisation de la base de données

Créer la base et exécuter les migrations :

```bash
php artisan migrate
```

Ou recréer complètement la base :

```bash
php artisan migrate:fresh
```

---

# Jeu de données (Seeders)

Pour remplir la base avec les données de démonstration :

```bash
php artisan migrate:fresh --seed
```

Le seeder crée notamment :

- un administrateur
- un utilisateur de test
- plusieurs thèmes
- plusieurs questions
- quatre réponses par question
- plusieurs résultats de quizz pour alimenter le dashboard

### Comptes créés

#### Administrateur

```
Email : admin@admin.com
Mot de passe : admin
```

#### Utilisateur

```
Email : user@test.com
Mot de passe : user
```

---

# Tests

Le projet possède des tests unitaires et fonctionnels couvrant :

- les modèles
- les contrôleurs
- les principales fonctionnalités métier

## Exécuter tous les tests

```bash
php artisan test
```

ou

```bash
vendor/bin/phpunit
```

## Exécuter un seul fichier

```bash
php artisan test tests/Feature/ThemeControllerTest.php
```

## Générer une base propre avant les tests

```bash
php artisan migrate:fresh --env=testing
```

---

# Interface administrateur

L'administrateur peut :

- créer un thème
- modifier un thème
- supprimer un thème
- ajouter des questions
- modifier les questions
- supprimer les questions

Chaque question possède :

- 4 réponses
- une seule bonne réponse

---

# Fonctionnement d'un quizz

1. L'utilisateur choisit un thème.
2. Les questions du thème sont chargées.
3. L'utilisateur répond aux questions.
4. Le score est calculé automatiquement.
5. Le résultat est enregistré en base.
6. Le dashboard affiche l'historique des parties.

---

# Dashboard

Chaque utilisateur dispose d'un tableau de bord personnel contenant :

- historique des quizz joués
- score obtenu
- thème concerné
- pourcentage de réussite
- moyenne générale

---

# Licence

Projet réalisé dans le cadre du module de Qualité.
