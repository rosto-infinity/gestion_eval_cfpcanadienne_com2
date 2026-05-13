import './bootstrap';

import Alpine from 'alpinejs';
import * as Turbo from "@hotwired/turbo";

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.store('theme', {
        darkMode: JSON.parse(localStorage.getItem('darkMode') || 'false'),
        
        async toggle(event) {
            const isDark = !this.darkMode;
            if (!document.startViewTransition) {
                this.darkMode = isDark;
                document.documentElement.classList.toggle('dark', isDark);
                localStorage.setItem('darkMode', JSON.stringify(isDark));
                return;
            }
            const x = event.clientX ?? window.innerWidth / 2;
            const y = event.clientY ?? window.innerHeight / 2;
            const endRadius = Math.hypot(Math.max(x, window.innerWidth - x), Math.max(y, window.innerHeight - y));
            
            const transition = document.startViewTransition(() => {
                this.darkMode = isDark;
                document.documentElement.classList.toggle('dark', isDark);
                localStorage.setItem('darkMode', JSON.stringify(isDark));
            });
            
            await transition.ready;
            document.documentElement.animate(
                { clipPath: [`circle(0px at ${x}px ${y}px)`, `circle(${endRadius}px at ${x}px ${y}px)`] },
                { duration: 500, easing: 'ease-out', pseudoElement: '::view-transition-new(root)' }
            );
        }
    });
});

Alpine.start();
Turbo.start();
