<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Utilisateur admin par défaut
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@test.com'],
            [
                'name' => 'user',
                'password' => Hash::make('user'),
            ]
        );

        $this->call([
            ThemeQuizSeeder::class,
            QuizResultSeeder::class,
        ]);
    }
}