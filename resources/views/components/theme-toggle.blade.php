@props(['appearance' => 'system'])

<div x-data="{
    darkMode: false,
    init() {
        const stored = localStorage.getItem('darkMode');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        this.darkMode = stored !== null ? JSON.parse(stored) : prefersDark;

        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        }
    },
    toggleTheme() {
        this.darkMode = !this.darkMode;
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        localStorage.setItem('darkMode', JSON.stringify(this.darkMode));
    }
}" class="relative">
    <button @click="toggleTheme" type="button" 
            class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200"
            aria-label="Toggle dark mode">
        <i class="bx bx-sun text-yellow-500 text-xl dark:hidden"></i>
        <i class="bx bx-moon text-blue-400 text-xl hidden dark:block"></i>
    </button>
</div>