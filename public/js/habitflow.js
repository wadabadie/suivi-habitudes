const ThemeManager = (() => {
    const KEY  = 'hf-theme';
    const ATTR = 'data-theme';

    function storage(action, value) {
        try {
            if (action === 'get') return localStorage.getItem(KEY);
            if (action === 'set') localStorage.setItem(KEY, value);
        } catch(e) { return null; }
    }

    function get() { return storage('get') || 'dark'; }

    function apply(theme) {
        document.documentElement.setAttribute(ATTR, theme);
        storage('set', theme);
        const btn = document.getElementById('themeToggle');
        if (!btn) return;
        const dark  = btn.querySelector('.icon-dark');
        const light = btn.querySelector('.icon-light');
        if (dark)  dark.style.display  = theme === 'light' ? 'none' : 'inline-block';
        if (light) light.style.display = theme === 'dark'  ? 'none' : 'inline-block';
    }

    function toggle() { apply(get() === 'dark' ? 'light' : 'dark'); }

    function init() {
        apply(get());
        const btn = document.getElementById('themeToggle');
        if (btn) btn.addEventListener('click', toggle);
    }

    return { init, toggle, get };
})();


const OtpTimer = (() => {
    function init() {
        const numEl    = document.getElementById('timerNum');
        const spanEl   = document.getElementById('timerSpan');
        const cercleEl = document.getElementById('timerCircle');
        if (!numEl || !cercleEl) return;

        let secondes = 30 - (Math.floor(Date.now() / 1000) % 30);

        function update() {
            numEl.textContent = secondes;
            if (spanEl) spanEl.textContent = secondes;
            cercleEl.style.setProperty('--prog', (secondes / 30 * 100) + '%');
            secondes = secondes === 0 ? 30 : secondes - 1;
        }

        update();
        setInterval(update, 1000);
    }

    return { init };
})();


const ColourPicker = (() => {
    function init() {
        document.querySelectorAll('.hf-couleur-opt').forEach(el => {
            el.addEventListener('click', () => {
                document.querySelectorAll('.hf-couleur-opt').forEach(o => o.classList.remove('selected'));
                el.classList.add('selected');
                const couleur = el.dataset.couleur;
                const input = document.getElementById('couleurChoisie');
                if (input) input.value = couleur;
                const accent = document.getElementById('previewAccent');
                if (accent) accent.style.background = couleur;
            });
        });
    }
    return { init };
})();


const HabitPreview = (() => {
    function update() {
        const nom  = document.getElementById('champNom');
        const desc = document.querySelector('textarea[name=description]');
        const pNom  = document.getElementById('previewNom');
        const pDesc = document.getElementById('previewDesc');
        if (!nom || !pNom) return;
        pNom.textContent  = nom.value  || "Nom de l'habitude";
        if (pDesc && desc) pDesc.textContent = desc.value || "Aperçu de ta nouvelle habitude";
    }

    function init() {
        const nom  = document.getElementById('champNom');
        const desc = document.querySelector('textarea[name=description]');
        if (nom)  nom.addEventListener('input', update);
        if (desc) desc.addEventListener('input', update);
    }
    return { init, update };
})();


function copierSecret() {
    const el = document.getElementById('secretKey');
    if (!el) return;
    try {
        navigator.clipboard.writeText(el.textContent.trim()).then(() => {
            const btn = document.querySelector('.hf-copy-btn');
            if (!btn) return;
            const orig = btn.textContent;
            btn.textContent = 'Copié !';
            setTimeout(() => btn.textContent = orig, 2000);
        });
    } catch(e) {
        const range = document.createRange();
        range.selectNode(el);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand('copy');
    }
}


function initOtpInput() {
    document.querySelectorAll('.hf-otp-input').forEach(input => {
        input.addEventListener('input', () => {
            input.value = input.value.replace(/[^0-9]/g, '');
        });
    });
}



function initAlerts() {
    document.querySelectorAll('.hf-alert[data-dismiss]').forEach(el => {
        const btn = el.querySelector('.hf-alert-close');
        if (btn) btn.addEventListener('click', () => {
            el.style.opacity = '0';
            el.style.transition = 'opacity 0.3s';
            setTimeout(() => el.remove(), 300);
        });
        setTimeout(() => {
            if (el.parentNode) {
                el.style.opacity = '0';
                el.style.transition = 'opacity 0.5s';
                setTimeout(() => el.remove(), 500);
            }
        }, 5000);
    });
}


function initProgressBars() {
    const bars = document.querySelectorAll('.hf-progress-fill[data-width]');
    if (!bars.length) return;
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.width = entry.target.dataset.width;
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    bars.forEach(bar => { bar.style.width = '0'; observer.observe(bar); });
}


function initScrollTop() {
    const btn = document.createElement('button');
    btn.innerHTML = '↑';
    btn.setAttribute('aria-label', 'Retour en haut');
    btn.style.cssText = `
        position:fixed;bottom:2rem;right:2rem;
        width:42px;height:42px;border-radius:50%;
        background:#1a7a4a;color:#fff;border:none;
        font-size:1rem;font-weight:700;cursor:pointer;
        z-index:999;opacity:0;transform:translateY(20px);
        transition:all .3s;box-shadow:0 4px 15px rgba(26,122,74,0.4);
    `;
    document.body.appendChild(btn);
    window.addEventListener('scroll', () => {
        const visible = window.scrollY > 300;
        btn.style.opacity = visible ? '1' : '0';
        btn.style.transform = visible ? 'translateY(0)' : 'translateY(20px)';
    });
    btn.addEventListener('click', () => window.scrollTo({ top:0, behavior:'smooth' }));
    btn.addEventListener('mouseenter', () => btn.style.background = '#2ecc71');
    btn.addEventListener('mouseleave', () => btn.style.background = '#1a7a4a');
}



function initCardAnimations() {
    const cards = document.querySelectorAll('.hab-card, .stat-card, .hf-card, .hf-hab-card, .hf-stat-card');
    if (!cards.length) return;
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, i * 60);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.05 });
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(16px)';
        card.style.transition = 'opacity .4s ease, transform .4s ease';
        observer.observe(card);
    });
}



document.addEventListener('DOMContentLoaded', () => {
    ThemeManager.init();
    OtpTimer.init();
    ColourPicker.init();
    HabitPreview.init();
    initOtpInput();
    initAlerts();
    initProgressBars();
    initScrollTop();
    initCardAnimations();
});
