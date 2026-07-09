document.addEventListener('DOMContentLoaded', () => {
    const nav = document.querySelector('.site-nav');
    if (nav) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) nav.classList.add('backdrop-blur-md','shadow-md');
            else nav.classList.remove('backdrop-blur-md','shadow-md');
        });
    }

    // mobile menu toggle
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const mobilePanel = document.getElementById('mobile-menu-panel');
    if (mobileBtn && mobilePanel) {
        mobileBtn.addEventListener('click', () => {
            const isOpen = !mobilePanel.classList.contains('hidden');
            mobilePanel.classList.toggle('hidden');
            mobileBtn.setAttribute('aria-expanded', String(!isOpen));
        });

        // close the panel after tapping a link, so it doesn't stay open
        mobilePanel.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                mobilePanel.classList.add('hidden');
                mobileBtn.setAttribute('aria-expanded', 'false');
            });
        });
    }

    // simple intersection observer animations (fade-up, fade-right, zoom-in)
    const io = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('opacity-100','translate-y-0','scale-100');
                io.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        el.classList.add('opacity-0','translate-y-6','scale-95','transition-all','duration-700');
        io.observe(el);
    });
});
//
