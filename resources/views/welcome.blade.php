<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HabitFlow — Transforme ta vie</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;0,900;1,700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0a0d12; --surface: #111520; --surface2: #181e2e;
            --bordure: rgba(255,255,255,0.07); --bordure2: rgba(255,255,255,0.12);
            --texte: #e8eef8; --muted: rgba(232,238,248,0.5);
            --vert: #1a7a4a; --vert-c: #2ecc71; --or: #c9a84c;
            --navbar: rgba(10,13,18,0.92);
            --shadow: 0 24px 64px rgba(0,0,0,0.5);
        }
        [data-theme="light"] {
            --bg: #f0f4f8; --surface: #ffffff; --surface2: #f5f7fa;
            --bordure: rgba(0,0,0,0.07); --bordure2: rgba(0,0,0,0.12);
            --texte: #1a1f2e; --muted: rgba(26,31,46,0.55);
            --navbar: rgba(240,244,248,0.95);
            --shadow: 0 24px 64px rgba(0,0,0,0.1);
        }
        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
        html { scroll-behavior: smooth; }
        body { font-family:'DM Sans',sans-serif; background:var(--bg); color:var(--texte); overflow-x:hidden; transition:background .3s,color .3s; }

        /* ── NAVBAR ── */
        nav {
            position:fixed; top:0; left:0; right:0; z-index:100;
            display:flex; align-items:center; justify-content:space-between;
            padding:1rem 5%; background:var(--navbar);
            backdrop-filter:blur(20px); -webkit-backdrop-filter:blur(20px);
            border-bottom:1px solid var(--bordure);
            transition:all .3s;
        }
        .logo { font-family:'Playfair Display',serif; font-size:1.5rem; font-weight:900; color:var(--texte); text-decoration:none; letter-spacing:-0.03em; }
        .logo span { color:var(--vert-c); }
        .nav-links { display:flex; align-items:center; gap:0.5rem; }
        .nav-link { color:var(--muted); text-decoration:none; font-size:0.88rem; font-weight:500; padding:0.45rem 0.9rem; border-radius:8px; transition:all .2s; }
        .nav-link:hover { color:var(--texte); background:var(--bordure); }
        .btn-inscription {
            background:var(--vert); color:#fff !important;
            padding:0.5rem 1.2rem; border-radius:50px;
            font-weight:600; font-size:0.88rem;
            transition:all .25s;
        }
        .btn-inscription:hover { background:var(--vert-c); transform:translateY(-1px); }
        .btn-dashboard {
            background:linear-gradient(135deg,var(--vert),var(--vert-c));
            color:#fff !important; padding:0.5rem 1.2rem;
            border-radius:50px; font-weight:600; font-size:0.88rem;
        }

        /* Theme toggle */
        .theme-btn {
            width:36px; height:36px; border-radius:50%;
            background:var(--surface2); border:1px solid var(--bordure2);
            color:var(--muted); cursor:pointer; display:flex;
            align-items:center; justify-content:center; transition:all .2s;
            margin-right:0.3rem;
        }
        .theme-btn:hover { color:var(--texte); border-color:var(--vert-c); }
        .theme-btn svg { width:16px; height:16px; stroke:currentColor; fill:none; }
        .icon-sun { display:none; }
        [data-theme="light"] .icon-sun { display:block; }
        [data-theme="light"] .icon-moon { display:none; }

        /* Hamburger */
        .hamburger { display:none; flex-direction:column; gap:5px; cursor:pointer; padding:4px; background:none; border:none; }
        .hamburger span { display:block; width:22px; height:2px; background:var(--texte); border-radius:2px; transition:all .3s; }

        /* ── HERO ── */
        .hero {
            min-height:100vh; display:grid;
            grid-template-columns:1fr 1fr;
            align-items:center; gap:4rem;
            padding:8rem 5% 5rem;
            position:relative; overflow:hidden;
        }
        .hero::before {
            content:''; position:absolute; inset:0; pointer-events:none;
            background:
                radial-gradient(ellipse 55% 55% at 70% 50%, rgba(26,122,74,0.12) 0%, transparent 70%),
                radial-gradient(ellipse 35% 35% at 15% 85%, rgba(46,204,113,0.07) 0%, transparent 60%);
        }
        /* Grille déco */
        .hero::after {
            content:''; position:absolute; inset:0; pointer-events:none;
            background-image: linear-gradient(var(--bordure) 1px, transparent 1px),
                              linear-gradient(90deg, var(--bordure) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse 70% 70% at 70% 50%, black 0%, transparent 70%);
        }

        .hero-badge {
            display:inline-flex; align-items:center; gap:0.5rem;
            background:rgba(46,204,113,0.08); border:1px solid rgba(46,204,113,0.2);
            color:var(--vert-c); padding:0.35rem 1rem; border-radius:50px;
            font-size:0.78rem; font-weight:600; margin-bottom:1.5rem;
            animation:fadeUp .6s ease both;
        }
        .hero-badge::before { content:''; width:6px; height:6px; background:var(--vert-c); border-radius:50%; animation:pulse 2s infinite; }

        h1.hero-title {
            font-family:'Playfair Display',serif;
            font-size:clamp(2.6rem,5vw,4.2rem);
            font-weight:900; line-height:1.1;
            letter-spacing:-0.03em; margin-bottom:1.4rem;
            animation:fadeUp .6s ease .1s both;
        }
        h1.hero-title em { font-style:italic; color:var(--vert-c); }

        .hero-desc {
            font-size:1.05rem; color:var(--muted); line-height:1.75;
            max-width:460px; margin-bottom:2.2rem;
            animation:fadeUp .6s ease .2s both;
        }

        .hero-cta { display:flex; gap:0.8rem; flex-wrap:wrap; animation:fadeUp .6s ease .3s both; }
        .btn-hero-primary {
            display:inline-flex; align-items:center; gap:0.5rem;
            background:var(--vert); color:#fff; padding:0.9rem 1.8rem;
            border-radius:50px; text-decoration:none; font-weight:600;
            font-size:0.95rem; transition:all .25s; border:2px solid var(--vert);
        }
        .btn-hero-primary:hover { background:var(--vert-c); border-color:var(--vert-c); transform:translateY(-2px); box-shadow:0 8px 24px rgba(46,204,113,0.3); }
        .btn-hero-secondary {
            display:inline-flex; align-items:center; gap:0.5rem;
            background:transparent; color:var(--texte);
            padding:0.9rem 1.8rem; border-radius:50px;
            text-decoration:none; font-weight:500; font-size:0.95rem;
            border:2px solid var(--bordure2); transition:all .25s;
        }
        .btn-hero-secondary:hover { border-color:var(--vert-c); color:var(--vert-c); }

        .hero-stats {
            display:flex; gap:2rem; margin-top:2.5rem;
            animation:fadeUp .6s ease .4s both;
            padding-top:2rem; border-top:1px solid var(--bordure);
        }
        .stat-num { font-family:'Playfair Display',serif; font-size:1.8rem; font-weight:900; color:var(--vert-c); line-height:1; }
        .stat-label { font-size:0.75rem; color:var(--muted); margin-top:0.2rem; text-transform:uppercase; letter-spacing:0.05em; }

        /* ── HERO VISUAL ── */
        .hero-visual { position:relative; animation:fadeLeft .8s ease .2s both; }

        .phone-mockup {
            width:100%; max-width:340px; margin:0 auto;
            background:var(--surface);
            border:1px solid var(--bordure2);
            border-radius:32px; padding:1.5rem;
            box-shadow:var(--shadow);
            position:relative;
        }
        .phone-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.2rem; }
        .phone-title { font-family:'Playfair Display',serif; font-size:1rem; font-weight:800; }
        .phone-date { font-size:0.72rem; color:var(--muted); }

        .phone-stats { display:grid; grid-template-columns:1fr 1fr; gap:0.6rem; margin-bottom:1rem; }
        .phone-stat {
            background:var(--surface2); border:1px solid var(--bordure);
            border-radius:14px; padding:0.8rem;
            position:relative; overflow:hidden;
        }
        .phone-stat::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,var(--vert),var(--vert-c)); }
        .phone-stat-val { font-family:'Playfair Display',serif; font-size:1.4rem; font-weight:900; color:var(--vert-c); }
        .phone-stat-label { font-size:0.68rem; color:var(--muted); margin-top:0.2rem; text-transform:uppercase; letter-spacing:0.04em; }

        .habit-list { display:flex; flex-direction:column; gap:0.5rem; }
        .habit-item {
            background:var(--surface2); border:1px solid var(--bordure);
            border-radius:12px; padding:0.8rem 1rem;
            display:flex; align-items:center; gap:0.8rem;
            transition:all .2s;
        }
        .habit-dot { width:3px; height:36px; border-radius:2px; flex-shrink:0; }
        .habit-nom { font-size:0.85rem; font-weight:600; flex:1; }
        .habit-streak { font-size:0.72rem; color:var(--muted); }
        .habit-check {
            width:28px; height:28px; border-radius:50%;
            display:flex; align-items:center; justify-content:center;
            font-size:0.8rem; flex-shrink:0;
        }
        .habit-check.done { background:var(--vert-c); color:#fff; }
        .habit-check.todo { background:var(--bordure); border:2px solid var(--bordure2); }

        /* Floating cards */
        .float-card {
            position:absolute;
            background:var(--surface);
            border:1px solid var(--bordure2);
            border-radius:14px; padding:0.8rem 1rem;
            box-shadow:0 8px 24px rgba(0,0,0,0.3);
        }
        .float-card.left { left:-60px; top:30%; animation:float 3s ease-in-out infinite; }
        .float-card.right { right:-40px; bottom:20%; animation:float 3s ease-in-out infinite 1.5s; }
        .float-label { font-size:0.65rem; color:var(--muted); text-transform:uppercase; letter-spacing:0.06em; }
        .float-val { font-family:'Playfair Display',serif; font-size:1.1rem; font-weight:800; color:var(--vert-c); margin-top:0.1rem; }

        /* ── FEATURES ── */
        .features { padding:6rem 5%; background:var(--surface); }
        .section-label { display:inline-block; color:var(--vert-c); font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:0.8rem; }
        .section-title { font-family:'Playfair Display',serif; font-size:clamp(1.8rem,3.5vw,2.8rem); font-weight:900; line-height:1.2; letter-spacing:-0.02em; margin-bottom:0.8rem; }
        .section-sub { color:var(--muted); font-size:1rem; line-height:1.7; max-width:500px; margin-bottom:3rem; }

        .feat-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:1.2rem; }
        .feat-card {
            background:var(--bg); border:1px solid var(--bordure);
            border-radius:20px; padding:1.8rem;
            transition:all .3s; position:relative; overflow:hidden;
        }
        .feat-card::after { content:''; position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,var(--vert),var(--vert-c)); opacity:0; transition:.3s; }
        .feat-card:hover { transform:translateY(-4px); border-color:rgba(46,204,113,0.2); }
        .feat-card:hover::after { opacity:1; }
        .feat-icon {
            width:44px; height:44px; border-radius:12px;
            background:rgba(46,204,113,0.1); border:1px solid rgba(46,204,113,0.15);
            display:flex; align-items:center; justify-content:center;
            margin-bottom:1.1rem;
        }
        .feat-icon svg { width:20px; height:20px; stroke:var(--vert-c); fill:none; }
        .feat-title { font-family:'Playfair Display',serif; font-size:1.1rem; font-weight:700; margin-bottom:0.5rem; }
        .feat-desc { color:var(--muted); font-size:0.88rem; line-height:1.6; }

        /* ── HOW IT WORKS ── */
        .how { padding:6rem 5%; }
        .how-grid { display:grid; grid-template-columns:1fr 1fr; gap:5rem; align-items:center; }
        .steps-list { display:flex; flex-direction:column; gap:1.5rem; margin-top:2rem; }
        .step-item { display:flex; gap:1.2rem; align-items:flex-start; }
        .step-num {
            min-width:40px; height:40px; border-radius:50%;
            background:linear-gradient(135deg,var(--vert),var(--vert-c));
            display:flex; align-items:center; justify-content:center;
            font-weight:800; font-size:0.85rem; color:#fff; flex-shrink:0;
        }
        .step-title { font-weight:700; font-size:1rem; margin-bottom:0.3rem; }
        .step-desc { color:var(--muted); font-size:0.88rem; line-height:1.6; }

        /* Dashboard preview */
        .dashboard-preview {
            background:var(--surface); border:1px solid var(--bordure2);
            border-radius:24px; padding:1.5rem;
            box-shadow:var(--shadow);
        }
        .db-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.2rem; }
        .db-title { font-family:'Playfair Display',serif; font-size:1rem; font-weight:800; }
        .db-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:0.6rem; margin-bottom:1rem; }
        .db-stat { background:var(--surface2); border:1px solid var(--bordure); border-radius:12px; padding:0.7rem; text-align:center; }
        .db-stat-val { font-family:'Playfair Display',serif; font-size:1.3rem; font-weight:900; color:var(--vert-c); }
        .db-stat-label { font-size:0.65rem; color:var(--muted); text-transform:uppercase; letter-spacing:0.04em; }
        .db-habits { display:flex; flex-direction:column; gap:0.5rem; }
        .db-hab { background:var(--surface2); border:1px solid var(--bordure); border-radius:10px; padding:0.7rem 0.9rem; display:flex; align-items:center; gap:0.7rem; }
        .db-hab-dot { width:3px; height:28px; border-radius:2px; flex-shrink:0; }
        .db-hab-name { font-size:0.82rem; font-weight:600; flex:1; }
        .db-hab-streak { font-size:0.7rem; color:var(--muted); }
        .db-progress { height:3px; background:var(--bordure); border-radius:2px; overflow:hidden; margin-top:0.3rem; }
        .db-progress-fill { height:100%; border-radius:2px; }

        /* ── TESTIMONIALS ── */
        .testi { padding:6rem 5%; background:var(--surface); }
        .testi-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:1.2rem; margin-top:3rem; }
        .testi-card {
            background:var(--bg); border:1px solid var(--bordure);
            border-radius:20px; padding:1.6rem;
        }
        .testi-stars { color:var(--or); font-size:0.85rem; margin-bottom:0.8rem; letter-spacing:2px; }
        .testi-text { color:var(--muted); font-size:0.9rem; line-height:1.7; margin-bottom:1.2rem; font-style:italic; }
        .testi-author { display:flex; align-items:center; gap:0.7rem; }
        .testi-av { width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,var(--vert),var(--vert-c)); display:flex; align-items:center; justify-content:center; font-weight:800; font-size:0.9rem; color:#fff; }
        .testi-name { font-weight:600; font-size:0.88rem; }
        .testi-role { font-size:0.75rem; color:var(--muted); }

        /* ── CTA ── */
        .cta { padding:6rem 5%; text-align:center; position:relative; overflow:hidden; }
        .cta::before { content:''; position:absolute; inset:0; background:radial-gradient(ellipse 60% 60% at 50% 50%, rgba(26,122,74,0.15) 0%, transparent 70%); pointer-events:none; }
        .cta h2 { font-family:'Playfair Display',serif; font-size:clamp(2rem,4vw,3.2rem); font-weight:900; line-height:1.2; letter-spacing:-0.02em; margin-bottom:1rem; position:relative; }
        .cta p { color:var(--muted); font-size:1rem; margin-bottom:2.2rem; position:relative; }
        .cta-btns { display:flex; justify-content:center; gap:1rem; flex-wrap:wrap; position:relative; }

        /* ── FOOTER ── */
        footer { padding:2rem 5%; border-top:1px solid var(--bordure); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; }
        .footer-logo { font-family:'Playfair Display',serif; font-size:1.1rem; font-weight:900; }
        .footer-logo span { color:var(--vert-c); }
        footer p { color:var(--muted); font-size:0.82rem; }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp { from{opacity:0;transform:translateY(28px)} to{opacity:1;transform:translateY(0)} }
        @keyframes fadeLeft { from{opacity:0;transform:translateX(40px)} to{opacity:1;transform:translateX(0)} }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.3)} }

        /* ── RESPONSIVE ── */
        @media(max-width:1024px) {
            .float-card { display:none; }
            .feat-grid { grid-template-columns:repeat(2,1fr); }
        }
        @media(max-width:768px) {
            .hero { grid-template-columns:1fr; padding-top:6rem; gap:2rem; }
            .hero-visual { order:-1; }
            .phone-mockup { max-width:100%; }
            .hero-stats { gap:1.2rem; }
            .feat-grid { grid-template-columns:1fr; }
            .how-grid { grid-template-columns:1fr; gap:2rem; }
            .testi-grid { grid-template-columns:1fr; }
            .hamburger { display:flex; }
            .nav-links { display:none; position:absolute; top:100%; left:0; right:0; background:var(--navbar); border-bottom:1px solid var(--bordure); flex-direction:column; padding:1rem 5%; gap:0.3rem; }
            .nav-links.open { display:flex; }
            .cta-btns { flex-direction:column; align-items:center; }
            footer { flex-direction:column; text-align:center; }
        }
        @media(max-width:480px) {
            .hero { padding:5rem 4% 3rem; }
            .features,.how,.testi,.cta { padding:4rem 4%; }
            .phone-stats { grid-template-columns:1fr 1fr; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav id="navbar">
    <a href="/" class="logo">Habit<span>Flow</span></a>

    <button class="hamburger" id="hamburger" onclick="toggleMenu()">
        <span></span><span></span><span></span>
    </button>

    <div class="nav-links" id="navLinks">
        <a href="#fonctionnalites" class="nav-link" onclick="closeMenu()">Fonctionnalités</a>
        <a href="#comment" class="nav-link" onclick="closeMenu()">Comment ça marche</a>
        <a href="#temoignages" class="nav-link" onclick="closeMenu()">Témoignages</a>

        <button class="theme-btn" id="themeToggle" onclick="toggleTheme()" title="Changer le thème">
            <svg class="icon-moon" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            <svg class="icon-sun" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
        </button>

        @auth
            <a href="{{ route('habitudes.index') }}" class="nav-link btn-dashboard">Mon tableau de bord</a>
        @else
            <a href="{{ route('login') }}" class="nav-link">Connexion</a>
            <a href="{{ route('register') }}" class="nav-link btn-inscription">Inscription</a>
        @endauth
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div>
        <div class="hero-badge">Application de bien-être</div>
        <h1 class="hero-title">
            Construis des <em>habitudes</em><br>
            qui changent ta vie
        </h1>
        <p class="hero-desc">
            HabitFlow t'aide à créer, suivre et maintenir tes habitudes quotidiennes.
            Visualise tes progrès, brise tes records et partage tes succès.
        </p>
        <div class="hero-cta">
            <a href="{{ route('register') }}" class="btn-hero-primary">
                Commencer gratuitement
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
            <a href="{{ route('login') }}" class="btn-hero-secondary">Se connecter</a>
        </div>
        <div class="hero-stats">
            <div><div class="stat-num">21j</div><div class="stat-label">Pour créer une habitude</div></div>
            <div><div class="stat-num">∞</div><div class="stat-label">Habitudes possibles</div></div>
            <div><div class="stat-num">100%</div><div class="stat-label">Gratuit</div></div>
        </div>
    </div>

    <div class="hero-visual">
        <div class="float-card left">
            <div class="float-label">Série actuelle</div>
            <div class="float-val">🔥 14 jours</div>
        </div>

        <div class="phone-mockup">
            <div class="phone-header">
                <div>
                    <div class="phone-title">Bonjour, Alice 👋</div>
                    <div class="phone-date">Dimanche 29 mars 2026</div>
                </div>
            </div>
            <div class="phone-stats">
                <div class="phone-stat">
                    <div class="phone-stat-val">4</div>
                    <div class="phone-stat-label">Habitudes</div>
                </div>
                <div class="phone-stat">
                    <div class="phone-stat-val">3</div>
                    <div class="phone-stat-label">Faites</div>
                </div>
                <div class="phone-stat">
                    <div class="phone-stat-val">14</div>
                    <div class="phone-stat-label">Meilleure série</div>
                </div>
                <div class="phone-stat">
                    <div class="phone-stat-val">75%</div>
                    <div class="phone-stat-label">Complétion</div>
                </div>
            </div>
            <div class="habit-list">
                <div class="habit-item">
                    <div class="habit-dot" style="background:#2ecc71"></div>
                    <div style="flex:1"><div class="habit-nom">Faire du sport</div><div class="habit-streak">🔥 14 jours</div></div>
                    <div class="habit-check done">✓</div>
                </div>
                <div class="habit-item">
                    <div class="habit-dot" style="background:#3498db"></div>
                    <div style="flex:1"><div class="habit-nom">Lire 30 minutes</div><div class="habit-streak">🔥 7 jours</div></div>
                    <div class="habit-check done">✓</div>
                </div>
                <div class="habit-item">
                    <div class="habit-dot" style="background:#9b59b6"></div>
                    <div style="flex:1"><div class="habit-nom">Méditation</div><div class="habit-streak">🔥 5 jours</div></div>
                    <div class="habit-check done">✓</div>
                </div>
                <div class="habit-item" style="opacity:.6">
                    <div class="habit-dot" style="background:#1abc9c"></div>
                    <div style="flex:1"><div class="habit-nom">Boire 2L d'eau</div><div class="habit-streak">3 jours</div></div>
                    <div class="habit-check todo"></div>
                </div>
            </div>
        </div>

        <div class="float-card right">
            <div class="float-label">Notification</div>
            <div class="float-val" style="font-size:0.9rem;">🏆 7 jours !</div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="features" id="fonctionnalites">
    <span class="section-label">Fonctionnalités</span>
    <h2 class="section-title">Tout ce qu'il te faut<br>pour réussir</h2>
    <p class="section-sub">Des outils puissants et simples pour transformer tes intentions en actions concrètes chaque jour.</p>

    <div class="feat-grid">
        <div class="feat-card">
            <div class="feat-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg></div>
            <div class="feat-title">Création d'habitudes</div>
            <div class="feat-desc">Crée tes habitudes en quelques secondes avec une couleur personnalisée, une description et une fréquence.</div>
        </div>
        <div class="feat-card">
            <div class="feat-icon"><svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></div>
            <div class="feat-title">Séries consécutives</div>
            <div class="feat-desc">Visualise tes jours consécutifs en temps réel. La motivation de ne pas briser ta série est puissante.</div>
        </div>
        <div class="feat-card">
            <div class="feat-icon"><svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
            <div class="feat-title">Statistiques détaillées</div>
            <div class="feat-desc">Graphiques d'activité sur 7 jours, taux de complétion quotidien et suivi de ta meilleure série.</div>
        </div>
        <div class="feat-card">
            <div class="feat-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
            <div class="feat-title">Système d'amis</div>
            <div class="feat-desc">Connecte-toi avec tes amis, envoie des demandes et vois leurs progrès pour vous motiver mutuellement.</div>
        </div>
        <div class="feat-card">
            <div class="feat-icon"><svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></div>
            <div class="feat-title">Notifications</div>
            <div class="feat-desc">Félicitations aux jalons 3, 7, 14 et 30 jours. Alertes pour les demandes d'amis et les succès partagés.</div>
        </div>
        <div class="feat-card">
            <div class="feat-icon"><svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
            <div class="feat-title">Sécurité maximale</div>
            <div class="feat-desc">Authentification à deux facteurs avec Google Authenticator pour protéger tes données personnelles.</div>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="how" id="comment">
    <div class="how-grid">
        <div>
            <span class="section-label">Comment ça marche</span>
            <h2 class="section-title">Simple, efficace,<br><em style="font-style:italic;color:var(--vert-c)">motivant</em></h2>
            <div class="steps-list">
                <div class="step-item">
                    <div class="step-num">1</div>
                    <div><div class="step-title">Crée tes habitudes</div><div class="step-desc">Définis ce que tu veux accomplir chaque jour ou semaine avec une couleur et une description.</div></div>
                </div>
                <div class="step-item">
                    <div class="step-num">2</div>
                    <div><div class="step-title">Coche chaque jour</div><div class="step-desc">Marque tes habitudes comme faites en un clic et regarde ta série grandir jour après jour.</div></div>
                </div>
                <div class="step-item">
                    <div class="step-num">3</div>
                    <div><div class="step-title">Analyse et partage</div><div class="step-desc">Consulte tes statistiques, reçois des félicitations et motive tes amis avec tes progrès.</div></div>
                </div>
            </div>
            <div style="margin-top:2rem;">
                <a href="{{ route('register') }}" class="btn-hero-primary" style="display:inline-flex;">Commencer maintenant →</a>
            </div>
        </div>

        <div class="dashboard-preview">
            <div class="db-header">
                <div class="db-title">Mes Statistiques</div>
                <span style="font-size:0.72rem;color:var(--muted);">Aujourd'hui</span>
            </div>
            <div class="db-stats">
                <div class="db-stat"><div class="db-stat-val">4</div><div class="db-stat-label">Actives</div></div>
                <div class="db-stat"><div class="db-stat-val">3</div><div class="db-stat-label">Faites</div></div>
                <div class="db-stat"><div class="db-stat-val">14🔥</div><div class="db-stat-label">Série</div></div>
            </div>
            <div class="db-habits">
                <div class="db-hab">
                    <div class="db-hab-dot" style="background:#2ecc71"></div>
                    <div style="flex:1"><div class="db-hab-name">Faire du sport</div><div class="db-progress"><div class="db-progress-fill" style="width:100%;background:#2ecc71"></div></div></div>
                    <span style="font-size:0.7rem;color:var(--vert-c);">✓</span>
                </div>
                <div class="db-hab">
                    <div class="db-hab-dot" style="background:#3498db"></div>
                    <div style="flex:1"><div class="db-hab-name">Lire 30 minutes</div><div class="db-progress"><div class="db-progress-fill" style="width:70%;background:#3498db"></div></div></div>
                    <span style="font-size:0.7rem;color:var(--vert-c);">✓</span>
                </div>
                <div class="db-hab">
                    <div class="db-hab-dot" style="background:#9b59b6"></div>
                    <div style="flex:1"><div class="db-hab-name">Méditation</div><div class="db-progress"><div class="db-progress-fill" style="width:50%;background:#9b59b6"></div></div></div>
                    <span style="font-size:0.7rem;color:var(--vert-c);">✓</span>
                </div>
                <div class="db-hab" style="opacity:.5">
                    <div class="db-hab-dot" style="background:#1abc9c"></div>
                    <div style="flex:1"><div class="db-hab-name">Boire 2L d'eau</div><div class="db-progress"><div class="db-progress-fill" style="width:30%;background:#1abc9c"></div></div></div>
                    <span style="font-size:0.7rem;color:var(--muted);">○</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section class="testi" id="temoignages">
    <div style="text-align:center;">
        <span class="section-label">Témoignages</span>
        <h2 class="section-title">Ce qu'ils en disent</h2>
    </div>
    <div class="testi-grid">
        <div class="testi-card">
            <div class="testi-stars">★★★★★</div>
            <p class="testi-text">"HabitFlow a complètement transformé ma routine matinale. Je n'aurais jamais cru tenir 30 jours de sport consécutifs !"</p>
            <div class="testi-author"><div class="testi-av">M</div><div><div class="testi-name">Marie K.</div><div class="testi-role">Étudiante en médecine</div></div></div>
        </div>
        <div class="testi-card">
            <div class="testi-stars">★★★★★</div>
            <p class="testi-text">"Le système de séries est incroyablement motivant. Je ne veux surtout pas briser ma série de 45 jours de lecture !"</p>
            <div class="testi-author"><div class="testi-av">J</div><div><div class="testi-name">Jean-Paul T.</div><div class="testi-role">Ingénieur logiciel</div></div></div>
        </div>
        <div class="testi-card">
            <div class="testi-stars">★★★★★</div>
            <p class="testi-text">"Partager mes progrès avec mes amis m'a donné une vraie responsabilité. On se motive ensemble chaque matin !"</p>
            <div class="testi-author"><div class="testi-av">A</div><div><div class="testi-name">Aminata D.</div><div class="testi-role">Coach de vie</div></div></div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta">
    <h2>Prêt à transformer<br>ta vie ?</h2>
    <p>Rejoins des milliers de personnes qui construisent de meilleures habitudes chaque jour.</p>
    <div class="cta-btns">
        <a href="{{ route('register') }}" class="btn-hero-primary" style="font-size:1rem;padding:1rem 2.2rem;">Créer mon compte gratuitement →</a>
        <a href="{{ route('login') }}" class="btn-hero-secondary" style="font-size:1rem;padding:1rem 2.2rem;">Se connecter</a>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-logo">Habit<span>Flow</span></div>
    <p>© 2026 HabitFlow — Application de suivi d'habitudes. Projet académique.</p>
</footer>

<script>
function toggleTheme() {
    const html = document.documentElement;
    const current = html.getAttribute('data-theme');
    html.setAttribute('data-theme', current === 'dark' ? 'light' : 'dark');
    localStorage.setItem('hf-theme', current === 'dark' ? 'light' : 'dark');
}
function toggleMenu() {
    document.getElementById('navLinks').classList.toggle('open');
}
function closeMenu() {
    document.getElementById('navLinks').classList.remove('open');
}
// Appliquer le thème sauvegardé
const saved = localStorage.getItem('hf-theme');
if (saved) document.documentElement.setAttribute('data-theme', saved);

// Fermer menu si clic extérieur
document.addEventListener('click', (e) => {
    const nav = document.getElementById('navLinks');
    const ham = document.getElementById('hamburger');
    if (nav && ham && !nav.contains(e.target) && !ham.contains(e.target)) {
        nav.classList.remove('open');
    }
});
</script>

</body>
</html>
