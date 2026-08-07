(function () {
    // ── Ambil data yang diinjeksikan dari Blade ──────────────────────────────
    const ekskulData       = window.__homeCharts?.ekskul       ?? [];
    const beritaGaleriData = window.__homeCharts?.beritaGaleri ?? {};

    // ── Palette & config ─────────────────────────────────────────────────────
    const palette   = ['#1a3d6e', '#2a5298', '#e8a020', '#059669', '#7e22ce', '#dc2626'];
    const gridColor = 'rgba(0,0,0,0.06)';
    const tickColor = '#9ca3af';
    const baseOpts  = { responsive: true, maintainAspectRatio: false };

    // ── Chart 1: Doughnut peringkat ekskul ───────────────────────────────────
    function buildEkskulChart() {
        const canvas = document.getElementById('chartEkskulRanking');
        if (!canvas || canvas.__chartInit || !window.Chart) return;
        canvas.__chartInit = true;

        new Chart(canvas, {
            type: 'doughnut',
            data: {
                labels:   ekskulData.map(e => e.nama),
                datasets: [{
                    data:            ekskulData.map(e => e.skor),
                    backgroundColor: palette,
                    borderColor:     '#ffffff',
                    borderWidth:     2,
                }],
            },
            options: {
                ...baseOpts,
                cutout:    '50%',
                animation: { duration: 6000, easing: 'easeOutQuart' },
                plugins: {
                    legend: {
                        display:  true,
                        position: 'bottom',
                        labels:   { color: tickColor, boxWidth: 12, padding: 14, font: { size: 11 } },
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => ` ${ctx.label}: ${ctx.raw} poin`,
                        },
                    },
                },
            },
        });
    }

    // ── Chart 2: Bar berita & galeri ─────────────────────────────────────────
    function buildBeritaGaleriChart() {
        const canvas = document.getElementById('chartBeritaGaleri');
        if (!canvas || canvas.__chartInit || !window.Chart) return;
        canvas.__chartInit = true;

        const labels = Object.keys(beritaGaleriData);
        const values = Object.values(beritaGaleriData).map(Number);
        const maxY   = Math.max(...values, 0) + 1;

        new Chart(canvas, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    data:            values,
                    backgroundColor: palette,
                    borderRadius:    { topLeft: 4, topRight: 4, bottomLeft: 0, bottomRight: 0 },
                    borderSkipped:   false,
                }],
            },
            options: {
                ...baseOpts,
                animation: { duration: 8000, easing: 'easeOutQuart' },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => ` ${ctx.label}: ${ctx.raw}`,
                        },
                    },
                },
                scales: {
                    x: {
                        ticks: { color: tickColor, font: { size: 12 } },
                        grid:  { color: gridColor },
                    },
                    y: {
                        beginAtZero:  true,
                        suggestedMax: maxY,
                        ticks: { color: tickColor, font: { size: 12 }, stepSize: 1, precision: 0 },
                        grid:  { color: gridColor },
                    },
                },
            },
        });
    }

    // ── Lazy-load via IntersectionObserver ───────────────────────────────────
    function observeAndBuild(id, builder) {
        const el = document.getElementById(id);
        if (!el) return;
        new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    builder();
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 }).observe(el);
    }

    function init() {
        observeAndBuild('chartEkskulRanking', buildEkskulChart);
        observeAndBuild('chartBeritaGaleri',  buildBeritaGaleriChart);
    }

    document.readyState === 'loading'
        ? document.addEventListener('DOMContentLoaded', init)
        : init();
})();
