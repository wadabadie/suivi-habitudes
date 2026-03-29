@extends('layouts.app')
@section('title', 'Vérification 2FA')

@section('content')
<div class="hf-auth-wrapper">
    <div class="hf-auth-card">

        <div class="hf-auth-icon">
            <svg viewBox="0 0 24 24"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>
        </div>

        <h1 class="hf-auth-title">Vérification 2FA</h1>
        <p class="hf-auth-sub">
            Entre le code à 6 chiffres affiché<br>dans Google Authenticator.
        </p>

        @if($errors->any())
            <div class="hf-alert hf-alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('complete.registration') }}">
            @csrf
            <label class="hf-label">Code OTP</label>
            <input type="text" name="otp" class="hf-input hf-otp-input"
                   placeholder="000000" maxlength="6" pattern="\d{6}"
                   required autofocus inputmode="numeric">

            <div class="hf-timer">
                <div class="hf-timer-circle" id="timerCircle">
                    <span id="timerNum">30</span>
                </div>
                <span>Le code se renouvelle toutes les <span id="timerSpan">30</span> secondes</span>
            </div>

            <button type="submit" class="hf-btn hf-btn-primary" style="width:100%;border-radius:12px;padding:0.9rem;">
                Vérifier et accéder
            </button>
        </form>

        <div class="hf-info-box">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>Pas encore configuré Google Authenticator ?
                <a href="{{ route('show.qrcode') }}">Retourne à l'étape précédente</a>.
            </span>
        </div>
    </div>
</div>
@endsection
