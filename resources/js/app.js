import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';

Livewire.start();

if (! window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in', 'is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.15 },
    );

    document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));
} else {
    document.querySelectorAll('.reveal').forEach((el) => {
        el.classList.add('in', 'is-visible');
    });
}
