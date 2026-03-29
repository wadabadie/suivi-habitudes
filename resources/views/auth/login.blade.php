@extends('layouts.app')
@section('title', 'Connexion')

@section('content')
<div class="hf-auth-wrapper">
    <div class="hf-auth-card">


        <h1 class="hf-auth-title">Bon retour</h1>
        <p class="hf-auth-sub">Connecte-toi pour reprendre là où tu t'es arrêté.</p>

        @if($errors->any())
            <div class="hf-alert hf-alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div style="margin-bottom:1.2rem;">
                <label class="hf-label">Adresse email</label>
                <input id="email" type="email" name="email" class="hf-input"
                       value="{{ old('email') }}" required autocomplete="email" autofocus
                       placeholder="toi@exemple.com">
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="hf-label">Mot de passe</label>
                <input id="password" type="password" name="password" class="hf-input"
                       required autocomplete="current-password"
                       placeholder="••••••••">
            </div>

            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:0.5rem;">
                <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;font-size:0.85rem;color:var(--hf-texte-muted);">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                           style="width:15px;height:15px;accent-color:var(--hf-vert-clair);">
                    Se souvenir de moi
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size:0.85rem;color:var(--hf-vert-clair);text-decoration:none;">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>

            <button type="submit" class="hf-btn hf-btn-primary" style="width:100%;border-radius:12px;padding:0.9rem;">
                Se connecter
            </button>

            <div style="text-align:center;margin-top:1.2rem;font-size:0.87rem;color:var(--hf-texte-muted);">
                Pas encore de compte ?
                <a href="{{ route('register') }}" style="color:var(--hf-vert-clair);text-decoration:none;font-weight:600;">
                    Créer un compte
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
