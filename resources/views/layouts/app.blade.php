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


    @stack('styles')
</head>
<body>


    <nav class="navbar">
        <div class="container" style="display:flex;align-items:center;gap:1rem;">

            <a class="navbar-brand" href="{{ auth()->check() ? route('habitudes.index') : route('welcome') }}">
                <svg class="logo-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 160 40" width="140" height="35" aria-label="HabitFlow">
                    <defs>
                        <linearGradient id="hfLg" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#1a7a4a"/>
                            <stop offset="100%" stop-color="#2ecc71"/>
                        </linearGradient>
                    </defs>
                    <circle cx="20" cy="20" r="13" fill="none" stroke="url(#hfLg)" stroke-width="2.5"/>
                    <path d="M20 9 A11 11 0 1 1 9.5 28.5" fill="none" stroke="url(#hfLg)" stroke-width="2" stroke-linecap="round" opacity="0.4"/>
                    <path d="M13 20 L18 25 L27 15" fill="none" stroke="url(#hfLg)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                    <text x="40" y="16" font-family="'Playfair Display', Georgia, serif" font-size="13" font-weight="700" fill="var(--hf-texte)" letter-spacing="0.3">Habit</text>
                    <text x="40" y="32" font-family="'DM Sans', system-ui, sans-serif" font-size="10.5" font-weight="600" fill="#2ecc71" letter-spacing="2.5">FLOW</text>
                </svg>
            </a>


            @auth
            <div style="display:flex;align-items:center;gap:0.2rem;margin-left:auto;">
                <a href="{{ route('habitudes.index') }}"
                   class="nav-link {{ request()->routeIs('habitudes.*') ? 'active' : '' }}">
                    <svg style="width:14px;height:14px;stroke:currentColor;fill:none;vertical-align:-2px;margin-right:4px;" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    Habitudes
                </a>

                <a href="{{ route('amis.index') }}"
                   class="nav-link {{ request()->routeIs('amis.*') ? 'active' : '' }}">
                    <svg style="width:14px;height:14px;stroke:currentColor;fill:none;vertical-align:-2px;margin-right:4px;" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Amis
                </a>

                <a href="{{ route('statistiques.index') }}"
                   class="nav-link {{ request()->routeIs('statistiques.*') ? 'active' : '' }}">
                    <svg style="width:14px;height:14px;stroke:currentColor;fill:none;vertical-align:-2px;margin-right:4px;" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Statistiques
                </a>
            </div>


            <div style="display:flex;align-items:center;gap:0.6rem;margin-left:1rem;">


                @php $unread = auth()->user()->unreadNotifications->count(); @endphp
                <a href="{{ route('notifications.toutLire') }}" style="position:relative;display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;border:1px solid var(--hf-bordure);background:var(--hf-surface2);color:var(--hf-texte-muted);text-decoration:none;transition:var(--hf-transition);" onmouseover="this.style.borderColor='var(--hf-bordure-hover)'" onmouseout="this.style.borderColor='var(--hf-bordure)'">
                    <svg style="width:16px;height:16px;stroke:currentColor;fill:none;" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    @if($unread > 0)
                        <span class="notif-badge">{{ $unread > 9 ? '9+' : $unread }}</span>
                    @endif
                </a>


                <button class="theme-toggle" id="themeToggle" aria-label="Changer le thème" title="Mode clair / sombre">

                    <span class="icon-dark">
                        <svg viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                    </span>

                    <span class="icon-light" style="display:none;">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                    </span>
                </button>


                <div class="dropdown" style="position:relative;">
                    <button onclick="document.getElementById('userMenu').classList.toggle('show')"
                            style="display:flex;align-items:center;gap:0.5rem;background:var(--hf-surface2);border:1px solid var(--hf-bordure);border-radius:50px;padding:0.3rem 0.7rem 0.3rem 0.35rem;cursor:pointer;transition:var(--hf-transition);"
                            onmouseover="this.style.borderColor='var(--hf-bordure-hover)'"
                            onmouseout="this.style.borderColor='var(--hf-bordure)'">
                        <div class="hf-avatar" style="width:28px;height:28px;font-size:0.75rem;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span style="font-size:0.85rem;font-weight:500;color:var(--hf-texte);max-width:100px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            {{ auth()->user()->name }}
                        </span>
                        <svg style="width:12px;height:12px;stroke:var(--hf-texte-muted);fill:none;" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>


                    <div id="userMenu" style="display:none;position:absolute;right:0;top:calc(100% + 8px);background:var(--hf-surface);border:1px solid var(--hf-bordure);border-radius:var(--hf-radius-lg);padding:0.5rem;min-width:180px;box-shadow:var(--hf-shadow);z-index:9999;">
                        <div style="padding:0.6rem 0.8rem;border-bottom:1px solid var(--hf-bordure);margin-bottom:0.4rem;">
                            <div style="font-size:0.78rem;font-weight:600;color:var(--hf-texte);">{{ auth()->user()->name }}</div>
                            <div style="font-size:0.72rem;color:var(--hf-texte-muted);">{{ auth()->user()->email }}</div>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" style="width:100%;display:flex;align-items:center;gap:0.5rem;padding:0.5rem 0.8rem;border-radius:8px;font-size:0.85rem;color:var(--hf-texte-muted);background:transparent;border:none;cursor:pointer;transition:var(--hf-transition);font-family:inherit;" onmouseover="this.style.background='rgba(231,76,60,0.08)';this.style.color='#e74c3c'" onmouseout="this.style.background='transparent';this.style.color='var(--hf-texte-muted)'">
                                <svg style="width:14px;height:14px;stroke:currentColor;fill:none;" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>

            </div>
            @else

            <div style="margin-left:auto;display:flex;align-items:center;gap:0.6rem;">
                <a href="{{ route('login') }}" class="nav-link">Connexion</a>
                <a href="{{ route('register') }}" class="hf-btn hf-btn-primary" style="padding:0.5rem 1.1rem;font-size:0.85rem;">Commencer</a>
                <button class="theme-toggle" id="themeToggle" aria-label="Changer le thème">
                    <span class="icon-dark"><svg viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg></span>
                    <span class="icon-light" style="display:none;"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg></span>
                </button>
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
                    <button class="hf-alert-close" style="margin-left:auto;background:none;border:none;color:inherit;cursor:pointer;font-size:1rem;line-height:1;" aria-label="Fermer">&times;</button>
                </div>
            @endif

            @if(session('erreur'))
                <div class="hf-alert hf-alert-error" data-dismiss style="margin-top:1.5rem;">
                    <svg style="width:16px;height:16px;stroke:currentColor;fill:none;flex-shrink:0;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ session('erreur') }}
                    <button class="hf-alert-close" style="margin-left:auto;background:none;border:none;color:inherit;cursor:pointer;font-size:1rem;line-height:1;" aria-label="Fermer">&times;</button>
                </div>
            @endif

        </div>

        @yield('content')
    </main>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('js/habitflow.js') }}"></script>


    <script>
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('userMenu');
            if (!menu) return;
            if (!menu.contains(e.target) && !e.target.closest('[onclick*="userMenu"]')) {
                menu.style.display = 'none';
                menu.classList.remove('show');
            }
        });


        const origShow = HTMLElement.prototype.classList.add;
        document.addEventListener('DOMContentLoaded', () => {
            const menu = document.getElementById('userMenu');
            if (!menu) return;
            const observer = new MutationObserver(() => {
                menu.style.display = menu.classList.contains('show') ? 'block' : 'none';
            });
            observer.observe(menu, { attributes: true, attributeFilter: ['class'] });
        });
    </script>


    @stack('scripts')

</body>
</html>
