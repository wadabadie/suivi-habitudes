<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HabitFlow') — Construis ta meilleure version</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/habitflow.css') }}">
    <style>
        /* Navbar mobile responsive */
        @media(max-width:768px){
            .hf-nav-links{display:none;position:absolute;top:100%;left:0;right:0;background:var(--hf-navbar-bg);border-bottom:1px solid var(--hf-bordure);flex-direction:column;padding:.8rem 4%;gap:.2rem;z-index:999;}
            .hf-nav-links.open{display:flex!important;}
            .hf-hamburger{display:flex!important;}
        }
        .hf-hamburger{display:none;flex-direction:column;gap:5px;cursor:pointer;background:none;border:none;padding:4px;margin-left:.5rem;}
        .hf-hamburger span{display:block;width:20px;height:2px;background:var(--hf-texte);border-radius:2px;transition:all .3s;}
        /* Logout btn visible */
        .logout-btn{display:inline-flex;align-items:center;gap:.4rem;background:rgba(231,76,60,.08);color:#e74c3c!important;border:1px solid rgba(231,76,60,.2);border-radius:50px;padding:.4rem .9rem;font-size:.82rem;font-weight:500;cursor:pointer;transition:all .2s;font-family:inherit;text-decoration:none;}
        .logout-btn:hover{background:rgba(231,76,60,.15);border-color:rgba(231,76,60,.35);}
        .logout-btn svg{width:13px;height:13px;stroke:currentColor;fill:none;}
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar" style="position:relative;">
    <div class="container" style="display:flex;align-items:center;gap:.8rem;flex-wrap:nowrap;">

        {{-- Logo --}}
        <a class="navbar-brand" href="{{ auth()->check() ? route('habitudes.index') : route('welcome') }}" style="flex-shrink:0;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 160 40" width="130" height="32" aria-label="HabitFlow">
                <defs><linearGradient id="hfLg" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#1a7a4a"/><stop offset="100%" stop-color="#2ecc71"/></linearGradient></defs>
                <circle cx="20" cy="20" r="13" fill="none" stroke="url(#hfLg)" stroke-width="2.5"/>
                <path d="M20 9 A11 11 0 1 1 9.5 28.5" fill="none" stroke="url(#hfLg)" stroke-width="2" stroke-linecap="round" opacity="0.4"/>
                <path d="M13 20 L18 25 L27 15" fill="none" stroke="url(#hfLg)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                <text x="40" y="16" font-family="'Playfair Display',Georgia,serif" font-size="13" font-weight="700" fill="var(--hf-texte)" letter-spacing="0.3">Habit</text>
                <text x="40" y="32" font-family="'DM Sans',system-ui,sans-serif" font-size="10.5" font-weight="600" fill="#2ecc71" letter-spacing="2.5">FLOW</text>
            </svg>
        </a>

        @auth
        {{-- Nav links gauche --}}
        <div style="display:flex;align-items:center;gap:.1rem;margin-left:auto;" class="d-none d-md-flex">
            <a href="{{ route('habitudes.index') }}" class="nav-link {{ request()->routeIs('habitudes.*') ? 'active' : '' }}">
                <svg style="width:13px;height:13px;stroke:currentColor;fill:none;vertical-align:-2px;margin-right:3px;" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Habitudes
            </a>
            <a href="{{ route('statistiques.index') }}" class="nav-link {{ request()->routeIs('statistiques.*') ? 'active' : '' }}">
                <svg style="width:13px;height:13px;stroke:currentColor;fill:none;vertical-align:-2px;margin-right:3px;" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                Statistiques
            </a>
            <a href="{{ route('amis.index') }}" class="nav-link {{ request()->routeIs('amis.*') ? 'active' : '' }}">
                <svg style="width:13px;height:13px;stroke:currentColor;fill:none;vertical-align:-2px;margin-right:3px;" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Amis
            </a>
        </div>

        {{-- Actions droite --}}
        <div style="display:flex;align-items:center;gap:.5rem;margin-left:.5rem;" class="d-none d-md-flex">
            {{-- Notifications --}}
            @php $unread = auth()->user()->unreadNotifications->count(); @endphp
            <div style="position:relative;" class="dropdown">
                <button onclick="toggleNotif()" style="position:relative;display:inline-flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:50%;border:1px solid var(--hf-bordure);background:var(--hf-surface2);color:var(--hf-texte-muted);cursor:pointer;transition:var(--hf-transition);" onmouseover="this.style.borderColor='var(--hf-bordure-hover)'" onmouseout="this.style.borderColor='var(--hf-bordure)'">
                    <svg style="width:15px;height:15px;stroke:currentColor;fill:none;" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    @if($unread > 0)
                        <span class="notif-badge">{{ $unread > 9 ? '9+' : $unread }}</span>
                    @endif
                </button>
                <div id="notifMenu" style="display:none;position:absolute;right:0;top:calc(100% + 8px);background:var(--hf-surface);border:1px solid var(--hf-bordure);border-radius:var(--hf-radius-lg);min-width:300px;box-shadow:var(--hf-shadow);z-index:9999;overflow:hidden;">
                    <div style="padding:.8rem 1.1rem;border-bottom:1px solid var(--hf-bordure);font-weight:600;font-size:.88rem;">Notifications</div>
                    @forelse(auth()->user()->unreadNotifications->take(5) as $notif)
                        <a href="{{ route('notifications.lire', $notif->id) }}" style="display:block;padding:.75rem 1.1rem;border-bottom:1px solid var(--hf-bordure);text-decoration:none;transition:background .2s;" onmouseover="this.style.background='rgba(255,255,255,.03)'" onmouseout="this.style.background='transparent'">
                            <div style="font-size:.82rem;color:var(--hf-texte);line-height:1.4;">{{ $notif->data['message'] }}</div>
                            <div style="font-size:.72rem;color:var(--hf-texte-muted);margin-top:.2rem;">{{ $notif->created_at->diffForHumans() }}</div>
                        </a>
                    @empty
                        <div style="padding:1.2rem;text-align:center;color:var(--hf-texte-muted);font-size:.85rem;">Aucune nouvelle notification</div>
                    @endforelse
                    @if($unread > 0)
                        <div style="padding:.6rem;text-align:center;border-top:1px solid var(--hf-bordure);">
                            <a href="{{ route('notifications.toutLire') }}" style="font-size:.78rem;color:var(--hf-vert-clair);text-decoration:none;">Tout marquer comme lu</a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Theme toggle --}}
            <button class="theme-toggle" id="themeToggle" aria-label="Changer le thème">
                <span class="icon-dark"><svg viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg></span>
                <span class="icon-light" style="display:none;"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg></span>
            </button>

            {{-- Avatar + Nom --}}
            <div style="display:flex;align-items:center;gap:.5rem;background:var(--hf-surface2);border:1px solid var(--hf-bordure);border-radius:50px;padding:.3rem .8rem .3rem .35rem;">
                <div class="hf-avatar" style="width:26px;height:26px;font-size:.72rem;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <span style="font-size:.82rem;font-weight:500;color:var(--hf-texte);max-width:90px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ auth()->user()->name }}</span>
            </div>

            {{-- Bouton Déconnexion visible --}}
            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Déconnexion
                </button>
            </form>
        </div>

        {{-- Hamburger mobile --}}
        <button class="hf-hamburger ms-auto d-md-none" onclick="toggleHamburger()">
            <span></span><span></span><span></span>
        </button>

        {{-- Menu mobile --}}
        <div class="hf-nav-links" id="mobileMenu" style="display:none;">
            <a href="{{ route('habitudes.index') }}" class="nav-link">Habitudes</a>
            <a href="{{ route('statistiques.index') }}" class="nav-link">Statistiques</a>
            <a href="{{ route('amis.index') }}" class="nav-link">Amis</a>
            <hr style="border-color:var(--hf-bordure);margin:.4rem 0;">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn w-100" style="justify-content:center;">
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Déconnexion
                </button>
            </form>
        </div>

        @else
        {{-- Guest --}}
        <div style="margin-left:auto;display:flex;align-items:center;gap:.5rem;">
            <button class="theme-toggle" id="themeToggle" aria-label="Changer le thème">
                <span class="icon-dark"><svg viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg></span>
                <span class="icon-light" style="display:none;"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg></span>
            </button>
            <a href="{{ route('login') }}" class="nav-link">Connexion</a>
            <a href="{{ route('register') }}" class="hf-btn hf-btn-primary" style="padding:.5rem 1.1rem;font-size:.85rem;">Inscription</a>
        </div>
        @endauth
    </div>
</nav>

<main>
    <div class="container">
        @if(session('succes'))
            <div class="hf-alert hf-alert-success" data-dismiss style="margin-top:1.5rem;">
                <svg style="width:16px;height:16px;stroke:currentColor;fill:none;flex-shrink:0;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('succes') }}
                <button class="hf-alert-close" style="margin-left:auto;background:none;border:none;color:inherit;cursor:pointer;font-size:1rem;line-height:1;">&times;</button>
            </div>
        @endif
        @if(session('erreur'))
            <div class="hf-alert hf-alert-error" data-dismiss style="margin-top:1.5rem;">
                <svg style="width:16px;height:16px;stroke:currentColor;fill:none;flex-shrink:0;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('erreur') }}
                <button class="hf-alert-close" style="margin-left:auto;background:none;border:none;color:inherit;cursor:pointer;font-size:1rem;line-height:1;">&times;</button>
            </div>
        @endif
    </div>
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/habitflow.js') }}"></script>
<script>
function toggleNotif(){
    const m=document.getElementById('notifMenu');
    if(m)m.style.display=m.style.display==='none'?'block':'none';
}
function toggleHamburger(){
    const m=document.getElementById('mobileMenu');
    if(m)m.classList.toggle('open');
}
document.addEventListener('click',(e)=>{
    const nm=document.getElementById('notifMenu');
    if(nm&&!nm.contains(e.target)&&!e.target.closest('[onclick*="toggleNotif"]'))nm.style.display='none';
    const mm=document.getElementById('mobileMenu');
    const hm=document.querySelector('.hf-hamburger');
    if(mm&&hm&&!mm.contains(e.target)&&!hm.contains(e.target))mm.classList.remove('open');
});
</script>
@stack('scripts')
</body>
</html>
