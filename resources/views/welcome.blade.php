<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HabitFlow — Transforme ta vie</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;0,900;1,700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:#0a0d12;--surface:#111520;--surface2:#181e2e;
            --bordure:rgba(255,255,255,0.07);--bordure2:rgba(255,255,255,0.13);
            --texte:#e8eef8;--muted:rgba(232,238,248,0.5);
            --vert:#1a7a4a;--vert-c:#2ecc71;--or:#c9a84c;
            --navbar:rgba(10,13,18,0.95);
            --shadow:0 24px 64px rgba(0,0,0,0.5);
        }
        [data-theme="light"]{
            --bg:#f0f4f8;--surface:#ffffff;--surface2:#f0f2f6;
            --bordure:rgba(0,0,0,0.07);--bordure2:rgba(0,0,0,0.13);
            --texte:#1a1f2e;--muted:rgba(26,31,46,0.55);
            --navbar:rgba(240,244,248,0.97);
            --shadow:0 24px 64px rgba(0,0,0,0.1);
        }
        *,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
        html{scroll-behavior:smooth;}
        body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--texte);overflow-x:hidden;transition:background .3s,color .3s;}

        /* NAVBAR */
        nav{position:fixed;top:0;left:0;right:0;z-index:100;display:flex;align-items:center;justify-content:space-between;padding:.9rem 5%;background:var(--navbar);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border-bottom:1px solid var(--bordure);transition:all .3s;}
        .nav-logo{display:flex;align-items:center;gap:.5rem;text-decoration:none;}
        .nav-links{display:flex;align-items:center;gap:.4rem;}
        .nav-link{color:var(--muted);text-decoration:none;font-size:.88rem;font-weight:500;padding:.45rem .9rem;border-radius:8px;transition:all .2s;}
        .nav-link:hover{color:var(--texte);background:var(--bordure2);}
        .btn-nav-primary{background:var(--vert);color:#fff!important;padding:.5rem 1.2rem;border-radius:50px;font-weight:600;font-size:.88rem;transition:all .25s;}
        .btn-nav-primary:hover{background:var(--vert-c);transform:translateY(-1px);}
        .btn-nav-outline{background:transparent;color:var(--texte)!important;padding:.45rem 1rem;border-radius:50px;font-weight:500;font-size:.88rem;border:1px solid var(--bordure2);transition:all .2s;}
        .btn-nav-outline:hover{border-color:var(--vert-c);color:var(--vert-c)!important;}
        .theme-btn{width:34px;height:34px;border-radius:50%;background:var(--surface2);border:1px solid var(--bordure2);color:var(--muted);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .2s;}
        .theme-btn:hover{color:var(--texte);border-color:var(--vert-c);}
        .theme-btn svg{width:15px;height:15px;stroke:currentColor;fill:none;}
        .icon-sun{display:none;}
        [data-theme="light"] .icon-sun{display:block;}
        [data-theme="light"] .icon-moon{display:none;}
        .hamburger{display:none;flex-direction:column;gap:5px;cursor:pointer;background:none;border:none;padding:4px;}
        .hamburger span{display:block;width:22px;height:2px;background:var(--texte);border-radius:2px;transition:all .3s;}

        /* HERO */
        .hero{min-height:100vh;display:grid;grid-template-columns:1fr 1fr;align-items:center;gap:4rem;padding:8rem 5% 5rem;position:relative;overflow:hidden;}
        .hero::before{content:'';position:absolute;inset:0;pointer-events:none;background:radial-gradient(ellipse 55% 55% at 70% 50%,rgba(26,122,74,.12) 0%,transparent 70%),radial-gradient(ellipse 35% 35% at 15% 85%,rgba(46,204,113,.07) 0%,transparent 60%);}
        .hero::after{content:'';position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(var(--bordure) 1px,transparent 1px),linear-gradient(90deg,var(--bordure) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 70% 70% at 70% 50%,black 0%,transparent 70%);}
        .hero-badge{display:inline-flex;align-items:center;gap:.5rem;background:rgba(46,204,113,.08);border:1px solid rgba(46,204,113,.2);color:var(--vert-c);padding:.35rem 1rem;border-radius:50px;font-size:.78rem;font-weight:600;margin-bottom:1.5rem;animation:fadeUp .6s ease both;}
        .hero-badge::before{content:'';width:6px;height:6px;background:var(--vert-c);border-radius:50%;animation:pulse 2s infinite;}
        h1.hero-title{font-family:'Playfair Display',serif;font-size:clamp(2.6rem,5vw,4.2rem);font-weight:900;line-height:1.1;letter-spacing:-.03em;margin-bottom:1.4rem;animation:fadeUp .6s ease .1s both;}
        h1.hero-title em{font-style:italic;color:var(--vert-c);}
        .hero-desc{font-size:1.05rem;color:var(--muted);line-height:1.75;max-width:460px;margin-bottom:2.2rem;animation:fadeUp .6s ease .2s both;}
        .hero-cta{display:flex;gap:.8rem;flex-wrap:wrap;animation:fadeUp .6s ease .3s both;}
        .btn-primary{display:inline-flex;align-items:center;gap:.5rem;background:var(--vert);color:#fff;padding:.9rem 1.8rem;border-radius:50px;text-decoration:none;font-weight:600;font-size:.95rem;transition:all .25s;border:2px solid var(--vert);}
        .btn-primary:hover{background:var(--vert-c);border-color:var(--vert-c);transform:translateY(-2px);box-shadow:0 8px 24px rgba(46,204,113,.3);}
        .btn-secondary{display:inline-flex;align-items:center;gap:.5rem;background:transparent;color:var(--texte);padding:.9rem 1.8rem;border-radius:50px;text-decoration:none;font-weight:500;font-size:.95rem;border:2px solid var(--bordure2);transition:all .25s;}
        .btn-secondary:hover{border-color:var(--vert-c);color:var(--vert-c);}
        .hero-stats{display:flex;gap:2rem;margin-top:2.5rem;padding-top:2rem;border-top:1px solid var(--bordure);animation:fadeUp .6s ease .4s both;}
        .stat-num{font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:900;color:var(--vert-c);line-height:1;}
        .stat-label{font-size:.75rem;color:var(--muted);margin-top:.2rem;text-transform:uppercase;letter-spacing:.05em;}

        /* HERO VISUAL avec photo */
        .hero-visual{position:relative;animation:fadeLeft .8s ease .2s both;}
        .hero-img-wrap{position:relative;border-radius:24px;overflow:hidden;}
        .hero-img{width:100%;height:520px;object-fit:cover;display:block;border-radius:24px;}
        .hero-img-overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(10,13,18,.3) 0%,transparent 60%);border-radius:24px;}
        .streak-pill{position:absolute;top:20px;left:20px;background:rgba(255,152,0,.15);border:1px solid rgba(255,152,0,.3);color:#ff9500;padding:.4rem 1rem;border-radius:50px;font-size:.82rem;font-weight:700;display:flex;align-items:center;gap:.4rem;backdrop-filter:blur(8px);}
        .float-card{position:absolute;background:rgba(17,21,32,.85);border:1px solid var(--bordure2);border-radius:14px;padding:.8rem 1rem;box-shadow:0 8px 24px rgba(0,0,0,.4);backdrop-filter:blur(12px);}
        .float-card.c1{bottom:-20px;left:-20px;animation:float 3s ease-in-out infinite;}
        .float-card.c2{top:30px;right:-15px;animation:float 3s ease-in-out infinite 1.5s;}
        .float-label{font-size:.65rem;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;}
        .float-val{font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:800;color:var(--vert-c);margin-top:.1rem;}

        /* FEATURES */
        .section{padding:6rem 5%;}
        .section.alt{background:var(--surface);}
        .section-label{display:inline-block;color:var(--vert-c);font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.1em;margin-bottom:.8rem;}
        .section-title{font-family:'Playfair Display',serif;font-size:clamp(1.8rem,3.5vw,2.8rem);font-weight:900;line-height:1.2;letter-spacing:-.02em;margin-bottom:.8rem;}
        .section-sub{color:var(--muted);font-size:1rem;line-height:1.7;max-width:500px;margin-bottom:3rem;}
        .feat-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.2rem;}
        .feat-card{background:var(--bg);border:1px solid var(--bordure);border-radius:20px;padding:1.8rem;transition:all .3s;position:relative;overflow:hidden;}
        .feat-card::after{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--vert),var(--vert-c));opacity:0;transition:.3s;}
        .feat-card:hover{transform:translateY(-4px);border-color:rgba(46,204,113,.2);}
        .feat-card:hover::after{opacity:1;}
        .feat-icon{width:44px;height:44px;border-radius:12px;background:rgba(46,204,113,.1);border:1px solid rgba(46,204,113,.15);display:flex;align-items:center;justify-content:center;margin-bottom:1.1rem;}
        .feat-icon svg{width:20px;height:20px;stroke:var(--vert-c);fill:none;}
        .feat-title{font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;margin-bottom:.5rem;}
        .feat-desc{color:var(--muted);font-size:.88rem;line-height:1.6;}

        /* HOW */
        .how-grid{display:grid;grid-template-columns:1fr 1fr;gap:5rem;align-items:center;}
        .steps-list{display:flex;flex-direction:column;gap:1.5rem;margin-top:2rem;}
        .step-item{display:flex;gap:1.2rem;align-items:flex-start;}
        .step-num{min-width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,var(--vert),var(--vert-c));display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.85rem;color:#fff;flex-shrink:0;}
        .step-title{font-weight:700;font-size:1rem;margin-bottom:.3rem;}
        .step-desc{color:var(--muted);font-size:.88rem;line-height:1.6;}

        /* Dashboard preview */
        .dash-preview{background:var(--surface);border:1px solid var(--bordure2);border-radius:24px;padding:1.5rem;box-shadow:var(--shadow);}
        .dp-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.2rem;}
        .dp-title{font-family:'Playfair Display',serif;font-size:1rem;font-weight:800;}
        .dp-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:.6rem;margin-bottom:1rem;}
        .dp-stat{background:var(--surface2);border:1px solid var(--bordure);border-radius:12px;padding:.7rem;text-align:center;}
        .dp-stat-val{font-family:'Playfair Display',serif;font-size:1.3rem;font-weight:900;color:var(--vert-c);}
        .dp-stat-label{font-size:.65rem;color:var(--muted);text-transform:uppercase;letter-spacing:.04em;}
        .dp-habits{display:flex;flex-direction:column;gap:.5rem;}
        .dp-hab{background:var(--surface2);border:1px solid var(--bordure);border-radius:10px;padding:.7rem .9rem;display:flex;align-items:center;gap:.7rem;}
        .dp-dot{width:3px;height:28px;border-radius:2px;flex-shrink:0;}
        .dp-name{font-size:.82rem;font-weight:600;flex:1;}
        .dp-bar{height:3px;background:var(--bordure);border-radius:2px;overflow:hidden;margin-top:.3rem;}
        .dp-fill{height:100%;border-radius:2px;}

        /* TESTIMONIALS */
        .testi-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.2rem;margin-top:3rem;}
        .testi-card{background:var(--bg);border:1px solid var(--bordure);border-radius:20px;padding:1.6rem;}
        .testi-stars{color:var(--or);font-size:.85rem;margin-bottom:.8rem;letter-spacing:2px;}
        .testi-text{color:var(--muted);font-size:.9rem;line-height:1.7;margin-bottom:1.2rem;font-style:italic;}
        .testi-author{display:flex;align-items:center;gap:.7rem;}
        .testi-av{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--vert),var(--vert-c));display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.9rem;color:#fff;}
        .testi-name{font-weight:600;font-size:.88rem;}
        .testi-role{font-size:.75rem;color:var(--muted);}

        /* CTA */
        .cta{padding:6rem 5%;text-align:center;position:relative;overflow:hidden;}
        .cta::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 60% 60% at 50% 50%,rgba(26,122,74,.15) 0%,transparent 70%);pointer-events:none;}
        .cta h2{font-family:'Playfair Display',serif;font-size:clamp(2rem,4vw,3.2rem);font-weight:900;line-height:1.2;letter-spacing:-.02em;margin-bottom:1rem;position:relative;}
        .cta p{color:var(--muted);font-size:1rem;margin-bottom:2.2rem;position:relative;}
        .cta-btns{display:flex;justify-content:center;gap:1rem;flex-wrap:wrap;position:relative;}

        /* FOOTER */
        footer{padding:2rem 5%;border-top:1px solid var(--bordure);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;}
        .footer-logo{display:flex;align-items:center;gap:.5rem;font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:900;}
        .footer-logo span{color:var(--vert-c);}
        footer p{color:var(--muted);font-size:.82rem;}

        /* ANIMATIONS */
        @keyframes fadeUp{from{opacity:0;transform:translateY(28px)}to{opacity:1;transform:translateY(0)}}
        @keyframes fadeLeft{from{opacity:0;transform:translateX(40px)}to{opacity:1;transform:translateX(0)}}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
        @keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(1.3)}}

        /* RESPONSIVE */
        @media(max-width:1024px){.float-card{display:none;}.feat-grid{grid-template-columns:repeat(2,1fr);}}
        @media(max-width:768px){
            .hero{grid-template-columns:1fr;padding-top:6rem;gap:2rem;}
            .hero-visual{order:-1;}
            .hero-img{height:320px;}
            .hero-stats{gap:1.2rem;}
            .feat-grid{grid-template-columns:1fr;}
            .how-grid{grid-template-columns:1fr;gap:2rem;}
            .testi-grid{grid-template-columns:1fr;}
            .hamburger{display:flex;}
            .nav-links{display:none;position:absolute;top:100%;left:0;right:0;background:var(--navbar);border-bottom:1px solid var(--bordure);flex-direction:column;padding:1rem 5%;gap:.3rem;}
            .nav-links.open{display:flex;}
            .cta-btns{flex-direction:column;align-items:center;}
            footer{flex-direction:column;text-align:center;}
        }
        @media(max-width:480px){
            .hero{padding:5rem 4% 3rem;}
            .section,.cta{padding:4rem 4%;}
        }
    </style>
</head>
<body>

<nav>
    <a href="/" class="nav-logo">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 160 40" width="130" height="32">
            <defs><linearGradient id="hfLg" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#1a7a4a"/><stop offset="100%" stop-color="#2ecc71"/></linearGradient></defs>
            <circle cx="20" cy="20" r="13" fill="none" stroke="url(#hfLg)" stroke-width="2.5"/>
            <path d="M20 9 A11 11 0 1 1 9.5 28.5" fill="none" stroke="url(#hfLg)" stroke-width="2" stroke-linecap="round" opacity="0.4"/>
            <path d="M13 20 L18 25 L27 15" fill="none" stroke="url(#hfLg)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            <text x="40" y="16" font-family="'Playfair Display',Georgia,serif" font-size="13" font-weight="700" fill="var(--texte)" letter-spacing="0.3">Habit</text>
            <text x="40" y="32" font-family="'DM Sans',system-ui,sans-serif" font-size="10.5" font-weight="600" fill="#2ecc71" letter-spacing="2.5">FLOW</text>
        </svg>
    </a>

    <button class="hamburger" onclick="toggleMenu()"><span></span><span></span><span></span></button>

    <div class="nav-links" id="navLinks">
        <a href="#fonctionnalites" class="nav-link" onclick="closeMenu()">Fonctionnalités</a>
        <a href="#comment" class="nav-link" onclick="closeMenu()">Comment ça marche</a>
        <a href="#temoignages" class="nav-link" onclick="closeMenu()">Témoignages</a>
        <button class="theme-btn" onclick="toggleTheme()">
            <svg class="icon-moon" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            <svg class="icon-sun" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
        </button>
        @auth
            <a href="{{ route('habitudes.index') }}" class="nav-link btn-nav-primary">Mon tableau de bord</a>
        @else
            <a href="{{ route('login') }}" class="nav-link btn-nav-outline">Connexion</a>
            <a href="{{ route('register') }}" class="nav-link btn-nav-primary">Inscription</a>
        @endauth
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div>
        <div class="hero-badge">Application de bien-être</div>
        <h1 class="hero-title">Construis des <em>habitudes</em><br>qui changent ta vie</h1>
        <p class="hero-desc">HabitFlow t'aide à créer, suivre et maintenir tes habitudes quotidiennes. Visualise tes progrès, brise tes records et partage tes succès.</p>
        <div class="hero-cta">
            <a href="{{ route('register') }}" class="btn-primary">
                Commencer gratuitement
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
            <a href="{{ route('login') }}" class="btn-secondary">Se connecter</a>
        </div>
        <div class="hero-stats">
            <div><div class="stat-num">21j</div><div class="stat-label">Pour créer une habitude</div></div>
            <div><div class="stat-num">∞</div><div class="stat-label">Habitudes possibles</div></div>
            <div><div class="stat-num">100%</div><div class="stat-label">Gratuit</div></div>
        </div>
    </div>

    <div class="hero-visual">
        <div class="hero-img-wrap">
            <img src="https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=800&q=80"
                 alt="Méditation et bien-être" class="hero-img">
            <div class="hero-img-overlay"></div>
            <div class="streak-pill">🔥 Série de 14 jours !</div>
        </div>
        <div class="float-card c1">
            <div class="float-label">Habitude du jour</div>
            <div class="float-val">✓ Méditation</div>
            <div style="font-size:.7rem;color:var(--muted);margin-top:.1rem;">Complétée à 7h30</div>
        </div>
        <div class="float-card c2">
            <div class="float-label">Progression</div>
            <div class="float-val">86%</div>
            <div style="font-size:.7rem;color:var(--muted);margin-top:.1rem;">Cette semaine</div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="section alt" id="fonctionnalites">
    <span class="section-label">Fonctionnalités</span>
    <h2 class="section-title">Tout ce qu'il te faut<br>pour réussir</h2>
    <p class="section-sub">Des outils puissants et simples pour transformer tes intentions en actions concrètes chaque jour.</p>
    <div class="feat-grid">
        <div class="feat-card">
            <div class="feat-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></div>
            <div class="feat-title">Création d'habitudes</div>
            <div class="feat-desc">Crée tes habitudes en quelques secondes avec couleur, description et fréquence personnalisées.</div>
        </div>
        <div class="feat-card">
            <div class="feat-icon"><svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></div>
            <div class="feat-title">Séries consécutives</div>
            <div class="feat-desc">Visualise tes jours consécutifs en temps réel. La motivation de ne pas briser ta série est puissante.</div>
        </div>
        <div class="feat-card">
            <div class="feat-icon"><svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
            <div class="feat-title">Statistiques détaillées</div>
            <div class="feat-desc">Graphiques d'activité sur 7 jours, taux de complétion quotidien et meilleure série.</div>
        </div>
        <div class="feat-card">
            <div class="feat-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
            <div class="feat-title">Système d'amis</div>
            <div class="feat-desc">Connecte-toi avec tes amis, envoie des demandes et vois leurs progrès pour vous motiver.</div>
        </div>
        <div class="feat-card">
            <div class="feat-icon"><svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></div>
            <div class="feat-title">Notifications</div>
            <div class="feat-desc">Félicitations aux jalons 3, 7, 14 et 30 jours. Alertes pour les demandes d'amis.</div>
        </div>
        <div class="feat-card">
            <div class="feat-icon"><svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
            <div class="feat-title">Sécurité maximale</div>
            <div class="feat-desc">Authentification à deux facteurs avec Google Authenticator pour protéger tes données.</div>
        </div>
    </div>
</section>

<!-- HOW -->
<section class="section" id="comment">
    <div class="how-grid">
        <div>
            <span class="section-label">Comment ça marche</span>
            <h2 class="section-title">Simple, efficace,<br><em style="font-style:italic;color:var(--vert-c)">motivant</em></h2>
            <div class="steps-list">
                <div class="step-item">
                    <div class="step-num">1</div>
                    <div><div class="step-title">Crée tes habitudes</div><div class="step-desc">Définis ce que tu veux accomplir chaque jour ou semaine avec couleur et description.</div></div>
                </div>
                <div class="step-item">
                    <div class="step-num">2</div>
                    <div><div class="step-title">Coche chaque jour</div><div class="step-desc">Marque tes habitudes comme faites en un clic et regarde ta série grandir.</div></div>
                </div>
                <div class="step-item">
                    <div class="step-num">3</div>
                    <div><div class="step-title">Analyse et partage</div><div class="step-desc">Consulte tes statistiques et motive tes amis avec tes progrès.</div></div>
                </div>
            </div>
            <div style="margin-top:2rem;">
                <a href="{{ route('register') }}" class="btn-primary" style="display:inline-flex;">Commencer maintenant →</a>
            </div>
        </div>
        <div class="dash-preview">
            <div class="dp-header"><div class="dp-title">Mes Statistiques</div><span style="font-size:.72rem;color:var(--muted);">Aujourd'hui</span></div>
            <div class="dp-stats">
                <div class="dp-stat"><div class="dp-stat-val">4</div><div class="dp-stat-label">Actives</div></div>
                <div class="dp-stat"><div class="dp-stat-val">3</div><div class="dp-stat-label">Faites</div></div>
                <div class="dp-stat"><div class="dp-stat-val">14🔥</div><div class="dp-stat-label">Série</div></div>
            </div>
            <div class="dp-habits">
                <div class="dp-hab"><div class="dp-dot" style="background:#2ecc71"></div><div style="flex:1"><div class="dp-name">Faire du sport</div><div class="dp-bar"><div class="dp-fill" style="width:100%;background:#2ecc71"></div></div></div><span style="font-size:.7rem;color:var(--vert-c)">✓</span></div>
                <div class="dp-hab"><div class="dp-dot" style="background:#3498db"></div><div style="flex:1"><div class="dp-name">Lire 30 minutes</div><div class="dp-bar"><div class="dp-fill" style="width:70%;background:#3498db"></div></div></div><span style="font-size:.7rem;color:var(--vert-c)">✓</span></div>
                <div class="dp-hab"><div class="dp-dot" style="background:#9b59b6"></div><div style="flex:1"><div class="dp-name">Méditation</div><div class="dp-bar"><div class="dp-fill" style="width:50%;background:#9b59b6"></div></div></div><span style="font-size:.7rem;color:var(--vert-c)">✓</span></div>
                <div class="dp-hab" style="opacity:.5"><div class="dp-dot" style="background:#1abc9c"></div><div style="flex:1"><div class="dp-name">Boire 2L d'eau</div><div class="dp-bar"><div class="dp-fill" style="width:30%;background:#1abc9c"></div></div></div><span style="font-size:.7rem;color:var(--muted)">○</span></div>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section class="section alt" id="temoignages">
    <div style="text-align:center;">
        <span class="section-label">Témoignages</span>
        <h2 class="section-title">Ce qu'ils en disent</h2>
    </div>
    <div class="testi-grid">
        <div class="testi-card">
            <div class="testi-stars">★★★★★</div>
            <p class="testi-text">"HabitFlow a complètement transformé ma routine. Je n'aurais jamais cru tenir 30 jours de sport consécutifs !"</p>
            <div class="testi-author"><div class="testi-av">M</div><div><div class="testi-name">Marie K.</div><div class="testi-role">Étudiante en médecine</div></div></div>
        </div>
        <div class="testi-card">
            <div class="testi-stars">★★★★★</div>
            <p class="testi-text">"Le système de séries est incroyablement motivant. Ma série de 45 jours de lecture est mon record !"</p>
            <div class="testi-author"><div class="testi-av">J</div><div><div class="testi-name">Jean-Paul T.</div><div class="testi-role">Ingénieur logiciel</div></div></div>
        </div>
        <div class="testi-card">
            <div class="testi-stars">★★★★★</div>
            <p class="testi-text">"Partager mes progrès avec mes amis m'a donné une vraie responsabilité. On se motive ensemble !"</p>
            <div class="testi-author"><div class="testi-av">A</div><div><div class="testi-name">Aminata D.</div><div class="testi-role">Coach de vie</div></div></div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta">
    <h2>Prêt à transformer<br>ta vie ?</h2>
    <p>Rejoins des milliers de personnes qui construisent de meilleures habitudes chaque jour.</p>
    <div class="cta-btns">
        <a href="{{ route('register') }}" class="btn-primary" style="font-size:1rem;padding:1rem 2.2rem;">Créer mon compte gratuitement →</a>
        <a href="{{ route('login') }}" class="btn-secondary" style="font-size:1rem;padding:1rem 2.2rem;">Se connecter</a>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-logo">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="28" height="28">
            <defs><linearGradient id="fLg" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#1a7a4a"/><stop offset="100%" stop-color="#2ecc71"/></linearGradient></defs>
            <circle cx="20" cy="20" r="13" fill="none" stroke="url(#fLg)" stroke-width="2.5"/>
            <path d="M13 20 L18 25 L27 15" fill="none" stroke="url(#fLg)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Habit<span>Flow</span>
    </div>
    <p>© 2026 HabitFlow — Application de suivi d'habitudes. Projet académique.</p>
</footer>

<script>
function toggleTheme(){
    const h=document.documentElement;
    const t=h.getAttribute('data-theme')==='dark'?'light':'dark';
    h.setAttribute('data-theme',t);
    try{localStorage.setItem('hf-theme',t);}catch(e){}
}
function toggleMenu(){document.getElementById('navLinks').classList.toggle('open');}
function closeMenu(){document.getElementById('navLinks').classList.remove('open');}
try{const s=localStorage.getItem('hf-theme');if(s)document.documentElement.setAttribute('data-theme',s);}catch(e){}
document.addEventListener('click',(e)=>{
    const n=document.getElementById('navLinks');
    const h=document.querySelector('.hamburger');
    if(n&&h&&!n.contains(e.target)&&!h.contains(e.target))n.classList.remove('open');
});
</script>
</body>
</html>
