@extends('layouts.app')
@section('title', 'Créer un compte')

@section('content')
<div class="hf-auth-wrapper">
    <div class="hf-auth-card" style="max-width:480px;">

        <div class="hf-auth-icon">
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
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
