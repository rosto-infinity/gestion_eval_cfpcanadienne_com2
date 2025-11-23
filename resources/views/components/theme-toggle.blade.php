@props(['appearance' => 'system'])

<div x-data="{
    darkMode: false,
    init() {
        // Récupérer le thème sauvegardé ou utiliser les préférences système
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            this.darkMode = true;
            document.documentElement.classList.add('dark');
        }
    },
    toggleTheme() {
        this.darkMode = !this.darkMode;
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    }
}" class="relative">
    <button @click="toggleTheme" type="button" 
            class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200"
            aria-label="Toggle dark mode">
        <i class="bx bx-sun text-yellow-500 text-xl dark:hidden"></i>
        <i class="bx bx-moon text-blue-400 text-xl hidden dark:block"></i>
    </button>
</div>