<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitLog;
use Illuminate\Support\Facades\Auth;

class StatistiqueController extends Controller
{
    public function index()
    {
        $utilisateurId = Auth::id();

        // Total des habitudes actives
        $totalHabitudes = Habit::where('utilisateur_id', $utilisateurId)
            ->where('est_actif', true)
            ->count();

        // Total des jours complétés
        $totalJoursCompletes = HabitLog::where('utilisateur_id', $utilisateurId)
            ->count();

        // Habitudes faites aujourd'hui
        $faitesAujourdhui = HabitLog::where('utilisateur_id', $utilisateurId)
            ->whereDate('complete_le', today())
            ->count();

        // Meilleure série parmi toutes les habitudes
        $habitudes = Habit::where('utilisateur_id', $utilisateurId)
            ->where('est_actif', true)
            ->get();

        $meilleureSerie = 0;
        $meilleureHabitude = null;

        foreach ($habitudes as $habitude) {
            $serie = $habitude->obtenirSerie();
            $habitude->serie_actuelle = $serie;
            if ($serie > $meilleureSerie) {
                $meilleureSerie = $serie;
                $meilleureHabitude = $habitude;
            }
        }

        // Données graphique 7 derniers jours
        $donnees7Jours = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $donnees7Jours[] = [
                'date'   => $date->format('d/m'),
                'nombre' => HabitLog::where('utilisateur_id', $utilisateurId)
                    ->whereDate('complete_le', $date)
                    ->count(),
            ];
        }

        // Taux de complétion aujourd'hui
        $tauxCompletion = $totalHabitudes > 0
            ? round(($faitesAujourdhui / $totalHabitudes) * 100)
            : 0;

        return view('statistiques.index', compact(
            'totalHabitudes',
            'totalJoursCompletes',
            'faitesAujourdhui',
            'meilleureSerie',
            'meilleureHabitude',
            'donnees7Jours',
            'tauxCompletion',
            'habitudes'
        ));
    }
}
