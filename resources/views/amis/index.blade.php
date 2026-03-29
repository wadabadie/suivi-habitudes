@extends('layouts.app')
@section('title', 'Mes Amis')

@section('content')
<div class="container hf-page">

    <div class="hf-page-header">
        <div>
            <h1 class="hf-page-title">Mes <span>Amis</span></h1>
            <p class="hf-page-sub">{{ $amis->count() }} ami(s) · {{ $demandesRecues->count() }} demande(s) reçue(s)</p>
        </div>
    </div>

    <div class="hf-card" style="padding:1.5rem;margin-bottom:1.5rem;position:relative;overflow:hidden;">
        <div style="position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--hf-vert),var(--hf-vert-clair));"></div>
        <label class="hf-label">Ajouter un ami par email</label>
        <form action="{{ route('amis.rechercher.post') }}" method="POST">
            @csrf
            <div style="display:flex;gap:0.8rem;flex-wrap:wrap;">
                <input type="email" name="email" class="hf-input"
                       style="flex:1;min-width:200px;"
                       placeholder="exemple@email.com" required>
                <button type="submit" class="hf-btn hf-btn-primary" style="border-radius:12px;white-space:nowrap;">
                    Rechercher
                    <svg style="width:14px;height:14px;stroke:currentColor;fill:none;" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </button>
            </div>
        </form>
    </div>


    @if($demandesRecues->isNotEmpty())
    <div class="hf-card" style="margin-bottom:1.2rem;">
        <div class="hf-card-head">
            <div class="hf-section-dot" style="background:#f1c40f;"></div>
            <span class="hf-card-title">Demandes reçues</span>
            <span class="hf-card-badge">{{ $demandesRecues->count() }}</span>
        </div>
        @foreach($demandesRecues as $demande)
        <div class="hf-list-row">
            <div class="hf-list-left">
                <div class="hf-avatar">{{ strtoupper(substr($demande->utilisateur->name,0,1)) }}</div>
                <div>
                    <div class="hf-list-name">{{ $demande->utilisateur->name }}</div>
                    <div class="hf-list-sub">{{ $demande->utilisateur->email }}</div>
                </div>
            </div>
            <div class="hf-list-right">
                <form action="{{ route('amis.accepter',$demande) }}" method="POST">
                    @csrf
                    <button class="hf-btn hf-btn-success">
                        <svg style="width:12px;height:12px;stroke:currentColor;fill:none;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Accepter
                    </button>
                </form>
                <form action="{{ route('amis.supprimer',$demande) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="hf-btn hf-btn-danger">
                        <svg style="width:12px;height:12px;stroke:currentColor;fill:none;" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Refuser
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if($demandesEnvoyees->isNotEmpty())
    <div class="hf-card" style="margin-bottom:1.2rem;">
        <div class="hf-card-head">
            <div class="hf-section-dot" style="background:#3498db;"></div>
            <span class="hf-card-title">Demandes envoyées</span>
            <span class="hf-card-badge">{{ $demandesEnvoyees->count() }}</span>
        </div>
        @foreach($demandesEnvoyees as $demande)
        <div class="hf-list-row">
            <div class="hf-list-left">
                <div class="hf-avatar" style="background:linear-gradient(135deg,#2980b9,#3498db);">
                    {{ strtoupper(substr($demande->ami->name,0,1)) }}
                </div>
                <div>
                    <div class="hf-list-name">{{ $demande->ami->name }}</div>
                    <div class="hf-list-sub">{{ $demande->ami->email }}</div>
                </div>
            </div>
            <span class="hf-badge hf-badge-warn">En attente</span>
        </div>
        @endforeach
    </div>
    @endif

    <div class="hf-card">
        <div class="hf-card-head">
            <div class="hf-section-dot" style="background:var(--hf-vert-clair);"></div>
            <span class="hf-card-title">Mes amis</span>
            <span class="hf-card-badge">{{ $amis->count() }}</span>
        </div>
        @if($amis->isEmpty())
            <div class="hf-empty" style="border:none;border-radius:0;padding:2.5rem 1.5rem;">
                <div class="hf-empty-icon">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <p class="hf-empty-sub">Aucun ami pour le moment.<br>Recherche quelqu'un par email !</p>
            </div>
        @else
            @foreach($amis as $ami)
            @php $autre = $ami->utilisateur_id === Auth::id() ? $ami->ami : $ami->utilisateur; @endphp
            <div class="hf-list-row">
                <div class="hf-list-left">
                    <div class="hf-avatar">{{ strtoupper(substr($autre->name,0,1)) }}</div>
                    <div>
                        <div class="hf-list-name">{{ $autre->name }}</div>
                        <div class="hf-list-sub">{{ $autre->email }}</div>
                    </div>
                </div>
                <div class="hf-list-right">
                    <a href="{{ route('amis.habitudes',$autre) }}" class="hf-btn hf-btn-link">
                        Voir habitudes
                    </a>
                    <form action="{{ route('amis.supprimer',$ami) }}" method="POST"
                          onsubmit="return confirm('Supprimer cet ami ?')">
                        @csrf @method('DELETE')
                        <button class="hf-btn hf-btn-danger" style="padding:0.4rem 0.6rem;">
                            <svg style="width:13px;height:13px;stroke:currentColor;fill:none;" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        @endif
    </div>

</div>
@endsection
