import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// ── LIGHTBOX ──────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const overlay  = document.getElementById('lightbox');
    if (!overlay) return;

    const img      = document.getElementById('lightbox-img');
    const caption  = document.getElementById('lightbox-caption');
    const btnPrev  = document.getElementById('lightbox-prev');
    const btnNext  = document.getElementById('lightbox-next');
    const counter  = document.getElementById('lightbox-counter');

    let items   = [];   // array of { src, caption }
    let current = 0;
    let touchStartX = 0;

    function show(index) {
        current      = (index + items.length) % items.length;
        img.src      = items[current].src;
        if (caption) caption.textContent = items[current].caption || '';
        if (counter) counter.textContent = `${current + 1} / ${items.length}`;
        // Tampilkan/sembunyikan tombol nav
        const show = items.length > 1;
        btnPrev?.classList.toggle('hidden', !show);
        btnNext?.classList.toggle('hidden', !show);
    }

    function open(index) {
        show(index);
        overlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function close() {
        overlay.classList.remove('is-open');
        document.body.style.overflow = '';
        setTimeout(() => { img.src = ''; }, 250);
    }

    function prev() { show(current - 1); }
    function next() { show(current + 1); }

    // Klik overlay (bukan kontrol) → tutup
    overlay.addEventListener('click', e => {
        if (e.target === overlay) close();
    });

    // Tombol close
    document.getElementById('lightbox-close')?.addEventListener('click', close);

    // Tombol navigasi
    btnPrev?.addEventListener('click', prev);
    btnNext?.addEventListener('click', next);

    // Keyboard
    document.addEventListener('keydown', e => {
        if (!overlay.classList.contains('is-open')) return;
        if (e.key === 'Escape')     close();
        if (e.key === 'ArrowLeft')  prev();
        if (e.key === 'ArrowRight') next();
    });

    // Touch swipe
    overlay.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].clientX;
    }, { passive: true });

    overlay.addEventListener('touchend', e => {
        const diff = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) {
            diff > 0 ? next() : prev();
        }
    }, { passive: true });

    // Delegasi klik pada elemen dengan data-lightbox-src
    // Kumpulkan semua item dalam container yang sama (data-lightbox-group)
    document.addEventListener('click', e => {
        const trigger = e.target.closest('[data-lightbox-src]');
        if (!trigger) return;

        // Kumpulkan semua trigger di grup yang sama (atau semua jika tidak ada grup)
        const group = trigger.dataset.lightboxGroup;
        const all   = group
            ? document.querySelectorAll(`[data-lightbox-group="${group}"]`)
            : [trigger];

        items   = Array.from(all).map(el => ({
            src:     el.dataset.lightboxSrc,
            caption: el.dataset.lightboxCaption || '',
        }));
        current = Array.from(all).indexOf(trigger);

        open(current);
    });
});
