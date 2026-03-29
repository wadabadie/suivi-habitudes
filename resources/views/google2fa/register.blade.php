@extends('layouts.app')
@section('title', 'Configuration 2FA')

@section('content')
<div class="hf-auth-wrapper">
    <div class="hf-auth-card">

        <div class="hf-auth-icon">
            <svg viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
        </div>

        <h1 class="hf-auth-title">Configuration 2FA</h1>
        <p class="hf-auth-sub">
            Scanne le QR code avec Google Authenticator<br>pour sécuriser ton compte.
        </p>

        {{-- QR Code --}}
        <div class="hf-qr-wrap">
            {!! $QR_Image !!}
        </div>

        {{-- Clé secrète --}}
        <div class="hf-secret-box">
            <div>
                <div class="hf-secret-label">Clé manuelle</div>
                <div class="hf-secret-val" id="secretKey">{{ $secret }}</div>
            </div>
            <button class="hf-btn hf-btn-success hf-copy-btn" onclick="copierSecret()">
                Copier
            </button>
        </div>

        {{-- Étapes --}}
        <div class="hf-steps">
            <div class="hf-step">
                <div class="hf-step-num">1</div>
                <p class="hf-step-text">Installe <strong>Google Authenticator</strong> sur ton téléphone.</p>
            </div>
            <div class="hf-step">
                <div class="hf-step-num">2</div>
                <p class="hf-step-text">Scanne le QR code ci-dessus ou entre la clé manuellement.</p>
            </div>
            <div class="hf-step">
                <div class="hf-step-num">3</div>
                <p class="hf-step-text">Clique sur <strong>Suivant</strong> et entre le code à 6 chiffres généré.</p>
            </div>
        </div>

        <a href="{{ route('verify.2fa') }}" class="hf-btn hf-btn-primary" style="width:100%;border-radius:12px;padding:0.9rem;display:block;text-align:center;">
            Suivant — Vérifier le code
        </a>
    </div>
</div>
@endsection

