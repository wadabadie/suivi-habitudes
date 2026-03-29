@extends('layouts.app')
@section('title', 'Résultat de recherche')

@section('content')
<div class="hf-auth-wrapper">
    <div class="hf-card" style="width:100%;max-width:420px;overflow:hidden;">

        
        <div style="height:72px;background:linear-gradient(135deg,var(--hf-vert),var(--hf-vert-clair));"></div>

        <div style="padding:0 2rem 2rem;text-align:center;">

            <div style="margin-top:-32px;margin-bottom:1rem;">
                <div class="hf-avatar" style="width:64px;height:64px;font-size:1.6rem;margin:0 auto;border:3px solid var(--hf-surface);">
                    {{ strtoupper(substr($utilisateur->name,0,1)) }}
                </div>
            </div>

            <h2 style="font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:800;margin-bottom:0.3rem;">
                {{ $utilisateur->name }}
            </h2>
            <p style="color:var(--hf-texte-muted);font-size:0.88rem;margin-bottom:1.2rem;">
                {{ $utilisateur->email }}
            </p>

            <div style="display:inline-flex;align-items:center;gap:0.4rem;background:rgba(46,204,113,0.08);border:1px solid rgba(46,204,113,0.15);color:var(--hf-vert-clair);padding:0.3rem 0.8rem;border-radius:50px;font-size:0.78rem;font-weight:600;margin-bottom:1.5rem;">
                <svg style="width:12px;height:12px;stroke:currentColor;fill:none;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Utilisateur trouvé
            </div>

            <div class="hf-divider"></div>

            <form action="{{ route('amis.envoyer') }}" method="POST" style="margin-bottom:0.8rem;">
                @csrf
                <input type="hidden" name="ami_id" value="{{ $utilisateur->id }}">
                <button type="submit" class="hf-btn hf-btn-primary" style="width:100%;border-radius:12px;padding:0.85rem;">
                    Envoyer une demande d'amitié
                    <svg style="width:14px;height:14px;stroke:currentColor;fill:none;" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </button>
            </form>

            <a href="{{ route('amis.index') }}" class="hf-btn hf-btn-ghost" style="width:100%;display:block;text-align:center;">
                Annuler
            </a>
        </div>
    </div>
</div>
@endsection
