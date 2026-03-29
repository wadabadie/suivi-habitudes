<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HabitFlow — Transforme ta vie, une habitude à la fois</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --vert:       #1a7a4a;
            --vert-clair: #2ecc71;
            --vert-pale:  #e8f5ee;
            --noir:       #0d1117;
            --gris:       #6b7280;
            --blanc:      #ffffff;
            --or:         #c9a84c;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--noir);
            color: var(--blanc);
            overflow-x: hidden;
        }

        /* ── NAVBAR ── */
        nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.2rem 5%;
            background: rgba(13,17,23,0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem; font-weight: 900;
            color: var(--blanc);
            letter-spacing: -0.03em;
        }
        .logo span { color: var(--vert-clair); }
        .nav-links { display: flex; align-items: center; gap: 2rem; }
        .nav-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none; font-size: 0.95rem; font-weight: 400;
            transition: color .2s;
        }
        .nav-links a:hover { color: var(--blanc); }
        .btn-nav {
            background: var(--vert) !important;
            color: var(--blanc) !important;
            padding: 0.55rem 1.4rem !important;
            border-radius: 50px !important;
            font-weight: 500 !important;
            transition: background .2s !important;
        }
        .btn-nav:hover { background: var(--vert-clair) !important; }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            padding: 8rem 5% 4rem;
            gap: 4rem;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 60% 60% at 70% 50%, rgba(26,122,74,0.15) 0%, transparent 70%),
                radial-gradient(ellipse 40% 40% at 20% 80%, rgba(46,204,113,0.08) 0%, transparent 60%);
            pointer-events: none;
        }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: rgba(46,204,113,0.12);
            border: 1px solid rgba(46,204,113,0.3);
            color: var(--vert-clair);
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.82rem; font-weight: 500;
            margin-bottom: 1.5rem;
            animation: fadeUp 0.6s ease both;
        }
        .hero-badge::before {
            content: '';
            width: 6px; height: 6px;
            background: var(--vert-clair);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.8rem, 5vw, 4.5rem);
            font-weight: 900;
            line-height: 1.1;
            letter-spacing: -0.03em;
            margin-bottom: 1.5rem;
            animation: fadeUp 0.6s ease 0.1s both;
        }
        .hero h1 em {
            font-style: italic;
            color: var(--vert-clair);
        }

        .hero p {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.65);
            line-height: 1.7;
            max-width: 480px;
            margin-bottom: 2.5rem;
            animation: fadeUp 0.6s ease 0.2s both;
        }

        .hero-cta {
            display: flex; gap: 1rem; flex-wrap: wrap;
            animation: fadeUp 0.6s ease 0.3s both;
        }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: var(--vert);
            color: var(--blanc);
            padding: 0.9rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500; font-size: 1rem;
            transition: all .25s;
            border: 2px solid var(--vert);
        }
        .btn-primary:hover {
            background: var(--vert-clair);
            border-color: var(--vert-clair);
            transform: translateY(-2px);
        }
        .btn-secondary {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: transparent;
            color: var(--blanc);
            padding: 0.9rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500; font-size: 1rem;
            border: 2px solid rgba(255,255,255,0.2);
            transition: all .25s;
        }
        .btn-secondary:hover {
            border-color: rgba(255,255,255,0.5);
            transform: translateY(-2px);
        }

        .hero-stats {
            display: flex; gap: 2.5rem; margin-top: 3rem;
            animation: fadeUp 0.6s ease 0.4s both;
        }
        .stat-item { text-align: left; }
        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 2rem; font-weight: 700;
            color: var(--vert-clair);
        }
        .stat-label {
            font-size: 0.8rem; color: rgba(255,255,255,0.5);
            text-transform: uppercase; letter-spacing: 0.05em;
        }

        /* ── HERO IMAGE ── */
        .hero-visual {
            position: relative;
            animation: fadeLeft 0.8s ease 0.2s both;
        }
        .hero-img-main {
            width: 100%; height: 580px;
            object-fit: cover;
            border-radius: 24px;
            display: block;
        }
        .hero-card-float {
            position: absolute;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 16px;
            padding: 1rem 1.4rem;
        }
        .hero-card-float.card-1 {
            bottom: -20px; left: -30px;
            animation: float 3s ease-in-out infinite;
        }
        .hero-card-float.card-2 {
            top: 30px; right: -20px;
            animation: float 3s ease-in-out infinite 1.5s;
        }
        .card-float-title {
            font-size: 0.75rem; color: rgba(255,255,255,0.6);
            text-transform: uppercase; letter-spacing: 0.05em;
            margin-bottom: 0.3rem;
        }
        .card-float-value {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem; font-weight: 700;
            color: var(--vert-clair);
        }
        .card-float-sub { font-size: 0.8rem; color: rgba(255,255,255,0.5); }

        /* Streak badge */
        .streak-badge {
            position: absolute; top: 20px; left: 20px;
            background: linear-gradient(135deg, #ff6b35, #f7c59f);
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem; font-weight: 700;
            display: flex; align-items: center; gap: 0.4rem;
        }

        /* ── FEATURES ── */
        .features {
            padding: 6rem 5%;
            background: #0a0e14;
        }
        .section-label {
            display: inline-block;
            color: var(--vert-clair);
            font-size: 0.8rem; font-weight: 500;
            text-transform: uppercase; letter-spacing: 0.1em;
            margin-bottom: 1rem;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800; line-height: 1.2;
            letter-spacing: -0.02em;
            margin-bottom: 1rem;
        }
        .section-sub {
            color: rgba(255,255,255,0.55);
            font-size: 1.05rem; line-height: 1.7;
            max-width: 520px;
            margin-bottom: 3.5rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }
        .feature-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 2rem;
            transition: all .3s;
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, var(--vert), var(--vert-clair));
            opacity: 0;
            transition: opacity .3s;
        }
        .feature-card:hover {
            background: rgba(255,255,255,0.06);
            border-color: rgba(46,204,113,0.2);
            transform: translateY(-4px);
        }
        .feature-card:hover::before { opacity: 1; }

        .feature-icon {
            width: 48px; height: 48px;
            background: rgba(46,204,113,0.12);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.2rem;
            font-size: 1.4rem;
        }
        .feature-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem; font-weight: 700;
            margin-bottom: 0.6rem;
        }
        .feature-desc {
            color: rgba(255,255,255,0.55);
            font-size: 0.92rem; line-height: 1.6;
        }

        /* ── SHOWCASE ── */
        .showcase {
            padding: 6rem 5%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
        }
        .showcase-imgs {
            position: relative;
        }
        .showcase-img-main {
            width: 85%; height: 480px;
            object-fit: cover;
            border-radius: 20px;
            display: block;
        }
        .showcase-img-secondary {
            position: absolute;
            bottom: -30px; right: 0;
            width: 55%; height: 260px;
            object-fit: cover;
            border-radius: 16px;
            border: 4px solid var(--noir);
        }

        /* ── TESTIMONIALS ── */
        .testimonials {
            padding: 6rem 5%;
            background: #0a0e14;
            text-align: center;
        }
        .testi-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 3rem;
        }
        .testi-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 2rem;
            text-align: left;
        }
        .testi-stars { color: var(--or); font-size: 1rem; margin-bottom: 1rem; }
        .testi-text {
            color: rgba(255,255,255,0.75);
            font-size: 0.95rem; line-height: 1.7;
            margin-bottom: 1.2rem;
            font-style: italic;
        }
        .testi-author { display: flex; align-items: center; gap: 0.8rem; }
        .testi-avatar {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--vert), var(--vert-clair));
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 1rem; color: white;
        }
        .testi-name { font-weight: 500; font-size: 0.9rem; }
        .testi-role { color: rgba(255,255,255,0.45); font-size: 0.8rem; }

        /* ── CTA FINAL ── */
        .cta-section {
            padding: 6rem 5%;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .cta-section::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(ellipse 70% 70% at 50% 50%, rgba(26,122,74,0.2) 0%, transparent 70%);
        }
        .cta-section h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.2rem, 4vw, 3.5rem);
            font-weight: 900; line-height: 1.2;
            letter-spacing: -0.02em;
            margin-bottom: 1.2rem;
            position: relative;
        }
        .cta-section p {
            color: rgba(255,255,255,0.6);
            font-size: 1.1rem; margin-bottom: 2.5rem;
            position: relative;
        }
        .cta-buttons { display: flex; justify-content: center; gap: 1rem; position: relative; }

        /* ── FOOTER ── */
        footer {
            padding: 2rem 5%;
            border-top: 1px solid rgba(255,255,255,0.06);
            display: flex; justify-content: space-between; align-items: center;
        }
        .footer-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem; font-weight: 700;
        }
        .footer-logo span { color: var(--vert-clair); }
        footer p { color: rgba(255,255,255,0.35); font-size: 0.85rem; }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeLeft {
            from { opacity: 0; transform: translateX(40px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-10px); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.5; transform: scale(1.3); }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .hero { grid-template-columns: 1fr; padding-top: 6rem; }
            .hero-visual { display: none; }
            .features-grid { grid-template-columns: 1fr; }
            .showcase { grid-template-columns: 1fr; }
            .testi-grid { grid-template-columns: 1fr; }
            .hero-stats { gap: 1.5rem; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <div class="logo">Habit<span>Flow</span></div>
    <div class="nav-links">
        <a href="#fonctionnalites">Fonctionnalités</a>
        <a href="#temoignages">Témoignages</a>
        @auth
            <a href="{{ route('habitudes.index') }}" class="btn-nav">Mon tableau de bord</a>
        @else
            <a href="{{ route('login') }}">Connexion</a>
            <a href="{{ route('register') }}" class="btn-nav">Commencer</a>
        @endauth
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-badge">Application de bien-être</div>
        <h1>
            Construis des <em>habitudes</em><br>
            qui changent ta vie
        </h1>
        <p>
            HabitFlow t'aide à créer, suivre et maintenir tes habitudes quotidiennes.
            Visualise tes progrès, brise tes records et partage tes succès avec tes amis.
        </p>
        <div class="hero-cta">
            <a href="{{ route('register') }}" class="btn-primary">
                Commencer gratuitement →
            </a>
            <a href="{{ route('login') }}" class="btn-secondary">
                Se connecter
            </a>
        </div>
        <div class="hero-stats">
            <div class="stat-item">
                <div class="stat-num">21</div>
                <div class="stat-label">jours pour une habitude</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">∞</div>
                <div class="stat-label">habitudes possibles</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">100%</div>
                <div class="stat-label">gratuit</div>
            </div>
        </div>
    </div>

    <div class="hero-visual">
        <div class="streak-badge">🔥 Série de 7 jours !</div>
        <img
            src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=800&q=80"
            alt="Personne faisant du sport"
            class="hero-img-main"
        >
        <div class="hero-card-float card-1">
            <div class="card-float-title">Habitude du jour</div>
            <div class="card-float-value">✓ Méditation</div>
            <div class="card-float-sub">Complétée à 7h30</div>
        </div>
        <div class="hero-card-float card-2">
            <div class="card-float-title">Progression</div>
            <div class="card-float-value">86%</div>
            <div class="card-float-sub">Cette semaine</div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="features" id="fonctionnalites">
    <span class="section-label">Fonctionnalités</span>
    <h2 class="section-title">Tout ce dont tu as besoin<br>pour réussir</h2>
    <p class="section-sub">
        Des outils puissants et simples pour transformer tes intentions en actions concrètes.
    </p>

    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">📋</div>
            <div class="feature-title">Création d'habitudes</div>
            <div class="feature-desc">Crée tes habitudes en quelques secondes. Définis la fréquence, la couleur et suis ta progression.</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🔥</div>
            <div class="feature-title">Séries consécutives</div>
            <div class="feature-desc">Visualise tes jours consécutifs et reste motivé. Ne brise pas ta série !</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📊</div>
            <div class="feature-title">Statistiques détaillées</div>
            <div class="feature-desc">Des graphiques clairs pour analyser ta progression sur 7 jours et plus.</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">👥</div>
            <div class="feature-title">Système d'amis</div>
            <div class="feature-desc">Connecte-toi avec tes amis, partage tes succès et motivez-vous mutuellement.</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🔔</div>
            <div class="feature-title">Notifications</div>
            <div class="feature-desc">Reçois des félicitations quand tu atteins un jalon. Reste informé des demandes d'amis.</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🔐</div>
            <div class="feature-title">Sécurité maximale</div>
            <div class="feature-desc">Authentification à deux facteurs avec Google Authenticator pour protéger ton compte.</div>
        </div>
    </div>
</section>

<!-- SHOWCASE -->
<section class="showcase">
    <div class="showcase-imgs">
        <img
            src="https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=800&q=80"
            alt="Méditation matinale"
            class="showcase-img-main"
        >
        <img
            src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=800&q=80"
            alt="Fitness et sport"
            class="showcase-img-secondary"
        >
    </div>
    <div>
        <span class="section-label">Comment ça marche</span>
        <h2 class="section-title">Simple, efficace,<br><em style="color:var(--vert-clair);font-style:italic;">motivant</em></h2>
        <p class="section-sub">
            En seulement 3 étapes, commence à transformer ta vie dès aujourd'hui.
        </p>
        <div style="display:flex;flex-direction:column;gap:1.5rem;">
            <div style="display:flex;gap:1.2rem;align-items:flex-start;">
                <div style="min-width:40px;height:40px;background:var(--vert);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.9rem;">1</div>
                <div>
                    <div style="font-weight:600;margin-bottom:0.3rem;">Crée tes habitudes</div>
                    <div style="color:rgba(255,255,255,0.55);font-size:0.92rem;line-height:1.6;">Définis ce que tu veux accomplir chaque jour ou chaque semaine.</div>
                </div>
            </div>
            <div style="display:flex;gap:1.2rem;align-items:flex-start;">
                <div style="min-width:40px;height:40px;background:var(--vert);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.9rem;">2</div>
                <div>
                    <div style="font-weight:600;margin-bottom:0.3rem;">Coche chaque jour</div>
                    <div style="color:rgba(255,255,255,0.55);font-size:0.92rem;line-height:1.6;">Marque tes habitudes comme faites et regarde ta série grandir.</div>
                </div>
            </div>
            <div style="display:flex;gap:1.2rem;align-items:flex-start;">
                <div style="min-width:40px;height:40px;background:var(--vert);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.9rem;">3</div>
                <div>
                    <div style="font-weight:600;margin-bottom:0.3rem;">Analyse et partage</div>
                    <div style="color:rgba(255,255,255,0.55);font-size:0.92rem;line-height:1.6;">Consulte tes statistiques et motive tes amis avec tes progrès.</div>
                </div>
            </div>
        </div>
        <div style="margin-top:2.5rem;">
            <a href="{{ route('register') }}" class="btn-primary">Commencer maintenant →</a>
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section class="testimonials" id="temoignages">
    <span class="section-label">Témoignages</span>
    <h2 class="section-title">Ce qu'ils en disent</h2>
    <div class="testi-grid">
        <div class="testi-card">
            <div class="testi-stars">★★★★★</div>
            <p class="testi-text">"HabitFlow a complètement changé ma routine matinale. Je n'aurais jamais cru tenir 30 jours de sport consécutifs !"</p>
            <div class="testi-author">
                <div class="testi-avatar">M</div>
                <div>
                    <div class="testi-name">Marie K.</div>
                    <div class="testi-role">Étudiante en médecine</div>
                </div>
            </div>
        </div>
        <div class="testi-card">
            <div class="testi-stars">★★★★★</div>
            <p class="testi-text">"Le système de séries est incroyablement motivant. Je ne veux surtout pas briser ma série de 45 jours de lecture !"</p>
            <div class="testi-author">
                <div class="testi-avatar">J</div>
                <div>
                    <div class="testi-name">Jean-Paul T.</div>
                    <div class="testi-role">Ingénieur logiciel</div>
                </div>
            </div>
        </div>
        <div class="testi-card">
            <div class="testi-stars">★★★★★</div>
            <p class="testi-text">"Partager mes progrès avec mes amis m'a donné une vraie responsabilité. On se motive ensemble chaque matin !"</p>
            <div class="testi-author">
                <div class="testi-avatar">A</div>
                <div>
                    <div class="testi-name">Aminata D.</div>
                    <div class="testi-role">Coach de vie</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="cta-section">
    <h2>Prêt à transformer<br>ta vie ?</h2>
    <p>Rejoins des milliers de personnes qui construisent de meilleures habitudes chaque jour.</p>
    <div class="cta-buttons">
        <a href="{{ route('register') }}" class="btn-primary" style="font-size:1.05rem;padding:1rem 2.5rem;">
            Créer mon compte gratuitement →
        </a>
        <a href="{{ route('login') }}" class="btn-secondary" style="font-size:1.05rem;padding:1rem 2.5rem;">
            Se connecter
        </a>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-logo">Habit<span>Flow</span></div>
    <p>© 2026 HabitFlow — Application de suivi d'habitudes</p>
</footer>

</body>
</html>
