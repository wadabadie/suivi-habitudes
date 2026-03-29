@extends('layouts.app')
@section('title', 'Créer un compte')

@section('content')
<div class="hf-auth-wrapper">
    <div class="hf-auth-card" style="max-width:480px;">

        <div class="hf-auth-icon">
            <a class="navbar-brand" href="{{ auth()->check() ? route('habitudes.index') : route('welcome') }}" style="flex-shrink:0;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 160 40" width="130" height="32" aria-label="HabitFlow">
                <defs><linearGradient id="hfLg" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#1a7a4a"/><stop offset="100%" stop-color="#2ecc71"/></linearGradient></defs>
                <circle cx="20" cy="20" r="13" fill="none" stroke="url(#hfLg)" stroke-width="2.5"/>
                <path d="M20 9 A11 11 0 1 1 9.5 28.5" fill="none" stroke="url(#hfLg)" stroke-width="2" stroke-linecap="round" opacity="0.4"/>
                <path d="M13 20 L18 25 L27 15" fill="none" stroke="url(#hfLg)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                <text x="40" y="16" font-family="'Playfair Display',Georgia,serif" font-size="13" font-weight="700" fill="var(--hf-texte)" letter-spacing="0.3">Habit</text>
                <text x="40" y="32" font-family="'DM Sans',system-ui,sans-serif" font-size="10.5" font-weight="600" fill="#2ecc71" letter-spacing="2.5">FLOW</text>
            </svg>
        </a>
        </div>

        <h1 class="hf-auth-title">Créer un compte</h1>
        <p class="hf-auth-sub">Commence à construire tes meilleures habitudes dès aujourd'hui.</p>

        @if($errors->any())
            <div class="hf-alert hf-alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div style="margin-bottom:1.2rem;">
                <label class="hf-label">Nom complet</label>
                <input id="name" type="text" name="name" class="hf-input"
                       value="{{ old('name') }}" required autocomplete="name" autofocus
                       placeholder="Jean Dupont">
                @error('name')<div style="color:#e74c3c;font-size:0.8rem;margin-top:0.4rem;">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom:1.2rem;">
                <label class="hf-label">Adresse email</label>
                <input id="email" type="email" name="email" class="hf-input"
                       value="{{ old('email') }}" required autocomplete="email"
                       placeholder="toi@exemple.com">
                @error('email')<div style="color:#e74c3c;font-size:0.8rem;margin-top:0.4rem;">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom:1.2rem;">
                <label class="hf-label">Mot de passe</label>
                <input id="password" type="password" name="password" class="hf-input"
                       required autocomplete="new-password"
                       placeholder="Minimum 8 caractères">
                @error('password')<div style="color:#e74c3c;font-size:0.8rem;margin-top:0.4rem;">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom:1.8rem;">
                <label class="hf-label">Confirmer le mot de passe</label>
                <input id="password-confirm" type="password" name="password_confirmation" class="hf-input"
                       required autocomplete="new-password"
                       placeholder="••••••••">
            </div>

            <button type="submit" class="hf-btn hf-btn-primary" style="width:100%;border-radius:12px;padding:0.9rem;">
                Créer mon compte
            </button>

            <div style="text-align:center;margin-top:1.2rem;font-size:0.87rem;color:var(--hf-texte-muted);">
                Déjà un compte ?
                <a href="{{ route('login') }}" style="color:var(--hf-vert-clair);text-decoration:none;font-weight:600;">
                    Se connecter
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
