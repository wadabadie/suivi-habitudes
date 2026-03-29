
const ThemeManager = (() => {
    const KEY = 'hf-theme';
    const ATTR = 'data-theme';

    function get() {
        return localStorage.getItem(KEY) || 'dark';
    }

    function apply(theme) {
        document.documentElement.setAttribute(ATTR, theme);
        localStorage.setItem(KEY, theme);
        // Mettre à jour l'icône du toggle
        const btn = document.getElementById('themeToggle');
        if (!btn) return;
        btn.querySelector('.icon-dark').style.display  = theme === 'light' ? 'none' : 'block';
        btn.querySelector('.icon-light').style.display = theme === 'dark'  ? 'none' : 'block';
    }

    function toggle() {
        apply(get() === 'dark' ? 'light' : 'dark');
    }

    function init() {
        apply(get());
        const btn = document.getElementById('themeToggle');
        if (btn) btn.addEventListener('click', toggle);
    }

    return { init, toggle, get };
})();


/* ══════════════════════════════════════════
   2. TIMER OTP (codes 2FA)
══════════════════════════════════════════ */
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
            if (secondes === 0) secondes = 30;
            else secondes--;
        }

        update();
        setInterval(update, 1000);
    }

    return { init };
})();


/* ══════════════════════════════════════════
   3. SÉLECTEUR DE COULEUR
══════════════════════════════════════════ */
const ColourPicker = (() => {
    function init() {
        document.querySelectorAll('.hf-couleur-opt').forEach(el => {
            el.addEventListener('click', () => {
                document.querySelectorAll('.hf-couleur-opt').forEach(o => o.classList.remove('selected'));
                el.classList.add('selected');
                const couleur = el.dataset.couleur;
                const hiddenInput = document.getElementById('couleurChoisie');
                if (hiddenInput) hiddenInput.value = couleur;
                // Mettre à jour l'aperçu
                const accent = document.getElementById('previewAccent');
                if (accent) accent.style.background = couleur;
            });
        });
    }

    return { init };
})();


/* ══════════════════════════════════════════
   4. APERÇU TEMPS RÉEL (formulaires habitude)
══════════════════════════════════════════ */
const HabitPreview = (() => {
    function update() {
        const nomInput  = document.getElementById('champNom');
        const descInput = document.querySelector('textarea[name=description]');
        const previewNom  = document.getElementById('previewNom');
        const previewDesc = document.getElementById('previewDesc');

        if (!nomInput || !previewNom) return;

        previewNom.textContent  = nomInput.value  || "Nom de l'habitude";
        if (previewDesc && descInput) {
            previewDesc.textContent = descInput.value || "Aperçu de ta nouvelle habitude";
        }
    }

    function init() {
        const nomInput  = document.getElementById('champNom');
        const descInput = document.querySelector('textarea[name=description]');
        if (nomInput)  nomInput.addEventListener('input', update);
        if (descInput) descInput.addEventListener('input', update);
    }

    return { init, update };
})();


/* ══════════════════════════════════════════
   5. COPIER CLEF 2FA
══════════════════════════════════════════ */
function copierSecret() {
    const secretEl = document.getElementById('secretKey');
    if (!secretEl) return;
    navigator.clipboard.writeText(secretEl.textContent.trim()).then(() => {
        const btn = document.querySelector('.hf-copy-btn');
        if (!btn) return;
        const original = btn.textContent;
        btn.textContent = 'Copié !';
        setTimeout(() => btn.textContent = original, 2000);
    });
}


/* ══════════════════════════════════════════
   6. AUTO-FORMAT INPUT OTP (chiffres seulement)
══════════════════════════════════════════ */
function initOtpInput() {
    document.querySelectorAll('.hf-otp-input').forEach(input => {
        input.addEventListener('input', () => {
            input.value = input.value.replace(/[^0-9]/g, '');
        });
    });
}


/* ══════════════════════════════════════════
   7. FERMER LES ALERTES FLASH
══════════════════════════════════════════ */
function initAlerts() {
    document.querySelectorAll('.hf-alert[data-dismiss]').forEach(el => {
        const btn = el.querySelector('.hf-alert-close');
        if (btn) btn.addEventListener('click', () => {
            el.style.opacity = '0';
            el.style.transition = 'opacity 0.3s';
            setTimeout(() => el.remove(), 300);
        });

        // Auto-dismiss après 5s
        setTimeout(() => {
            if (el.parentNode) {
                el.style.opacity = '0';
                el.style.transition = 'opacity 0.5s';
                setTimeout(() => el.remove(), 500);
            }
        }, 5000);
    });
}


/* ══════════════════════════════════════════
   8. ANIMATIONS PROGRESS BARS (intersection observer)
══════════════════════════════════════════ */
function initProgressBars() {
    const bars = document.querySelectorAll('.hf-progress-fill[data-width]');
    if (!bars.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const bar = entry.target;
                bar.style.width = bar.dataset.width;
                observer.unobserve(bar);
            }
        });
    }, { threshold: 0.1 });

    bars.forEach(bar => {
        bar.style.width = '0';
        observer.observe(bar);
    });
}


/* ══════════════════════════════════════════
   INIT GLOBAL
══════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
    ThemeManager.init();
    OtpTimer.init();
    ColourPicker.init();
    HabitPreview.init();
    initOtpInput();
    initAlerts();
    initProgressBars();
});
