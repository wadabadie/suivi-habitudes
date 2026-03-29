@extends('layouts.app')
@section('title', 'Nouvelle habitude')

@section('content')
<div class="container hf-page" style="max-width:620px;margin-left:auto;margin-right:auto;">

    <div class="hf-page-header" style="margin-bottom:1.8rem;">
        <div>
            <h1 class="hf-page-title">Nouvelle <span>habitude</span></h1>
            <p class="hf-page-sub">Définis ton habitude et commence à construire ta meilleure version.</p>
        </div>
    </div>

    <div class="hf-card" style="padding:2rem;">
        <form action="{{ route('habitudes.store') }}" method="POST" id="formHabitude">
            @csrf

            <div style="margin-bottom:1.5rem;">
                <label class="hf-label">Nom de l'habitude</label>
                <input type="text" name="nom" id="champNom"
                       class="hf-input @error('nom') is-invalid @enderror"
                       value="{{ old('nom') }}"
                       placeholder="Ex: Faire du sport, Lire 30 min...">
                @error('nom')
                    <div style="color:#e74c3c;font-size:0.8rem;margin-top:0.4rem;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="hf-label">
                    Description
                    <span style="color:var(--hf-texte-muted);font-weight:400;text-transform:none;letter-spacing:0;">(optionnelle)</span>
                </label>
                <textarea name="description" class="hf-input" rows="2"
                          placeholder="Ex: 30 minutes de course à pied...">{{ old('description') }}</textarea>
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="hf-label">Fréquence</label>
                <div class="hf-freq-grid">
                    <div class="hf-freq-opt">
                        <input type="radio" name="frequence" id="quotidien" value="quotidien"
                               {{ old('frequence', 'quotidien') == 'quotidien' ? 'checked' : '' }}>
                        <label class="hf-freq-label" for="quotidien">
                            <svg class="hf-freq-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                            <span class="hf-freq-name">Quotidien</span>
                            <span class="hf-freq-desc">Chaque jour</span>
                        </label>
                    </div>
                    <div class="hf-freq-opt">
                        <input type="radio" name="frequence" id="hebdomadaire" value="hebdomadaire"
                               {{ old('frequence') == 'hebdomadaire' ? 'checked' : '' }}>
                        <label class="hf-freq-label" for="hebdomadaire">
                            <svg class="hf-freq-icon" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            <span class="hf-freq-name">Hebdomadaire</span>
                            <span class="hf-freq-desc">Chaque semaine</span>
                        </label>
                    </div>
                </div>
            </div>

            <div style="margin-bottom:1.5rem;">
                <label class="hf-label">Couleur</label>
                <div class="hf-couleur-grid">
                    @php
                        $couleurs = ['#2ecc71','#3498db','#e74c3c','#f39c12','#9b59b6','#1abc9c','#e67e22','#e91e63','#00bcd4','#ff5722','#607d8b','#795548','#4caf50','#2196f3','#ff9800','#673ab7'];
                    @endphp
                    @foreach($couleurs as $c)
                        <div class="hf-couleur-opt {{ old('couleur', '#2ecc71') === $c ? 'selected' : '' }}"
                             style="background:{{ $c }};"
                             data-couleur="{{ $c }}">
                        </div>
                    @endforeach
                </div>
                <input type="hidden" name="couleur" id="couleurChoisie" value="{{ old('couleur', '#2ecc71') }}">
            </div>

            <div class="hf-preview">
                <div class="hf-preview-accent" id="previewAccent" style="background:#2ecc71;"></div>
                <div>
                    <div class="hf-preview-name" id="previewNom">Nom de l'habitude</div>
                    <div class="hf-preview-sub" id="previewDesc">Aperçu de ta nouvelle habitude</div>
                </div>
                <div style="margin-left:auto;">
                    <svg style="width:20px;height:20px;stroke:#ff9500;fill:none;" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                </div>
            </div>

            <div style="display:flex;gap:1rem;margin-top:1.8rem;">
                <button type="submit" class="hf-btn hf-btn-primary" style="flex:1;border-radius:12px;">
                    Créer l'habitude
                </button>
                <a href="{{ route('habitudes.index') }}" class="hf-btn hf-btn-ghost">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
