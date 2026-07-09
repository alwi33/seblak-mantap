// Simple vanilla JS carousel with autoplay, indicators, swipe, and prev/next
export default function initCarousel(containerSelector, interval = 4500) {
    const container = document.querySelector(containerSelector);
    if (!container) return;

    const track = container.querySelector('.carousel-track');
    const slides = Array.from(container.querySelectorAll('.carousel-slide'));
    const prevBtn = container.querySelector('.carousel-prev');
    const nextBtn = container.querySelector('.carousel-next');
    const indicators = container.querySelector('.carousel-indicators');

    let current = 0;
    let timer = null;

    function goTo(index) {
        index = (index + slides.length) % slides.length;
        slides.forEach((s, i) => {
            s.style.transform = `translateX(${(i - index) * 100}%)`;
            s.setAttribute('aria-hidden', i !== index);
        });
        current = index;
        updateIndicators();
    }

    function next() { goTo(current + 1); }
    function prev() { goTo(current - 1); }

    function start() {
        stop();
        timer = setInterval(next, interval);
    }

    function stop() { if (timer) { clearInterval(timer); timer = null; } }

    if (nextBtn) nextBtn.addEventListener('click', () => { next(); start(); });
    if (prevBtn) prevBtn.addEventListener('click', () => { prev(); start(); });

    // indicators
    function updateIndicators() {
        if (!indicators) return;
        Array.from(indicators.children).forEach((btn, i) => {
            btn.classList.toggle('opacity-100', i === current);
            btn.classList.toggle('opacity-40', i !== current);
        });
    }

    if (indicators) {
        slides.forEach((s, i) => {
            const btn = document.createElement('button');
            btn.className = 'w-3 h-3 rounded-full mx-1 bg-white/80 opacity-40 transition-opacity';
            btn.addEventListener('click', () => { goTo(i); start(); });
            indicators.appendChild(btn);
        });
    }

    // swipe support
    let startX = 0; let dx = 0; let isDown = false;
    track.addEventListener('touchstart', (e) => { isDown = true; startX = e.touches[0].clientX; stop(); });
    track.addEventListener('touchmove', (e) => { if (!isDown) return; dx = e.touches[0].clientX - startX; });
    track.addEventListener('touchend', () => { isDown = false; if (dx > 40) prev(); else if (dx < -40) next(); dx = 0; start(); });

    // parallax mouse move for images
    container.addEventListener('mousemove', (e) => {
        const width = container.offsetWidth; const x = e.clientX - container.getBoundingClientRect().left;
        const pct = (x / width) - 0.5;
        slides.forEach((s, i) => {
            const img = s.querySelector('img');
            if (img) img.style.transform = `translateX(${pct * 8}px) scale(1.02)`;
        });
    });

    // init positions
    slides.forEach((s, i) => { s.style.transform = `translateX(${i * 100}%)`; s.style.transition = 'transform .6s ease'; });
    goTo(0);
    start();
    return { goTo, next, prev, start, stop };
}
