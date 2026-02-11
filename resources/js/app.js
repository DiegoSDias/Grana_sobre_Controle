import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

window.toggleTheme = () => {
    const root = document.documentElement;
    root.classList.toggle('dark');
    localStorage.setItem('theme', root.classList.contains('dark') ? 'dark' : 'light');
  };
  (function initTheme() {
    const saved = localStorage.getItem('theme');
    if (saved === 'dark') document.documentElement.classList.add('dark');
  })();


Alpine.start();
