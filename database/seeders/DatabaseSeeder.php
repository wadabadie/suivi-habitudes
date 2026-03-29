<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Habit;
use App\Models\HabitLog;
use App\Models\Friend;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Créeons 2 utilisateurs de démo
        $user1 = User::create([
            'name'              => 'Alice Martin',
            'email'             => 'alice@demo.com',
            'password'          => Hash::make('password'),
            'google2fa_secret'  => encrypt('JBSWY3DPEHPK3PXP'),
        ]);

        $user2 = User::create([
            'name'              => 'Bob Dupont',
            'email'             => 'bob@demo.com',
            'password'          => Hash::make('password'),
            'google2fa_secret'  => encrypt('JBSWY3DPEHPK3PXP'),
        ]);

        // Habitudes pour Alice
        $habitudes = [
            ['nom' => 'Faire du sport',    'couleur' => '#e74c3c', 'frequence' => 'quotidien',    'description' => '30 minutes de course'],
            ['nom' => 'Lire 30 minutes',   'couleur' => '#3498db', 'frequence' => 'quotidien',    'description' => 'Lire avant de dormir'],
            ['nom' => 'Méditation',        'couleur' => '#9b59b6', 'frequence' => 'quotidien',    'description' => '10 minutes le matin'],
            ['nom' => 'Boire 2L d\'eau',   'couleur' => '#1abc9c', 'frequence' => 'quotidien',    'description' => '8 verres par jour'],
            ['nom' => 'Cours en ligne',    'couleur' => '#f39c12', 'frequence' => 'hebdomadaire', 'description' => 'Une leçon par semaine'],
        ];

        foreach ($habitudes as $data) {
            $habit = Habit::create([
                'utilisateur_id' => $user1->id,
                'nom'            => $data['nom'],
                'couleur'        => $data['couleur'],
                'frequence'      => $data['frequence'],
                'description'    => $data['description'],
                'est_actif'      => true,
            ]);

            // Logs sur les 14 derniers jours
            for ($i = 13; $i >= 1; $i--) {
                if (rand(0, 4) > 0) {
                    HabitLog::create([
                        'habit_id'       => $habit->id,
                        'utilisateur_id' => $user1->id,
                        'complete_le'    => now()->subDays($i)->toDateString(),
                    ]);
                }
            }
        }

        // Habitudes pour Bob
        $habitudesBob = [
            ['nom' => 'Guitare',      'couleur' => '#e67e22', 'frequence' => 'quotidien', 'description' => '20 minutes de pratique'],
            ['nom' => 'Marche',       'couleur' => '#2ecc71', 'frequence' => 'quotidien', 'description' => '10 000 pas par jour'],
        ];

        foreach ($habitudesBob as $data) {
            $habit = Habit::create([
                'utilisateur_id' => $user2->id,
                'nom'            => $data['nom'],
                'couleur'        => $data['couleur'],
                'frequence'      => $data['frequence'],
                'description'    => $data['description'],
                'est_actif'      => true,
            ]);

            for ($i = 7; $i >= 1; $i--) {
                HabitLog::create([
                    'habit_id'       => $habit->id,
                    'utilisateur_id' => $user2->id,
                    'complete_le'    => now()->subDays($i)->toDateString(),
                ]);
            }
        }

        // Relation d'amitié entre Alice et Bob
        Friend::create([
            'utilisateur_id' => $user1->id,
            'ami_id'         => $user2->id,
            'statut'         => 'accepte',
        ]);
    }
}
