@extends('layouts.app')
@section('title', 'Habitudes de ' . $user->name)

@section('content')
<div class="container hf-page">

    <div class="hf-page-header">
        <div style="display:flex;align-items:center;gap:1.2rem;">
            <div class="hf-avatar" style="width:52px;height:52px;font-size:1.3rem;font-weight:800;flex-shrink:0;">
                {{ strtoupper(substr($user->name,0,1)) }}
            </div>
            <div>
                <h1 class="hf-page-title" style="font-size:1.4rem;">{{ $user->name }}</h1>
                <p class="hf-page-sub">{{ $habitudes->count() }} habitude(s) active(s)</p>
            </div>
        </div>
        <a href="{{ route('amis.index') }}" class="hf-btn hf-btn-ghost">
            ← Retour
        </a>
    </div>

    @if($habitudes->isEmpty())
        <div class="hf-empty">
            <div class="hf-empty-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2z"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
            </div>
            <p class="hf-empty-sub">{{ $user->name }} n'a pas encore d'habitudes.</p>
        </div>
    @else
        <div class="hf-hab-grid">
            @foreach($habitudes as $habitude)
            <div class="hf-hab-card hf-card-hover">
                <div class="hf-hab-accent" style="background:{{ $habitude->couleur }};"></div>
                <div class="hf-hab-body">
                    <div class="hf-hab-name">{{ $habitude->nom }}</div>
                    @if($habitude->description)
                        <div class="hf-hab-desc" style="margin-bottom:0.8rem;">{{ $habitude->description }}</div>
                    @endif
                    <div class="hf-streak" style="margin-bottom:0;">
                        <svg class="hf-streak-icon" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                        <span class="hf-streak-val">{{ $habitude->serie_actuelle }} jour(s)</span>
                        <span class="hf-badge hf-badge-freq" style="margin-left:auto;">{{ $habitude->frequence }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
