<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NouvelleDemandeAmi;
use App\Notifications\DemandeAcceptee;

class FriendController extends Controller
{
    public function index()
    {
        $amis = Friend::where(function($requete) {
                $requete->where('utilisateur_id', Auth::id())
                        ->orWhere('ami_id', Auth::id());
            })
            ->where('statut', 'accepte')
            ->with(['utilisateur', 'ami'])
            ->get();

        $demandesRecues = Friend::where('ami_id', Auth::id())
            ->where('statut', 'en_attente')
            ->with('utilisateur')
            ->get();

        $demandesEnvoyees = Friend::where('utilisateur_id', Auth::id())
            ->where('statut', 'en_attente')
            ->with('ami')
            ->get();

        return view('amis.index', compact('amis', 'demandesRecues', 'demandesEnvoyees'));
    }


    public function rechercher(Request $request)
    {
        $donnees = $request->validate([
            'email' => 'required|email'
        ]);


        $utilisateur = User::where('email', $donnees['email'])
            ->where('id', '!=', Auth::id())
            ->first();

        if (!$utilisateur) {
            return back()->with('erreur', 'Aucun utilisateur trouvé avec cet email.');
        }


        $dejaAmis = Friend::where(function($requete) use ($utilisateur) {
                $requete->where('utilisateur_id', Auth::id())
                        ->where('ami_id', $utilisateur->id);
            })
            ->orWhere(function($requete) use ($utilisateur) {
                $requete->where('utilisateur_id', $utilisateur->id)
                        ->where('ami_id', Auth::id());
            })
            ->exists();

        if ($dejaAmis) {
            return back()->with('erreur', 'Une demande existe déjà avec cet utilisateur.');
        }

        return view('amis.recherche', compact('utilisateur'));
    }


    public function envoyerDemande(Request $request)
    {
        $donnees = $request->validate([
            'ami_id' => 'required|exists:users,id'
        ]);

        Friend::create([
            'utilisateur_id' => Auth::id(),
            'ami_id'         => $donnees['ami_id'],
            'statut'         => 'en_attente',
        ]);

        $ami = User::find($donnees['ami_id']);
        $ami->notify(new NouvelleDemandeAmi(Auth::user()));

        return redirect()->route('amis.index')
            ->with('succes', 'Demande d\'amitié envoyée !');
    }


    public function accepterDemande(Friend $friend)
    {

        if ($friend->ami_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        $friend->update(['statut' => 'accepte']);

        $friend->utilisateur->notify(new DemandeAcceptee(Auth::user()));

        return redirect()->route('amis.index')
            ->with('succes', 'Demande d\'amitié acceptée !');
    }


    public function supprimerAmi(Friend $friend)
    {

        if ($friend->utilisateur_id !== Auth::id() && $friend->ami_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        $friend->delete();

        return redirect()->route('amis.index')
            ->with('succes', 'Ami supprimé.');
    }


    public function voirHabitudes(User $user)
    {

        $sontAmis = Friend::where(function($requete) use ($user) {
                $requete->where('utilisateur_id', Auth::id())
                        ->where('ami_id', $user->id);
            })
            ->orWhere(function($requete) use ($user) {
                $requete->where('utilisateur_id', $user->id)
                        ->where('ami_id', Auth::id());
            })
            ->where('statut', 'accepte')
            ->exists();

        if (!$sontAmis) {
            abort(403, 'Vous n\'êtes pas amis.');
        }

        $habitudes = $user->habitudes()
            ->where('est_actif', true)
            ->get();

        foreach ($habitudes as $habitude) {
            $habitude->serie_actuelle = $habitude->obtenirSerie();
        }

        return view('amis.habitudes', compact('user', 'habitudes'));
    }

}
