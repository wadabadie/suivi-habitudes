@extends('layouts.app')
@section('title', 'Mes Statistiques')

@section('content')
<div class="container hf-page">

    <div class="hf-page-header">
        <div>
            <h1 class="hf-page-title">Mes <span>Statistiques</span></h1>
            <p class="hf-page-sub">{{ ucfirst(\Carbon\Carbon::now()->locale('fr')->isoFormat('dddd D MMMM YYYY')) }}</p>
        </div>
    </div>

    <div class="hf-stat-grid" style="grid-template-columns:repeat(4,1fr);">
        <div class="hf-stat-card" style="--accent-color:var(--hf-vert-clair);">
            <div class="hf-stat-icon">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            </div>
            <div class="hf-stat-val">{{ $totalHabitudes }}</div>
            <div class="hf-stat-label">Habitudes actives</div>
        </div>
        <div class="hf-stat-card">
            <div class="hf-stat-icon">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div class="hf-stat-val" style="color:#3498db;">{{ $faitesAujourdhui }}</div>
            <div class="hf-stat-label">Faites aujourd'hui</div>
        </div>
        <div class="hf-stat-card">
            <div class="hf-stat-icon">
                <svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
            </div>
            <div class="hf-stat-val" style="color:#f39c12;">{{ $meilleureSerie }}</div>
            <div class="hf-stat-label">Meilleure série</div>
        </div>
        <div class="hf-stat-card">
            <div class="hf-stat-icon">
                <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
            <div class="hf-stat-val" style="color:#9b59b6;">{{ $totalJoursCompletes }}</div>
            <div class="hf-stat-label">Total complétés</div>
        </div>
    </div>

    @if($meilleureHabitude)
    <div class="hf-best-card">
        <svg class="hf-best-icon" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
        <div>
            <div class="hf-best-label">Meilleure habitude</div>
            <div class="hf-best-nom">{{ $meilleureHabitude->nom }}</div>
            <div class="hf-best-sub">{{ $meilleureSerie }} jours consécutifs</div>
        </div>
    </div>
    @endif

    <div class="hf-charts-grid">
        <div class="hf-card">
            <div class="hf-card-head">
                <span class="hf-card-title">Activité des 7 derniers jours</span>
                <span class="hf-card-badge">7 jours</span>
            </div>
            <div style="padding:1.4rem;">
                <canvas id="graphique7Jours" height="110"></canvas>
            </div>
        </div>
        <div class="hf-card">
            <div class="hf-card-head">
                <span class="hf-card-title">Complétion du jour</span>
            </div>
            <div style="padding:1.4rem;display:flex;flex-direction:column;align-items:center;">
                <canvas id="graphiqueTaux" width="140" height="140"></canvas>
                <div class="hf-stat-val" style="margin-top:1rem;">{{ $tauxCompletion }}%</div>
                <div style="font-size:0.8rem;color:var(--hf-texte-muted);margin-top:0.3rem;">
                    {{ $faitesAujourdhui }} / {{ $totalHabitudes }} habitudes
                </div>
            </div>
        </div>
    </div>

    <div class="hf-card">
        <div class="hf-card-head">
            <span class="hf-card-title">Séries en cours</span>
            <span class="hf-card-badge">{{ $habitudes->count() }} habitude(s)</span>
        </div>
        @if($habitudes->isEmpty())
            <div style="text-align:center;padding:2rem;color:var(--hf-texte-muted);font-size:0.9rem;">
                Aucune habitude active pour le moment.
            </div>
        @else
            @foreach($habitudes as $habitude)
            <div class="hf-serie-row">
                <div class="hf-serie-top">
                    <span class="hf-serie-name">{{ $habitude->nom }}</span>
                    <span class="hf-serie-val">
                        <strong>{{ $habitude->serie_actuelle }}</strong> jour(s)
                    </span>
                </div>
                <div class="hf-progress">
                    <div class="hf-progress-fill"
                         data-width="{{ min($habitude->serie_actuelle * 10, 100) }}%"
                         style="width:0;background:{{ $habitude->couleur }};"></div>
                </div>
            </div>
            @endforeach
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
    const isDark = document.documentElement.getAttribute('data-theme') !== 'light';
    const gridColor  = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.06)';
    const textColor  = isDark ? 'rgba(230,237,243,0.5)'  : 'rgba(26,31,46,0.5)';

    Chart.defaults.color       = textColor;
    Chart.defaults.borderColor = gridColor;
    Chart.defaults.font.family = "'DM Sans', system-ui, sans-serif";

    const labels  = @json(array_column($donnees7Jours, 'date'));
    const donnees = @json(array_column($donnees7Jours, 'nombre'));

    new Chart(document.getElementById('graphique7Jours'), {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Habitudes complétées',
                data: donnees,
                backgroundColor: 'rgba(46,204,113,0.25)',
                borderColor: '#2ecc71',
                borderWidth: 1.5,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { color: gridColor }, ticks: { color: textColor } },
                y: { beginAtZero: true, ticks: { stepSize: 1, color: textColor }, grid: { color: gridColor } }
            }
        }
    });

    new Chart(document.getElementById('graphiqueTaux'), {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [{{ $tauxCompletion }}, {{ 100 - $tauxCompletion }}],
                backgroundColor: ['#2ecc71', isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)'],
                borderWidth: 0,
            }]
        },
        options: {
            cutout: '80%',
            plugins: { legend: { display: false } },
        }
    });
})();
</script>
@endpush
