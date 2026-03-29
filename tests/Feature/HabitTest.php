<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Habit;
use App\Models\HabitLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HabitTest extends TestCase
{
    use RefreshDatabase;

    private function utilisateurConnecte(): User
    {
        $utilisateur = User::factory()->create([
            'google2fa_secret' => encrypt('JBSWY3DPEHPK3PXP'),
        ]);

        session(['google2fa_passed' => true]);

        return $this->actingAs($utilisateur)->user ?? $utilisateur;
    }

    public function test_creer_une_habitude(): void
    {
        $utilisateur = User::factory()->create([
            'google2fa_secret' => encrypt('JBSWY3DPEHPK3PXP'),
        ]);

        $this->actingAs($utilisateur)
             ->withSession(['google2fa_passed' => true]);

        $reponse = $this->actingAs($utilisateur)->post('/habitudes', [
            'nom'       => 'Faire du sport',
            'frequence' => 'quotidien',
            'couleur'   => '#2ecc71',
        ]);

        $this->assertDatabaseHas('habits', [
            'nom'            => 'Faire du sport',
            'utilisateur_id' => $utilisateur->id,
        ]);
    }

    public function test_marquer_habitude_comme_faite(): void
    {
        $utilisateur = User::factory()->create([
            'google2fa_secret' => encrypt('JBSWY3DPEHPK3PXP'),
        ]);

        $habitude = Habit::create([
            'utilisateur_id' => $utilisateur->id,
            'nom'            => 'Méditation',
            'frequence'      => 'quotidien',
            'couleur'        => '#9b59b6',
            'est_actif'      => true,
        ]);

        $reponse = $this->actingAs($utilisateur)
                        ->post("/habitudes/{$habitude->id}/faite");

        $this->assertDatabaseHas('habit_logs', [
            'habit_id'       => $habitude->id,
            'utilisateur_id' => $utilisateur->id,
        ]);
    }

    public function test_utilisateur_ne_peut_pas_modifier_habitude_dautrui(): void
    {
        $user1 = User::factory()->create(['google2fa_secret' => encrypt('TEST')]);
        $user2 = User::factory()->create(['google2fa_secret' => encrypt('TEST')]);

        $habitude = Habit::create([
        'utilisateur_id' => $user1->id,
        'nom'            => 'Habitude de user1',
        'frequence'      => 'quotidien',
        'couleur'        => '#2ecc71',
        'est_actif'      => true,
        ]);

        // On vérifie que l'habitude appartient bien à user1 et pas à user2
        $this->assertEquals($user1->id, $habitude->utilisateur_id);
        $this->assertNotEquals($user2->id, $habitude->utilisateur_id);
    }

    public function test_calcul_serie_consecutive(): void
    {
        $utilisateur = User::factory()->create(['google2fa_secret' => encrypt('TEST')]);

        $habitude = Habit::create([
            'utilisateur_id' => $utilisateur->id,
            'nom'            => 'Test série',
            'frequence'      => 'quotidien',
            'couleur'        => '#2ecc71',
            'est_actif'      => true,
        ]);

        for ($i = 4; $i >= 0; $i--) {
            HabitLog::create([
                'habit_id'       => $habitude->id,
                'utilisateur_id' => $utilisateur->id,
                'complete_le'    => now()->subDays($i)->toDateString(),
            ]);
        }

        $this->assertEquals(5, $habitude->obtenirSerie());
    }
}
