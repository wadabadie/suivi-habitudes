<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_page_connexion_saffiche(): void
    {
        $reponse = $this->get('/login');
        $reponse->assertStatus(200);
    }

    public function test_utilisateur_non_connecte_redirige(): void
    {
        $reponse = $this->get('/habitudes');
        $reponse->assertRedirect('/login');
    }

    public function test_connexion_avec_bons_identifiants(): void
    {
        $utilisateur = User::factory()->create([
            'password'         => bcrypt('password'),
            'google2fa_secret' => encrypt('JBSWY3DPEHPK3PXP'),
        ]);

        $reponse = $this->post('/login', [
            'email'    => $utilisateur->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
    }
}
