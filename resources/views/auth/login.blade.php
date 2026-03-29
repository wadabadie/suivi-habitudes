@extends('layouts.app')
@section('title', 'Connexion')

@section('content')
<div class="hf-auth-wrapper">
    <div class="hf-auth-card">

        <div class="hf-auth-icon">
           <a class="navbar-brand" href="{{ auth()->check() ? route('habitudes.index') : route('welcome') }}" style="flex-shrink:0;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 160 40" width="500" height="72" aria-label="HabitFlow">
                <defs><linearGradient id="hfLg" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#1a7a4a"/><stop offset="100%" stop-color="#2ecc71"/></linearGradient></defs>
                <circle cx="20" cy="20" r="13" fill="none" stroke="url(#hfLg)" stroke-width="2.5"/>
                <path d="M20 9 A11 11 0 1 1 9.5 28.5" fill="none" stroke="url(#hfLg)" stroke-width="2" stroke-linecap="round" opacity="0.4"/>
                <path d="M13 20 L18 25 L27 15" fill="none" stroke="url(#hfLg)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                <text x="40" y="16" font-family="'Playfair Display',Georgia,serif" font-size="18" font-weight="700" fill="var(--hf-texte)" letter-spacing="0.3">Habit</text>
                <text x="40" y="32" font-family="'DM Sans',system-ui,sans-serif" font-size="15.5" font-weight="600" fill="#2ecc71" letter-spacing="2.5">FLOW</text>
            </svg>
        </a>
        </div>

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
