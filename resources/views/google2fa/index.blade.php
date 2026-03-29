@extends('layouts.app')
@section('content')
<style>
    .auth-wrapper {
        min-height: 80vh;
        display: flex; align-items: center; justify-content: center;
        padding: 2rem 1rem;
    }
    .auth-card {
        width: 100%; max-width: 420px;
        background: #161b22;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 24px;
        padding: 2.5rem;
    }
    .auth-icon {
        width: 64px; height: 64px;
        background: rgba(46,204,113,0.1);
        border: 1px solid rgba(46,204,113,0.2);
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem; margin: 0 auto 1.5rem;
    }
    .auth-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem; font-weight: 800;
        text-align: center; margin-bottom: 0.5rem;
        color: #e6edf3;
    }
    .auth-sub {
        text-align: center; color: rgba(255,255,255,0.5);
        font-size: 0.9rem; margin-bottom: 2rem; line-height: 1.6;
    }
    .erreur-box {
        background: rgba(231,76,60,0.1);
        border: 1px solid rgba(231,76,60,0.25);
        color: #e74c3c; border-radius: 12px;
        padding: 0.8rem 1rem; margin-bottom: 1.5rem;
        font-size: 0.85rem;
    }
    .form-label-custom {
        display: block; font-size: 0.78rem; font-weight: 600;
        color: rgba(255,255,255,0.45);
        text-transform: uppercase; letter-spacing: 0.07em;
        margin-bottom: 0.6rem;
    }
    .otp-input {
        width: 100%;
        background: #1c2333;
        border: 2px solid rgba(255,255,255,0.08);
        border-radius: 16px;
        color: #e6edf3;
        padding: 1rem;
        font-size: 2rem; font-weight: 700;
        text-align: center; letter-spacing: 0.5em;
        font-family: monospace;
        transition: all .2s; outline: none;
        margin-bottom: 1.5rem;
    }
    .otp-input:focus {
        border-color: rgba(46,204,113,0.5);
        box-shadow: 0 0 0 3px rgba(46,204,113,0.1);
    }
    .otp-input::placeholder { color: rgba(255,255,255,0.15); font-size: 1.5rem; }
    .timer-box {
        display: flex; align-items: center; justify-content: center;
        gap: 0.5rem; margin-bottom: 1.5rem;
        color: rgba(255,255,255,0.45); font-size: 0.85rem;
    }
    .timer-circle {
        width: 32px; height: 32px; border-radius: 50%;
        background: conic-gradient(#2ecc71 var(--prog, 100%), rgba(255,255,255,0.08) 0);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.7rem; font-weight: 700; color: #2ecc71;
    }
    .btn-login {
        display: block; width: 100%;
        background: #1a7a4a; color: #fff;
        padding: 0.9rem; border-radius: 12px;
        text-align: center; font-size: 1rem; font-weight: 600;
        border: none; cursor: pointer;
        transition: all .25s; font-family: 'DM Sans', sans-serif;
    }
    .btn-login:hover { background: #2ecc71; transform: translateY(-2px); }
    @media(max-width:480px) {
        .auth-card { padding: 1.5rem; }
        .otp-input { font-size: 1.5rem; }
    }
</style>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-icon">🔐</div>
        <h1 class="auth-title">Authentification</h1>
        <p class="auth-sub">
            Entre le code généré par<br>
            <strong style="color:#e6edf3;">Google Authenticator</strong>
        </p>

        @if($errors->any())
            <div class="erreur-box">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('2fa') }}" method="POST">
            @csrf
            <label class="form-label-custom">Code à 6 chiffres</label>
            <input type="text" name="one_time_password" class="otp-input"
                   placeholder="000000" maxlength="6"
                   required autofocus inputmode="numeric"
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">

            <div class="timer-box">
                <div class="timer-circle" id="timerCircle">
                    <span id="timerNum">30</span>
                </div>
                <span>Code valable <span id="timerSpan">30</span> secondes</span>
            </div>

            <button type="submit" class="btn-login">
                Se connecter →
            </button>
        </form>
    </div>
</div>

<script>
let secondes = 30 - (Math.floor(Date.now() / 1000) % 30);
const num = document.getElementById('timerNum');
const span = document.getElementById('timerSpan');
const cercle = document.getElementById('timerCircle');

function mettreAJourTimer() {
    num.textContent = secondes;
    if(span) span.textContent = secondes;
    cercle.style.setProperty('--prog', (secondes / 30 * 100) + '%');
    if (secondes === 0) secondes = 30;
    else secondes--;
}
mettreAJourTimer();
setInterval(mettreAJourTimer, 1000);
</script>
@endsection
