@extends('layouts.app')
@section('title', 'Mes Habitudes')

@section('content')
<div class="container hf-page">

    <div class="hf-page-header">
        <div>
            <h1 class="hf-page-title">Bonjour, <span>{{ Auth::user()->name }}</span></h1>
            <p class="hf-page-sub">
                {{ ucfirst(\Carbon\Carbon::now()->locale('fr')->isoFormat('dddd D MMMM YYYY')) }}
            </p>
        </div>
        <a href="{{ route('habitudes.create') }}" class="hf-btn hf-btn-primary">
            <svg style="width:14px;height:14px;stroke:currentColor;fill:none;" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nouvelle habitude
        </a>
    </div>

    @php
        $totalActives  = $habitudes->count();
        $faitesAujourd = $habitudes->where('faite_aujourdhui', true)->count();
        $meilleureSerie = $habitudes->max('serie_actuelle') ?? 0;
        $taux = $totalActives > 0 ? round($faitesAujourd / $totalActives * 100) : 0;
    @endphp

    <div class="hf-stat-grid">
        <div class="hf-stat-card">
            <div class="hf-stat-icon">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            </div>
            <div class="hf-stat-val">{{ $totalActives }}</div>
            <div class="hf-stat-label">Habitudes actives</div>
        </div>
        <div class="hf-stat-card">
            <div class="hf-stat-icon">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div class="hf-stat-val">{{ $faitesAujourd }}</div>
            <div class="hf-stat-label">Faites aujourd'hui</div>
        </div>
        <div class="hf-stat-card">
            <div class="hf-stat-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 14.5c-2.49 0-4.5-2.01-4.5-4.5S9.51 7.5 12 7.5s4.5 2.01 4.5 4.5-2.01 4.5-4.5 4.5z" fill="none" stroke-width="1.5"/><path d="M12 9v3l2 2" stroke-linecap="round"/></svg>
            </div>
            <div class="hf-stat-val">{{ $meilleureSerie }}</div>
            <div class="hf-stat-label">Meilleure série</div>
        </div>
        <div class="hf-stat-card">
            <div class="hf-stat-icon">
                <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
            <div class="hf-stat-val">{{ $taux }}%</div>
            <div class="hf-stat-label">Complétion du jour</div>
        </div>
    </div>

    @if($habitudes->isEmpty())
        <div class="hf-empty">
            <div class="hf-empty-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2zM8 12h8M12 8v8"/></svg>
            </div>
            <h2 class="hf-empty-title">Commence ton voyage</h2>
            <p class="hf-empty-sub">Tu n'as pas encore d'habitudes.<br>Crée ta première et commence à transformer ta vie.</p>
            <a href="{{ route('habitudes.create') }}" class="hf-btn hf-btn-primary">
                + Créer ma première habitude
            </a>
        </div>
    @else
        <div class="hf-hab-grid">
            @foreach($habitudes as $habitude)
            <div class="hf-hab-card">
                <div class="hf-hab-accent" style="background: {{ $habitude->couleur }};"></div>
                <div class="hf-hab-body">
                    <div class="hf-hab-top">
                        <div>
                            <div class="hf-hab-name">{{ $habitude->nom }}</div>
                            @if($habitude->description)
                                <div class="hf-hab-desc">{{ $habitude->description }}</div>
                            @endif
                        </div>
                        @if(!$habitude->faite_aujourdhui)
                            <form action="{{ route('habitudes.faite', $habitude) }}" method="POST">
                                @csrf
                                <button type="submit" class="hf-done-btn" title="Marquer comme faite">
                                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                </button>
                            </form>
                        @else
                            <div class="hf-done-btn done" title="Déjà faite aujourd'hui">
                                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                        @endif
                    </div>

                    <div class="hf-streak">
                        <svg class="hf-streak-icon" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                        <span class="hf-streak-val">{{ $habitude->serie_actuelle }} jour(s)</span>
                        <span class="hf-streak-label">de série</span>
                        <span class="hf-badge hf-badge-freq" style="margin-left:auto;">{{ $habitude->frequence }}</span>
                    </div>

                    <div style="margin-bottom:1rem;">
                        <div style="display:flex;justify-content:space-between;font-size:0.75rem;color:var(--hf-texte-muted);margin-bottom:0.4rem;">
                            <span>Progression</span>
                            <span>{{ min($habitude->serie_actuelle * 10, 100) }}%</span>
                        </div>
                        <div class="hf-progress">
                            <div class="hf-progress-fill"
                                 data-width="{{ min($habitude->serie_actuelle * 10, 100) }}%"
                                 style="width:0;background:{{ $habitude->couleur }};"></div>
                        </div>
                    </div>

                    <div class="hf-hab-actions">
                        <a href="{{ route('habitudes.edit', $habitude) }}" class="hf-btn-action">
                            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Modifier
                        </a>
                        <form action="{{ route('habitudes.destroy', $habitude) }}" method="POST"
                              style="flex:1" onsubmit="return confirm('Supprimer cette habitude ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="hf-btn-action danger w-100">
                                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
