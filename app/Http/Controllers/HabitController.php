<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Notifications\FelicitationsSerie;
use App\Models\HabitLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HabitController extends Controller
{

    public function index()
    {
        $habitudes = Habit::where('utilisateur_id', Auth::id())
            ->where('est_actif', true)
            ->get();


        foreach ($habitudes as $habitude) {
            $habitude->faite_aujourdhui = $habitude->estFaiteAujourdhui();
            $habitude->serie_actuelle   = $habitude->obtenirSerie();
        }

        return view('habitudes.index', compact('habitudes'));
    }


    public function create()
    {
        return view('habitudes.creer');
    }


    public function store(Request $request)
    {
        $donnees = $request->validate([
            'nom'         => 'required|string|max:255',
            'description' => 'nullable|string',
            'frequence'   => 'required|in:quotidien,hebdomadaire',
            'couleur'     => 'nullable|string|max:7',
        ]);

        $donnees['utilisateur_id'] = Auth::id();
        $donnees['couleur']        = $donnees['couleur'] ?? '#4CAF50';

        Habit::create($donnees);

        return redirect()->route('habitudes.index')
            ->with('succes', 'Habitude créée avec succès !');
    }


    public function edit(Habit $habit)
    {

         $this->authorize('update', $habit);

        return view('habitudes.modifier', compact('habit'));
    }


    public function update(Request $request, Habit $habit)
    {
         $this->authorize('update', $habit);

        $donnees = $request->validate([
            'nom'         => 'required|string|max:255',
            'description' => 'nullable|string',
            'frequence'   => 'required|in:quotidien,hebdomadaire',
            'couleur'     => 'nullable|string|max:7',
        ]);

        $habit->update($donnees);

        return redirect()->route('habitudes.index')
            ->with('succes', 'Habitude modifiée avec succès !');
    }


    public function destroy(Habit $habit)
    {

        $this->authorize('update', $habit);

        $habit->update(['est_actif' => false]);

        return redirect()->route('habitudes.index')
            ->with('succes', 'Habitude supprimée.');
    }


    public function marquerFaite(Habit $habit)
    {
         $this->authorize('update', $habit);

        $dejaFaite = HabitLog::where('habit_id', $habit->id)
            ->whereDate('complete_le', today())
            ->exists();

        if (!$dejaFaite) {
            HabitLog::create([
                'habit_id'       => $habit->id,
                'utilisateur_id' => Auth::id(),
                'complete_le'    => today(),
            ]);

            $serie = $habit->obtenirSerie();
            if (in_array($serie, [3, 7, 14, 30])) {
                Auth::user()->notify(new FelicitationsSerie($habit->nom, $serie));
            }

            $message = 'Bravo cette habitude marquée comme faite ';
        } else {
            $message = 'Tu as déjà fait cette habitude aujourd\'hui !';
        }

        return redirect()->route('habitudes.index')
            ->with('succes', $message);
    }
}
