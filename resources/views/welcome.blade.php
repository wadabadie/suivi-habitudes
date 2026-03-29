<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HabitFlow — Transforme ta vie</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,600;0,700;1,300;1,600;1,700&family=Cabinet+Grotesk:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #050709;
            --surface: #0c0f18;
            --surface2: #131826;
            --glass: rgba(255,255,255,0.03);
            --bordure: rgba(255,255,255,0.06);
            --bordure2: rgba(255,255,255,0.1);
            --texte: #e8edf8;
            --muted: rgba(200,210,230,0.5);
            --emerald: #10b981;
            --emerald-dark: #059669;
            --emerald-glow: rgba(16,185,129,0.15);
            --gold: #d4a853;
            --gold-light: #f0c97a;
            --navbar: rgba(5,7,9,0.88);
            --shadow-xl: 0 40px 100px rgba(0,0,0,0.7);
            --shadow-emerald: 0 0 60px rgba(16,185,129,0.2);
        }
        [data-theme="light"] {
            --bg: #f5f3ee;
            --surface: #ffffff;
            --surface2: #f0ede8;
            --glass: rgba(0,0,0,0.02);
            --bordure: rgba(0,0,0,0.06);
            --bordure2: rgba(0,0,0,0.1);
            --texte: #16181f;
            --muted: rgba(22,24,31,0.5);
            --navbar: rgba(245,243,238,0.92);
            --shadow-xl: 0 40px 100px rgba(0,0,0,0.12);
        }

        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
        html { scroll-behavior:smooth; }
        body {
            font-family:'Cabinet Grotesk', sans-serif;
            background:var(--bg);
            color:var(--texte);
            overflow-x:hidden;
            transition:background .4s, color .4s;
            cursor:none;
        }

        /* ─── CUSTOM CURSOR ─── */
        .cursor {
            width:12px; height:12px;
            background:var(--emerald);
            border-radius:50%;
            position:fixed; z-index:9999;
            pointer-events:none;
            transition:transform .15s ease, opacity .3s;
            mix-blend-mode:difference;
        }
        .cursor-ring {
            width:40px; height:40px;
            border:1.5px solid rgba(16,185,129,0.5);
            border-radius:50%;
            position:fixed; z-index:9998;
            pointer-events:none;
            transition:transform .35s cubic-bezier(.25,.46,.45,.94), width .3s, height .3s;
        }

        /* ─── NOISE OVERLAY ─── */
        body::before {
            content:''; position:fixed; inset:0; z-index:1;
            pointer-events:none;
            background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            opacity:0.035;
        }

        /* ─── NAVBAR ─── */
        nav {
            position:fixed; top:0; left:0; right:0; z-index:500;
            display:flex; align-items:center; justify-content:space-between;
            padding:1.1rem 5%;
            background:var(--navbar);
            backdrop-filter:blur(24px) saturate(180%);
            -webkit-backdrop-filter:blur(24px) saturate(180%);
            border-bottom:1px solid var(--bordure);
            transition:all .4s;
        }
        nav.scrolled { padding:.75rem 5%; }

        .logo {
            font-family:'Cormorant Garamond', serif;
            font-size:1.7rem; font-weight:700;
            color:var(--texte); text-decoration:none;
            letter-spacing:-0.02em;
            display:flex; align-items:center; gap:.3rem;
        }
        .logo-dot { color:var(--emerald); }
        .logo-icon {
            width:28px; height:28px;
            background:linear-gradient(135deg, var(--emerald-dark), var(--emerald));
            border-radius:8px;
            display:flex; align-items:center; justify-content:center;
            font-size:.8rem;
        }

        .nav-links { display:flex; align-items:center; gap:.3rem; }
        .nav-link {
            color:var(--muted); text-decoration:none;
            font-size:.83rem; font-weight:500;
            padding:.45rem .9rem; border-radius:50px;
            transition:all .25s; letter-spacing:.01em;
        }
        .nav-link:hover { color:var(--texte); background:var(--bordure); }

        .btn-cta-nav {
            background:linear-gradient(135deg, var(--emerald-dark), var(--emerald));
            color:#fff !important; padding:.5rem 1.3rem;
            border-radius:50px; font-weight:700; font-size:.83rem;
            letter-spacing:.02em; box-shadow:0 4px 20px rgba(16,185,129,.3);
            transition:all .3s; text-decoration:none;
        }
        .btn-cta-nav:hover { transform:translateY(-2px); box-shadow:0 8px 30px rgba(16,185,129,.4); }

        .theme-btn {
            width:34px; height:34px; border-radius:50%;
            background:var(--surface2); border:1px solid var(--bordure2);
            color:var(--muted); cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            transition:all .2s; margin-right:.2rem;
        }
        .theme-btn:hover { color:var(--texte); border-color:var(--emerald); }
        .theme-btn svg { width:15px; height:15px; stroke:currentColor; fill:none; }
        .icon-sun { display:none; }
        [data-theme="light"] .icon-sun { display:block; }
        [data-theme="light"] .icon-moon { display:none; }

        .hamburger { display:none; flex-direction:column; gap:5px; cursor:pointer; padding:4px; background:none; border:none; }
        .hamburger span { display:block; width:22px; height:2px; background:var(--texte); border-radius:2px; transition:all .3s; }

        /* ─── HERO ─── */
        .hero {
            min-height:100vh;
            display:grid;
            grid-template-columns:1fr 1fr;
            align-items:center; gap:3rem;
            padding:9rem 5% 5rem;
            position:relative; overflow:hidden;
        }

        /* BIG BACKGROUND IMAGE */
        .hero-bg-image {
            position:absolute; inset:0; z-index:0;
            background-image:url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1600&q=80&auto=format&fit=crop');
            background-size:cover; background-position:center;
            opacity:.06;
            transition:opacity .4s;
        }
        [data-theme="light"] .hero-bg-image { opacity:.08; }

        .hero-overlay {
            position:absolute; inset:0; z-index:1;
            background:
                radial-gradient(ellipse 60% 80% at 65% 50%, rgba(16,185,129,.1) 0%, transparent 65%),
                radial-gradient(ellipse 40% 50% at 5% 90%, rgba(16,185,129,.06) 0%, transparent 60%),
                radial-gradient(ellipse 50% 60% at 50% -10%, rgba(16,185,129,.05) 0%, transparent 60%);
        }

        /* Animated grid */
        .hero-grid {
            position:absolute; inset:0; z-index:1; pointer-events:none;
            background-image:
                linear-gradient(var(--bordure) 1px, transparent 1px),
                linear-gradient(90deg, var(--bordure) 1px, transparent 1px);
            background-size:80px 80px;
            mask-image:radial-gradient(ellipse 75% 80% at 65% 50%, black 0%, transparent 70%);
        }

        .hero-content { position:relative; z-index:2; }

        .hero-badge {
            display:inline-flex; align-items:center; gap:.6rem;
            background:rgba(16,185,129,.06);
            border:1px solid rgba(16,185,129,.2);
            color:var(--emerald); padding:.4rem 1.1rem; border-radius:50px;
            font-size:.75rem; font-weight:700; margin-bottom:1.8rem;
            letter-spacing:.06em; text-transform:uppercase;
            animation:fadeUp .7s ease both;
        }
        .badge-pulse {
            width:6px; height:6px; background:var(--emerald);
            border-radius:50%; animation:pulse 2s infinite;
        }

        h1.hero-title {
            font-family:'Cormorant Garamond', serif;
            font-size:clamp(3rem,5.5vw,5.2rem);
            font-weight:600; line-height:1.05;
            letter-spacing:-0.03em; margin-bottom:1.6rem;
            animation:fadeUp .7s ease .12s both;
        }
        .title-line { display:block; }
        .title-em {
            font-style:italic; color:var(--emerald);
            position:relative; display:inline-block;
        }
        .title-em::after {
            content:''; position:absolute;
            left:0; bottom:-4px; right:0; height:2px;
            background:linear-gradient(90deg, var(--emerald), transparent);
        }

        .hero-desc {
            font-size:1.05rem; color:var(--muted); line-height:1.8;
            max-width:420px; margin-bottom:2.5rem;
            animation:fadeUp .7s ease .22s both;
            font-weight:300;
        }

        .hero-cta {
            display:flex; gap:1rem; flex-wrap:wrap;
            animation:fadeUp .7s ease .32s both;
        }
        .btn-primary {
            display:inline-flex; align-items:center; gap:.6rem;
            background:linear-gradient(135deg, var(--emerald-dark), var(--emerald));
            color:#fff; padding:1rem 2rem; border-radius:60px;
            text-decoration:none; font-weight:700; font-size:.95rem;
            transition:all .3s;
            box-shadow:0 8px 30px rgba(16,185,129,.35), inset 0 1px 0 rgba(255,255,255,.15);
        }
        .btn-primary:hover {
            transform:translateY(-3px);
            box-shadow:0 16px 50px rgba(16,185,129,.45), inset 0 1px 0 rgba(255,255,255,.2);
        }
        .btn-secondary {
            display:inline-flex; align-items:center; gap:.6rem;
            background:transparent; color:var(--texte);
            padding:1rem 2rem; border-radius:60px;
            text-decoration:none; font-weight:500; font-size:.95rem;
            border:1.5px solid var(--bordure2); transition:all .3s;
        }
        .btn-secondary:hover { border-color:var(--emerald); color:var(--emerald); }

        .hero-social-proof {
            display:flex; align-items:center; gap:1rem; margin-top:2.5rem;
            padding-top:2rem; border-top:1px solid var(--bordure);
            animation:fadeUp .7s ease .42s both;
        }
        .avatars { display:flex; }
        .avatar {
            width:34px; height:34px; border-radius:50%;
            border:2px solid var(--bg);
            margin-left:-10px; overflow:hidden;
        }
        .avatar:first-child { margin-left:0; }
        .avatar img { width:100%; height:100%; object-fit:cover; }
        .proof-text { font-size:.8rem; color:var(--muted); line-height:1.5; }
        .proof-text strong { color:var(--emerald); font-weight:700; }

        .hero-stats {
            display:flex; gap:2rem; margin-top:1.5rem;
            animation:fadeUp .7s ease .5s both;
        }
        .stat-num {
            font-family:'Cormorant Garamond', serif;
            font-size:2rem; font-weight:700; color:var(--emerald); line-height:1;
        }
        .stat-label { font-size:.7rem; color:var(--muted); margin-top:.25rem; text-transform:uppercase; letter-spacing:.06em; }

        /* ─── HERO VISUAL ─── */
        .hero-visual {
            position:relative; z-index:2;
            animation:fadeLeft .9s ease .2s both;
        }

        /* REAL PHOTO CARD */
        .hero-img-stack { position:relative; }
        .hero-img-main {
            width:100%; max-width:460px; margin:0 auto;
            border-radius:28px; overflow:hidden;
            border:1px solid var(--bordure2);
            box-shadow:var(--shadow-xl), var(--shadow-emerald);
            position:relative;
        }
        .hero-img-main img {
            width:100%; height:420px; object-fit:cover; display:block;
            filter:saturate(1.1) contrast(1.05);
        }
        .hero-img-main::after {
            content:''; position:absolute; inset:0;
            background:linear-gradient(to top, rgba(5,7,9,.85) 0%, transparent 60%);
        }
        .hero-img-caption {
            position:absolute; bottom:0; left:0; right:0; z-index:2;
            padding:1.5rem;
        }

        /* PHONE MOCKUP OVERLAY */
        .phone-overlay {
            position:absolute; bottom:-30px; right:-20px; z-index:10;
            width:200px;
            background:var(--surface);
            border:1px solid var(--bordure2);
            border-radius:24px; padding:1.1rem;
            box-shadow:0 20px 60px rgba(0,0,0,.5), inset 0 1px 0 rgba(255,255,255,.05);
            backdrop-filter:blur(20px);
        }
        .phone-ov-title { font-size:.65rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); margin-bottom:.8rem; }
        .mini-habit {
            display:flex; align-items:center; gap:.5rem;
            padding:.45rem .6rem; border-radius:10px;
            background:var(--glass); border:1px solid var(--bordure);
            margin-bottom:.4rem; font-size:.72rem;
        }
        .mini-dot { width:6px; height:24px; border-radius:3px; flex-shrink:0; }
        .mini-name { flex:1; font-weight:600; }
        .mini-check { font-size:.65rem; color:var(--emerald); }

        /* FLOATING CARDS */
        .float-card {
            position:absolute;
            background:var(--surface);
            border:1px solid var(--bordure2);
            border-radius:18px; padding:.9rem 1.1rem;
            box-shadow:0 12px 40px rgba(0,0,0,.4);
            backdrop-filter:blur(16px);
            z-index:10;
        }
        .float-card.top-left { top:-20px; left:-30px; animation:float 4s ease-in-out infinite; }
        .float-card.bottom-left { bottom:10px; left:-50px; animation:float 4s ease-in-out infinite 2s; }
        .float-label { font-size:.6rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); margin-bottom:.2rem; }
        .float-val { font-family:'Cormorant Garamond', serif; font-size:1.3rem; font-weight:700; color:var(--emerald); line-height:1; }
        .float-sub { font-size:.65rem; color:var(--muted); margin-top:.1rem; }

        /* ─── MARQUEE BAND ─── */
        .marquee-band {
            padding:1.2rem 0;
            background:linear-gradient(90deg, var(--emerald-dark), var(--emerald));
            overflow:hidden; white-space:nowrap;
            position:relative; z-index:2;
        }
        .marquee-inner {
            display:inline-flex; gap:3rem;
            animation:marquee 25s linear infinite;
        }
        .marquee-item {
            display:flex; align-items:center; gap:.6rem;
            font-size:.78rem; font-weight:700; color:#fff;
            text-transform:uppercase; letter-spacing:.08em;
            opacity:.9;
        }
        .marquee-sep { color:rgba(255,255,255,.4); font-size:1rem; }

        /* ─── FEATURES ─── */
        .features { padding:7rem 5%; background:var(--surface); position:relative; overflow:hidden; }
        .features::before {
            content:''; position:absolute; top:0; left:50%; transform:translateX(-50%);
            width:1px; height:100%; background:var(--bordure);
        }

        .section-eyebrow {
            display:inline-flex; align-items:center; gap:.5rem;
            color:var(--emerald); font-size:.72rem; font-weight:700;
            text-transform:uppercase; letter-spacing:.12em; margin-bottom:1rem;
        }
        .eyebrow-line { width:24px; height:1.5px; background:var(--emerald); }

        .section-title {
            font-family:'Cormorant Garamond', serif;
            font-size:clamp(2rem,4vw,3.5rem);
            font-weight:600; line-height:1.1; letter-spacing:-0.02em; margin-bottom:.8rem;
        }
        .section-sub { color:var(--muted); font-size:1rem; line-height:1.75; max-width:480px; margin-bottom:3.5rem; font-weight:300; }

        .feat-grid {
            display:grid; grid-template-columns:repeat(3,1fr); gap:1.5px;
            border:1.5px solid var(--bordure); border-radius:24px; overflow:hidden;
        }
        .feat-card {
            background:var(--surface); padding:2.2rem;
            transition:all .35s; position:relative; overflow:hidden;
            border-right:1px solid var(--bordure);
        }
        .feat-card:nth-child(3), .feat-card:nth-child(6) { border-right:none; }
        .feat-card:hover { background:rgba(16,185,129,.03); }
        .feat-card::before {
            content:''; position:absolute; inset:0;
            background:radial-gradient(ellipse 80% 80% at 20% 20%, rgba(16,185,129,.08) 0%, transparent 60%);
            opacity:0; transition:.4s;
        }
        .feat-card:hover::before { opacity:1; }

        .feat-img {
            width:100%; height:160px; object-fit:cover;
            border-radius:14px; margin-bottom:1.4rem;
            filter:saturate(.9) brightness(.85);
            transition:all .4s;
        }
        .feat-card:hover .feat-img { filter:saturate(1.1) brightness(.95); transform:scale(1.02); }

        .feat-icon-wrap {
            width:42px; height:42px; border-radius:12px;
            background:rgba(16,185,129,.08); border:1px solid rgba(16,185,129,.15);
            display:flex; align-items:center; justify-content:center;
            margin-bottom:1.2rem;
        }
        .feat-icon-wrap svg { width:18px; height:18px; stroke:var(--emerald); fill:none; }
        .feat-title { font-family:'Cormorant Garamond', serif; font-size:1.3rem; font-weight:700; margin-bottom:.5rem; }
        .feat-desc { color:var(--muted); font-size:.85rem; line-height:1.65; font-weight:300; }
        .feat-num {
            position:absolute; top:1.5rem; right:1.5rem;
            font-family:'Cormorant Garamond', serif; font-size:2.5rem;
            font-weight:300; color:var(--bordure2); line-height:1;
        }

        /* ─── GALLERY / LIFESTYLE ─── */
        .gallery { padding:6rem 5% 7rem; position:relative; }
        .gallery-header { text-align:center; margin-bottom:3.5rem; }
        .gallery-grid {
            display:grid;
            grid-template-columns:2fr 1fr 1fr;
            grid-template-rows:280px 280px;
            gap:1rem;
        }
        .gallery-item {
            border-radius:20px; overflow:hidden;
            position:relative; border:1px solid var(--bordure);
        }
        .gallery-item img {
            width:100%; height:100%; object-fit:cover;
            transition:transform .6s cubic-bezier(.25,.46,.45,.94), filter .4s;
            filter:saturate(.85);
        }
        .gallery-item:hover img { transform:scale(1.06); filter:saturate(1.1); }
        .gallery-item:first-child { grid-row:span 2; }
        .gallery-item::after {
            content:''; position:absolute; inset:0;
            background:linear-gradient(to top, rgba(5,7,9,.5) 0%, transparent 50%);
        }
        .gallery-caption {
            position:absolute; bottom:1rem; left:1rem; z-index:2;
            font-size:.75rem; font-weight:600; color:rgba(255,255,255,.7);
            text-transform:uppercase; letter-spacing:.06em;
        }

        /* ─── HOW IT WORKS ─── */
        .how { padding:7rem 5%; background:var(--surface); }
        .how-grid { display:grid; grid-template-columns:1fr 1fr; gap:6rem; align-items:center; }

        .steps-list { margin-top:2.5rem; display:flex; flex-direction:column; gap:0; }
        .step-item {
            display:flex; gap:1.5rem; align-items:flex-start;
            padding:1.5rem 0; border-bottom:1px solid var(--bordure);
            position:relative;
        }
        .step-item:last-child { border-bottom:none; }
        .step-num-wrap {
            min-width:48px; height:48px; border-radius:50%;
            background:var(--surface2); border:1.5px solid var(--bordure2);
            display:flex; align-items:center; justify-content:center;
            font-family:'Cormorant Garamond', serif; font-size:1.2rem;
            font-weight:700; flex-shrink:0; color:var(--emerald);
            transition:all .3s;
        }
        .step-item:hover .step-num-wrap {
            background:var(--emerald); color:#fff; border-color:var(--emerald);
            box-shadow:0 0 20px rgba(16,185,129,.4);
        }
        .step-title { font-weight:700; font-size:1rem; margin-bottom:.4rem; }
        .step-desc { color:var(--muted); font-size:.85rem; line-height:1.65; font-weight:300; }

        /* Dashboard preview */
        .dashboard-preview {
            background:var(--bg);
            border:1px solid var(--bordure2);
            border-radius:28px; padding:1.8rem;
            box-shadow:var(--shadow-xl);
            position:relative; overflow:hidden;
        }
        .db-ambient {
            position:absolute; top:-40px; right:-40px;
            width:200px; height:200px;
            background:radial-gradient(circle, rgba(16,185,129,.15), transparent 70%);
            pointer-events:none;
        }
        .db-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; }
        .db-title { font-family:'Cormorant Garamond', serif; font-size:1.2rem; font-weight:700; }
        .db-date { font-size:.72rem; color:var(--muted); }
        .db-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:.8rem; margin-bottom:1.4rem; }
        .db-stat {
            background:var(--surface); border:1px solid var(--bordure);
            border-radius:16px; padding:1rem; text-align:center;
            position:relative; overflow:hidden;
        }
        .db-stat::before {
            content:''; position:absolute; top:0; left:0; right:0; height:2px;
            background:linear-gradient(90deg, var(--emerald-dark), var(--emerald));
        }
        .db-stat-val { font-family:'Cormorant Garamond', serif; font-size:1.8rem; font-weight:700; color:var(--emerald); line-height:1; }
        .db-stat-label { font-size:.65rem; color:var(--muted); text-transform:uppercase; letter-spacing:.06em; margin-top:.3rem; }

        .db-habits { display:flex; flex-direction:column; gap:.5rem; }
        .db-hab {
            background:var(--surface); border:1px solid var(--bordure);
            border-radius:12px; padding:.8rem 1rem;
            display:flex; align-items:center; gap:.8rem;
        }
        .db-hab-bar { width:3px; height:30px; border-radius:2px; flex-shrink:0; }
        .db-hab-name { font-size:.82rem; font-weight:600; flex:1; }
        .db-progress { height:3px; background:var(--bordure); border-radius:2px; overflow:hidden; margin-top:.3rem; }
        .db-progress-fill { height:100%; border-radius:2px; transition:width .8s cubic-bezier(.34,1.56,.64,1); }

        /* ─── TESTIMONIALS ─── */
        .testi { padding:7rem 5%; }
        .testi-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:1.2rem; margin-top:4rem; }
        .testi-card {
            background:var(--surface);
            border:1px solid var(--bordure);
            border-radius:24px; padding:2rem;
            position:relative; overflow:hidden;
            transition:all .35s;
        }
        .testi-card:hover { border-color:rgba(16,185,129,.25); transform:translateY(-4px); }
        .testi-card::before {
            content:'\201C'; position:absolute;
            top:1rem; right:1.5rem;
            font-family:'Cormorant Garamond', serif;
            font-size:8rem; font-weight:700;
            color:var(--bordure); line-height:1; pointer-events:none;
        }
        .testi-stars { color:var(--gold); font-size:.85rem; margin-bottom:1.2rem; letter-spacing:3px; }
        .testi-text { color:var(--muted); font-size:.9rem; line-height:1.75; margin-bottom:1.5rem; font-weight:300; font-style:italic; }
        .testi-author { display:flex; align-items:center; gap:.9rem; }
        .testi-av {
            width:42px; height:42px; border-radius:50%; overflow:hidden;
            border:2px solid rgba(16,185,129,.3); flex-shrink:0;
        }
        .testi-av img { width:100%; height:100%; object-fit:cover; }
        .testi-av-fallback {
            width:42px; height:42px; border-radius:50%;
            background:linear-gradient(135deg, var(--emerald-dark), var(--emerald));
            display:flex; align-items:center; justify-content:center;
            font-weight:800; color:#fff; font-size:.9rem; flex-shrink:0;
        }
        .testi-name { font-weight:700; font-size:.88rem; }
        .testi-role { font-size:.73rem; color:var(--muted); margin-top:.15rem; }

        /* ─── CTA SECTION ─── */
        .cta {
            padding:8rem 5%;
            text-align:center; position:relative; overflow:hidden;
        }
        .cta-bg {
            position:absolute; inset:0;
            background-image:url('https://images.unsplash.com/photo-1557804506-669a67965ba0?w=1600&q=80&auto=format&fit=crop');
            background-size:cover; background-position:center;
            opacity:.07;
        }
        .cta-overlay {
            position:absolute; inset:0;
            background:radial-gradient(ellipse 70% 70% at 50% 50%, rgba(16,185,129,.12) 0%, transparent 70%);
        }
        .cta h2 {
            font-family:'Cormorant Garamond', serif;
            font-size:clamp(2.4rem,5vw,4.5rem);
            font-weight:600; line-height:1.1; letter-spacing:-0.03em;
            margin-bottom:1.2rem; position:relative; z-index:2;
        }
        .cta p { color:var(--muted); font-size:1.05rem; margin-bottom:2.5rem; position:relative; z-index:2; font-weight:300; }
        .cta-btns { display:flex; justify-content:center; gap:1.2rem; flex-wrap:wrap; position:relative; z-index:2; }

        /* Decorative line */
        .deco-line {
            position:absolute; left:50%; top:0; bottom:0; width:1px;
            background:linear-gradient(to bottom, transparent, var(--emerald), transparent);
            transform:translateX(-50%); opacity:.3; pointer-events:none;
        }

        /* ─── FOOTER ─── */
        footer {
            padding:2.5rem 5%;
            border-top:1px solid var(--bordure);
            display:flex; justify-content:space-between; align-items:center;
            flex-wrap:wrap; gap:1rem;
        }
        .footer-logo {
            font-family:'Cormorant Garamond', serif;
            font-size:1.3rem; font-weight:700; color:var(--texte);
        }
        .footer-logo span { color:var(--emerald); }
        footer p { color:var(--muted); font-size:.8rem; }
        .footer-links { display:flex; gap:1.5rem; }
        .footer-link { color:var(--muted); font-size:.8rem; text-decoration:none; transition:color .2s; }
        .footer-link:hover { color:var(--emerald); }

        /* ─── ANIMATIONS ─── */
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(32px); }
            to { opacity:1; transform:translateY(0); }
        }
        @keyframes fadeLeft {
            from { opacity:0; transform:translateX(48px); }
            to { opacity:1; transform:translateX(0); }
        }
        @keyframes float {
            0%, 100% { transform:translateY(0); }
            50% { transform:translateY(-12px); }
        }
        @keyframes pulse {
            0%, 100% { opacity:1; transform:scale(1); }
            50% { opacity:.4; transform:scale(1.4); }
        }
        @keyframes marquee {
            from { transform:translateX(0); }
            to { transform:translateX(-50%); }
        }
        @keyframes shimmer {
            0% { background-position:-200% 0; }
            100% { background-position:200% 0; }
        }
        @keyframes revealUp {
            from { opacity:0; transform:translateY(40px); }
            to { opacity:1; transform:translateY(0); }
        }

        .reveal { opacity:0; transform:translateY(36px); transition:opacity .7s ease, transform .7s ease; }
        .reveal.visible { opacity:1; transform:translateY(0); }
        .reveal-delay-1 { transition-delay:.1s; }
        .reveal-delay-2 { transition-delay:.2s; }
        .reveal-delay-3 { transition-delay:.3s; }
        .reveal-delay-4 { transition-delay:.4s; }

        /* ─── RESPONSIVE ─── */
        @media(max-width:1100px) {
            .gallery-grid { grid-template-columns:1fr 1fr; grid-template-rows:auto; }
            .gallery-item:first-child { grid-row:span 1; }
            .feat-grid { grid-template-columns:repeat(2,1fr); }
            .feat-card:nth-child(3) { border-right:1px solid var(--bordure); }
            .feat-card:nth-child(2), .feat-card:nth-child(4) { border-right:none; }
        }
        @media(max-width:900px) {
            .hero { grid-template-columns:1fr; padding-top:7rem; gap:3rem; }
            .hero-visual { order:-1; }
            .phone-overlay { right:0; bottom:-10px; }
            .float-card.top-left { left:-10px; }
            .float-card.bottom-left { left:-10px; }
            .how-grid { grid-template-columns:1fr; gap:3rem; }
            .testi-grid { grid-template-columns:1fr; }
        }
        @media(max-width:768px) {
            .feat-grid { grid-template-columns:1fr; }
            .feat-card { border-right:none !important; }
            .gallery-grid { grid-template-columns:1fr; }
            .hamburger { display:flex; }
            .nav-links {
                display:none; position:absolute; top:100%; left:0; right:0;
                background:var(--navbar); border-bottom:1px solid var(--bordure);
                flex-direction:column; padding:1rem 5%; gap:.3rem;
                backdrop-filter:blur(24px);
            }
            .nav-links.open { display:flex; }
            .cta-btns { flex-direction:column; align-items:center; }
            footer { flex-direction:column; text-align:center; }
            .db-stats { grid-template-columns:1fr 1fr; }
            .hero-img-main img { height:300px; }
            body { cursor:auto; }
            .cursor, .cursor-ring { display:none; }
        }
        @media(max-width:480px) {
            .hero { padding:6rem 4% 3rem; }
            .features, .gallery, .how, .testi, .cta { padding:4rem 4%; }
            .hero-stats { gap:1.2rem; }
        }
    </style>
</head>
<body>

<!-- Custom cursor -->
<div class="cursor" id="cursor"></div>
<div class="cursor-ring" id="cursorRing"></div>

<!-- ── NAVBAR ── -->
<nav id="navbar">
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
            <a href="{{ route('habitudes.index') }}" class="btn-cta-nav">Mon tableau de bord →</a>
        @else
            <a href="{{ route('login') }}" class="nav-link">Connexion</a>
            <a href="{{ route('register') }}" class="btn-cta-nav">Commencer — c'est gratuit</a>
        @endauth
    </div>
</nav>

<!-- ── HERO ── -->
<section class="hero">
    <div class="hero-bg-image"></div>
    <div class="hero-overlay"></div>
    <div class="hero-grid"></div>
    <div class="hero-content">
        <div class="hero-badge">
            <span class="badge-pulse"></span>
            Application de bien-être · 100% gratuit
        </div>

        <h1 class="hero-title">
            <span class="title-line">Construis des</span>
            <span class="title-line"><span class="title-em">habitudes</span></span>
            <span class="title-line">qui changent tout</span>
        </h1>

        <p class="hero-desc">
            HabitFlow transforme tes intentions en actions. Suis tes habitudes,
            visualise ta progression et partage tes victoires avec tes proches.
        </p>

        <div class="hero-cta">
            <a href="{{ route('register') }}" class="btn-primary">
                Commencer gratuitement
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
            <a href="{{ route('login') }}" class="btn-secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                Se connecter
            </a>
        </div>

        <div class="hero-social-proof">
            <div class="avatars">
                <div class="avatar"><img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=68&h=68&q=80&fit=crop&crop=face" alt=""></div>
                <div class="avatar"><img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=68&h=68&q=80&fit=crop&crop=face" alt=""></div>
                <div class="avatar"><img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=68&h=68&q=80&fit=crop&crop=face" alt=""></div>
                <div class="avatar"><img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=68&h=68&q=80&fit=crop&crop=face" alt=""></div>
            </div>
            <div class="proof-text">
                Rejoins <strong>+2 000</strong> personnes qui<br>transforment leur vie chaque jour
            </div>
        </div>

        <div class="hero-stats">
            <div>
                <div class="stat-num">21j</div>
                <div class="stat-label">Pour créer une habitude</div>
            </div>
            <div>
                <div class="stat-num">∞</div>
                <div class="stat-label">Habitudes possibles</div>
            </div>
            <div>
                <div class="stat-num">100%</div>
                <div class="stat-label">Gratuit toujours</div>
            </div>
        </div>
    </div>

    <div class="hero-visual">
        <div class="hero-img-stack">
            <!-- Floating stat card top -->
            <div class="float-card top-left">
                <div class="float-label">Série en cours</div>
                <div class="float-val">🔥 14 jours</div>
                <div class="float-sub">Ton record !</div>
            </div>

            <!-- Main image -->
            <div class="hero-img-main">
                <img
                  src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=920&q=85&auto=format&fit=crop"
                  alt="Personne faisant du sport avec motivation"
                  loading="eager"
                >
                <div class="hero-img-caption">
                    <!-- mini phone overlay inside -->
                    <div class="hero-img-wrap">
                </div>
        </div>
            </div>

            <!-- Phone overlay bottom right -->
            <div class="phone-overlay">
                <div class="phone-ov-title">📱 Aujourd'hui</div>
                <div class="mini-habit">
                    <div class="mini-dot" style="background:#10b981"></div>
                    <div class="mini-name">Sport</div>
                    <div class="mini-check">✓</div>
                </div>
                <div class="mini-habit">
                    <div class="mini-dot" style="background:#3b82f6"></div>
                    <div class="mini-name">Lecture</div>
                    <div class="mini-check">✓</div>
                </div>
                <div class="mini-habit">
                    <div class="mini-dot" style="background:#8b5cf6"></div>
                    <div class="mini-name">Méditation</div>
                    <div class="mini-check">✓</div>
                </div>
                <div class="mini-habit" style="opacity:.5">
                    <div class="mini-dot" style="background:#06b6d4"></div>
                    <div class="mini-name">Hydratation</div>
                    <div class="mini-check" style="color:var(--muted)">○</div>
                </div>
            </div>

            <!-- Bottom notification card -->
            <div class="float-card bottom-left">
                <div class="float-label">🏆 Succès débloqué</div>
                <div class="float-val" style="font-size:.95rem; color:var(--gold);">7 jours consécutifs !</div>
            </div>
        </div>
    </div>
</section>

<!-- ── MARQUEE ── -->
<div class="marquee-band">
    <div class="marquee-inner">
        <span class="marquee-item">🌿 Créez des habitudes</span>
        <span class="marquee-sep">·</span>
        <span class="marquee-item">🔥 Maintenez vos séries</span>
        <span class="marquee-sep">·</span>
        <span class="marquee-item">📊 Analysez vos progrès</span>
        <span class="marquee-sep">·</span>
        <span class="marquee-item">👥 Motivez vos amis</span>
        <span class="marquee-sep">·</span>
        <span class="marquee-item">🏆 Déverrouillez des succès</span>
        <span class="marquee-sep">·</span>
        <span class="marquee-item">🔒 Données sécurisées</span>
        <span class="marquee-sep">·</span>
        <!-- repeat for seamless loop -->
        <span class="marquee-item">🌿 Créez des habitudes</span>
        <span class="marquee-sep">·</span>
        <span class="marquee-item">🔥 Maintenez vos séries</span>
        <span class="marquee-sep">·</span>
        <span class="marquee-item">📊 Analysez vos progrès</span>
        <span class="marquee-sep">·</span>
        <span class="marquee-item">👥 Motivez vos amis</span>
        <span class="marquee-sep">·</span>
        <span class="marquee-item">🏆 Déverrouillez des succès</span>
        <span class="marquee-sep">·</span>
        <span class="marquee-item">🔒 Données sécurisées</span>
        <span class="marquee-sep">·</span>
    </div>
</div>

<!-- ── FEATURES ── -->
<section class="features" id="fonctionnalites">
    <div class="reveal">
        <div class="section-eyebrow"><span class="eyebrow-line"></span>Fonctionnalités<span class="eyebrow-line"></span></div>
        <div><img src="https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=800&q=80"
                 alt="Méditation et bien-être" class="hero-img">
                <div class="hero-img-overlay"></div>
                <div class="streak-pill">🔥 Série de 14 jours !</div>
        <h2 class="section-title">Tout ce qu'il te faut<br>pour <em style="font-style:italic;color:var(--emerald)">réussir</em></h2>
        <p class="section-sub">Des outils puissants et simples pour transformer tes intentions en victoires concrètes, chaque jour.</p>
    </div>

    <div class="feat-grid reveal reveal-delay-2">
        <div class="feat-card">
            <span class="feat-num">01</span>
            <img class="feat-img" src="https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b?w=600&q=80&auto=format&fit=crop" alt="Création d'habitudes" loading="lazy">
            <div class="feat-icon-wrap"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></div>
            <div class="feat-title">Création d'habitudes</div>
            <div class="feat-desc">Crée tes habitudes en quelques secondes avec couleur, description et fréquence personnalisées.</div>
        </div>
        <div class="feat-card">
            <span class="feat-num">02</span>
            <img class="feat-img" src="https://images.unsplash.com/photo-1546484396-fb3fc6f95f98?w=600&q=80&auto=format&fit=crop" alt="Séries consécutives" loading="lazy">
            <div class="feat-icon-wrap"><svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></div>
            <div class="feat-title">Séries consécutives</div>
            <div class="feat-desc">Visualise tes jours consécutifs en temps réel. Ne brise jamais ta flamme.</div>
        </div>
        <div class="feat-card">
            <span class="feat-num">03</span>
            <img class="feat-img" src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&q=80&auto=format&fit=crop" alt="Statistiques" loading="lazy">
            <div class="feat-icon-wrap"><svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
            <div class="feat-title">Statistiques détaillées</div>
            <div class="feat-desc">Graphiques d'activité, taux de complétion et suivi de ta meilleure série sur 7 jours.</div>
        </div>
        <div class="feat-card">
            <span class="feat-num">04</span>
            <img class="feat-img" src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=600&q=80&auto=format&fit=crop" alt="Système d'amis" loading="lazy">
            <div class="feat-icon-wrap"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
            <div class="feat-title">Système d'amis</div>
            <div class="feat-desc">Connecte-toi avec tes amis, envoie des demandes et vis leurs progrès pour vous motiver.</div>
        </div>
        <div class="feat-card">
            <span class="feat-num">05</span>
            <img class="feat-img" src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=600&q=80&auto=format&fit=crop" alt="Notifications" loading="lazy">
            <div class="feat-icon-wrap"><svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></div>
            <div class="feat-title">Notifications</div>
            <div class="feat-desc">Félicitations aux jalons 3, 7, 14 et 30 jours. Alertes pour tes amis et succès.</div>
        </div>
        <div class="feat-card">
            <span class="feat-num">06</span>
            <img class="feat-img" src="https://images.unsplash.com/photo-1563986768494-4dee2763ff3f?w=600&q=80&auto=format&fit=crop" alt="Sécurité" loading="lazy">
            <div class="feat-icon-wrap"><svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
            <div class="feat-title">Sécurité maximale</div>
            <div class="feat-desc">Authentification à deux facteurs avec Google Authenticator pour une protection absolue.</div>
        </div>
    </div>
</section>

<!-- ── GALLERY / LIFESTYLE ── -->
<section class="gallery">
    <div class="gallery-header reveal">
        <div class="section-eyebrow"><span class="eyebrow-line"></span>Lifestyle<span class="eyebrow-line"></span></div>
        <h2 class="section-title">Ta transformation,<br><em style="font-style:italic;color:var(--emerald)">jour après jour</em></h2>
    </div>

    <div class="gallery-grid reveal reveal-delay-2">
        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1487088678257-3a541e6e3922?w=800&q=85&auto=format&fit=crop" alt="Femme qui médite au lever du soleil" loading="lazy">
            <div class="gallery-caption">🌅 Commencer sa journée</div>
        </div>
        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?w=500&q=85&auto=format&fit=crop" alt="Course à pied" loading="lazy">
            <div class="gallery-caption">🏃 Sport quotidien</div>
        </div>
        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=500&q=85&auto=format&fit=crop" alt="Lecture" loading="lazy">
            <div class="gallery-caption">📚 30 min de lecture</div>
        </div>
        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1499728603263-13726abce5fd?w=500&q=85&auto=format&fit=crop" alt="Méditation" loading="lazy">
            <div class="gallery-caption">🧘 Méditation</div>
        </div>
        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=500&q=85&auto=format&fit=crop" alt="Nutrition saine" loading="lazy">
            <div class="gallery-caption">🥗 Nutrition saine</div>
        </div>
    </div>
</section>

<!-- ── HOW IT WORKS ── -->
<section class="how" id="comment">
    <div class="how-grid">
        <div class="reveal">
            <div class="section-eyebrow"><span class="eyebrow-line"></span>Comment ça marche</div>
            <h2 class="section-title">Simple, efficace,<br><em style="font-style:italic;color:var(--emerald)">motivant</em></h2>
            <div class="steps-list">
                <div class="step-item">
                    <div class="step-num-wrap">1</div>
                    <div>
                        <div class="step-title">Crée tes habitudes</div>
                        <div class="step-desc">Définis ce que tu veux accomplir chaque jour ou semaine avec une couleur et une description qui t'inspirent.</div>
                    </div>
                </div>
                <div class="step-item">
                    <div class="step-num-wrap">2</div>
                    <div>
                        <div class="step-title">Coche chaque jour</div>
                        <div class="step-desc">Marque tes habitudes comme accomplies en un clic et regarde ta série grandir jour après jour.</div>
                    </div>
                </div>
                <div class="step-item">
                    <div class="step-num-wrap">3</div>
                    <div>
                        <div class="step-title">Analyse et partage</div>
                        <div class="step-desc">Consulte tes statistiques, reçois des félicitations et motive tes amis avec tes progrès extraordinaires.</div>
                    </div>
                </div>
            </div>
            <div style="margin-top:2.5rem;">
                <a href="{{ route('register') }}" class="btn-primary" style="display:inline-flex;">Commencer maintenant →</a>
            </div>
        </div>

        <div class="dashboard-preview reveal reveal-delay-2">
            <div class="db-ambient"></div>
            <div class="db-header">
                <div class="db-title">Mes Statistiques</div>
                <span class="db-date">Aujourd'hui · 29 mars 2026</span>
            </div>
            <div class="db-stats">
                <div class="db-stat"><div class="db-stat-val">4</div><div class="db-stat-label">Actives</div></div>
                <div class="db-stat"><div class="db-stat-val">3</div><div class="db-stat-label">Faites</div></div>
                <div class="db-stat"><div class="db-stat-val">14🔥</div><div class="db-stat-label">Série</div></div>
            </div>
            <div class="db-habits">
                <div class="db-hab">
                    <div class="db-hab-bar" style="background:#10b981"></div>
                    <div style="flex:1">
                        <div class="db-hab-name" style="display:flex;align-items:center;justify-content:space-between;">
                            Faire du sport <span style="font-size:.7rem;color:var(--emerald);">✓</span>
                        </div>
                        <div class="db-progress"><div class="db-progress-fill" style="width:100%;background:#10b981"></div></div>
                    </div>
                </div>
                <div class="db-hab">
                    <div class="db-hab-bar" style="background:#3b82f6"></div>
                    <div style="flex:1">
                        <div class="db-hab-name" style="display:flex;align-items:center;justify-content:space-between;">
                            Lire 30 minutes <span style="font-size:.7rem;color:var(--emerald);">✓</span>
                        </div>
                        <div class="db-progress"><div class="db-progress-fill" style="width:70%;background:#3b82f6"></div></div>
                    </div>
                </div>
                <div class="db-hab">
                    <div class="db-hab-bar" style="background:#8b5cf6"></div>
                    <div style="flex:1">
                        <div class="db-hab-name" style="display:flex;align-items:center;justify-content:space-between;">
                            Méditation <span style="font-size:.7rem;color:var(--emerald);">✓</span>
                        </div>
                        <div class="db-progress"><div class="db-progress-fill" style="width:50%;background:#8b5cf6"></div></div>
                    </div>
                </div>
                <div class="db-hab" style="opacity:.5">
                    <div class="db-hab-bar" style="background:#06b6d4"></div>
                    <div style="flex:1">
                        <div class="db-hab-name" style="display:flex;align-items:center;justify-content:space-between;">
                            Boire 2L d'eau <span style="font-size:.7rem;color:var(--muted);">○</span>
                        </div>
                        <div class="db-progress"><div class="db-progress-fill" style="width:30%;background:#06b6d4"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── TESTIMONIALS ── -->
<section class="testi" id="temoignages">
    <div style="text-align:center;" class="reveal">
        <div class="section-eyebrow"><span class="eyebrow-line"></span>Témoignages<span class="eyebrow-line"></span></div>
        <h2 class="section-title">Ce qu'ils en disent</h2>
    </div>
    <div class="testi-grid">
        <div class="testi-card reveal reveal-delay-1">
            <div class="testi-stars">★★★★★</div>
            <p class="testi-text">HabitFlow a complètement transformé ma routine matinale. Je n'aurais jamais cru tenir 30 jours de sport consécutifs avant de l'utiliser.</p>
            <div class="testi-author">
                <div class="testi-av">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=84&h=84&q=80&fit=crop&crop=face" alt="Marie K.">
                </div>
                <div><div class="testi-name">Marie K.</div><div class="testi-role">Étudiante en médecine</div></div>
            </div>
        </div>
        <div class="testi-card reveal reveal-delay-2">
            <div class="testi-stars">★★★★★</div>
            <p class="testi-text">Le système de séries est incroyablement motivant. Je ne veux surtout pas briser ma série de 45 jours de lecture quotidienne !</p>
            <div class="testi-author">
                <div class="testi-av">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=84&h=84&q=80&fit=crop&crop=face" alt="Jean-Paul T.">
                </div>
                <div><div class="testi-name">Jean-Paul T.</div><div class="testi-role">Ingénieur logiciel</div></div>
            </div>
        </div>
        <div class="testi-card reveal reveal-delay-3">
            <div class="testi-stars">★★★★★</div>
            <p class="testi-text">Partager mes progrès avec mes amis m'a donné une vraie responsabilité. On se motive ensemble chaque matin et les résultats sont là.</p>
            <div class="testi-author">
                <div class="testi-av">
                    <img src="https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=84&h=84&q=80&fit=crop&crop=face" alt="Aminata D.">
                </div>
                <div><div class="testi-name">Aminata D.</div><div class="testi-role">Coach de vie</div></div>
            </div>
        </div>
    </div>
</section>

<!-- ── CTA ── -->
<section class="cta">
    <div class="cta-bg"></div>
    <div class="cta-overlay"></div>
    <div class="deco-line"></div>
    <h2 class="reveal">Prêt à transformer<br><em style="font-style:italic;color:var(--emerald)">ta vie ?</em></h2>
    <p class="reveal reveal-delay-1">Rejoins des milliers de personnes qui construisent de meilleures habitudes chaque jour.<br>C'est gratuit, toujours.</p>
    <div class="cta-btns reveal reveal-delay-2">
        <a href="{{ route('register') }}" class="btn-primary" style="font-size:1rem;padding:1.1rem 2.5rem;">
            Créer mon compte gratuitement →
        </a>
        <a href="{{ route('login') }}" class="btn-secondary" style="font-size:1rem;padding:1.1rem 2.5rem;">
            Se connecter
        </a>
    </div>
</section>

<!-- ── FOOTER ── -->
<footer>
    <div class="footer-logo">Habit<span>Flow</span></div>
    <div class="footer-links">
        <a href="#fonctionnalites" class="footer-link">Fonctionnalités</a>
        <a href="#comment" class="footer-link">Comment ça marche</a>
        <a href="#temoignages" class="footer-link">Témoignages</a>
    </div>
    <p>© 2026 HabitFlow — Application de suivi d'habitudes. Projet académique.</p>
</footer>

<script>
// ── CURSOR ──
const cursor = document.getElementById('cursor');
const ring = document.getElementById('cursorRing');
let mx = 0, my = 0, rx = 0, ry = 0;

document.addEventListener('mousemove', e => {
    mx = e.clientX; my = e.clientY;
    cursor.style.left = (mx - 6) + 'px';
    cursor.style.top = (my - 6) + 'px';
});

function animateRing() {
    rx += (mx - rx - 20) * 0.12;
    ry += (my - ry - 20) * 0.12;
    ring.style.left = rx + 'px';
    ring.style.top = ry + 'px';
    requestAnimationFrame(animateRing);
}
animateRing();

document.querySelectorAll('a, button, .feat-card, .testi-card').forEach(el => {
    el.addEventListener('mouseenter', () => {
        cursor.style.transform = 'scale(2.5)';
        ring.style.width = '60px';
        ring.style.height = '60px';
    });
    el.addEventListener('mouseleave', () => {
        cursor.style.transform = 'scale(1)';
        ring.style.width = '40px';
        ring.style.height = '40px';
    });
});

// ── THEME ──
function toggleTheme() {
    const html = document.documentElement;
    const current = html.getAttribute('data-theme');
    html.setAttribute('data-theme', current === 'dark' ? 'light' : 'dark');
    localStorage.setItem('hf-theme', current === 'dark' ? 'light' : 'dark');
}
function toggleMenu() { document.getElementById('navLinks').classList.toggle('open'); }
function closeMenu() { document.getElementById('navLinks').classList.remove('open'); }

const saved = localStorage.getItem('hf-theme');
if (saved) document.documentElement.setAttribute('data-theme', saved);

document.addEventListener('click', e => {
    const nav = document.getElementById('navLinks');
    const ham = document.getElementById('hamburger');
    if (nav && ham && !nav.contains(e.target) && !ham.contains(e.target)) {
        nav.classList.remove('open');
    }
});

// ── NAVBAR SCROLL ──
window.addEventListener('scroll', () => {
    document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 40);
});

// ── SCROLL REVEAL ──
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });

document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

// ── ANIMATED COUNTER ──
function animateCounter(el, target) {
    let start = 0;
    const duration = 1500;
    const step = timestamp => {
        if (!start) start = timestamp;
        const progress = Math.min((timestamp - start) / duration, 1);
        const ease = 1 - Math.pow(1 - progress, 3);
        el.textContent = Math.floor(ease * target);
        if (progress < 1) requestAnimationFrame(step);
        else el.textContent = target;
    };
    requestAnimationFrame(step);
}
</script>

</body>
</html>
