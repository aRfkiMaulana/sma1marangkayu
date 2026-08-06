import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// ── LIGHTBOX ──────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('lightbox');
    if (!overlay) return;

    const img     = document.getElementById('lightbox-img');
    const caption = document.getElementById('lightbox-caption');
    const btnPrev = document.getElementById('lightbox-prev');
    const btnNext = document.getElementById('lightbox-next');
    const counter = document.getElementById('lightbox-counter');

    let items       = [];
    let current     = 0;
    let touchStartX = 0;
    let touchStartY = 0;

    /* ── helpers ── */
    const isMobile = () => window.innerWidth < 768;

    function show(index) {
        current = (index + items.length) % items.length;

        // animasi fade-out → ganti src → fade-in
        img.style.opacity   = '0';
        img.style.transform = 'scale(0.95)';
        setTimeout(() => {
            img.src             = items[current].src;
            img.alt             = items[current].caption;
            img.style.opacity   = '1';
            img.style.transform = 'scale(1)';
        }, 150);

        if (caption) caption.textContent = items[current].caption || '';
        if (counter) counter.textContent = items.length > 1
            ? `${current + 1} / ${items.length}` : '';

        // prev/next hanya muncul di tablet+ DAN lebih dari 1 gambar
        const showNav = items.length > 1 && !isMobile();
        btnPrev?.classList.toggle('hidden', !showNav);
        btnNext?.classList.toggle('hidden', !showNav);
    }

    function open(index) {
        show(index);
        overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function close() {
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
        setTimeout(() => { img.src = ''; }, 150);
    }

    function prev() { show(current - 1); }
    function next() { show(current + 1); }

    /* ── event: overlay klik tutup (kecuali tombol nav) ── */
    overlay.addEventListener('click', e => {
        if (e.target.closest('#lightbox-prev, #lightbox-next, #lightbox-close')) return;
        // klik di gambar → tidak tutup
        if (e.target === img) return;
        close();
    });

    document.getElementById('lightbox-close')?.addEventListener('click', close);
    btnPrev?.addEventListener('click', prev);
    btnNext?.addEventListener('click', next);

    /* ── keyboard ── */
    document.addEventListener('keydown', e => {
        if (overlay.classList.contains('hidden')) return;
        if (e.key === 'Escape')                    close();
        if (e.key === 'ArrowLeft' && !isMobile())  prev();
        if (e.key === 'ArrowRight' && !isMobile()) next();
    });

    /* ── touch swipe (mobile) ── */
    overlay.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].clientX;
        touchStartY = e.changedTouches[0].clientY;
    }, { passive: true });

    overlay.addEventListener('touchend', e => {
        const dx = touchStartX - e.changedTouches[0].clientX;
        const dy = touchStartY - e.changedTouches[0].clientY;
        // hanya proses swipe horizontal (bukan scroll vertikal)
        if (Math.abs(dx) > Math.abs(dy) && Math.abs(dx) > 40) {
            if (items.length > 1) dx > 0 ? next() : prev();
        }
    }, { passive: true });

    /* ── resize: update tombol nav ── */
    window.addEventListener('resize', () => {
        if (overlay.classList.contains('hidden')) return;
        const showNav = items.length > 1 && !isMobile();
        btnPrev?.classList.toggle('hidden', !showNav);
        btnNext?.classList.toggle('hidden', !showNav);
    });

    /* ── delegasi klik galeri ── */
    document.addEventListener('click', e => {
        const trigger = e.target.closest('[data-lightbox-src]');
        if (!trigger) return;

        const group = trigger.dataset.lightboxGroup;
        const all   = group
            ? Array.from(document.querySelectorAll(`[data-lightbox-group="${group}"]`))
            : [trigger];

        items   = all.map(el => ({
            src:     el.dataset.lightboxSrc,
            caption: el.dataset.lightboxCaption || '',
        }));
        current = all.indexOf(trigger);
        open(current);
    });
});
