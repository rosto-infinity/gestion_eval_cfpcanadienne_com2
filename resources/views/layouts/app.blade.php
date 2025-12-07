<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="darkModeManager()" :class="{ 'dark': darkMode }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- Inline script to detect system dark mode preference and apply it immediately --}}
    <script>
        (function() {
            const appearance = localStorage.getItem('appearance') ?? 'system';
            
            function applyDarkMode() {
                let isDark = false;
                
                if (appearance === 'system') {
                    isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                } else if (appearance === 'dark') {
                    isDark = true;
                }
                
                if (isDark) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
            
            applyDarkMode();
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', applyDarkMode);
        })();
    </script>

    <title>{{ config('app.name', 'CFPC--Gestion Évaluation') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Scripts -->
    @vite(['resources/css/app.css','resources/css/style.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white dark:bg-gray-900 transition-colors duration-200">
    
    @include('layouts.sidebar')
    
    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 -mt-7 flex justify-between items-center shadow-sm transition-colors duration-200">
            <span class="flex gap-2 pl-4">
                <i class='bx bx-dock-left cursor-pointer text-2xl text-red-500 dark:text-red-400'></i>
                <span class="text-gray-700 dark:text-gray-300">Barre Lattérale</span>
            </span>

            <div class="flex justify-around gap-5 items-center pr-4" x-data="darkModeManager()">
                <!-- Dark Mode Toggle Button -->
                <button @click="toggleDarkMode()"
                    class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"
                    title="Basculer le mode sombre">
                    <!-- Icône Soleil -->
                    <svg x-show="!darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.536l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.828-2.828l.707-.707a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414zm.707 5.657a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 1.414l-.707.707zm-7.071 0l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM9 17a1 1 0 011-1h1a1 1 0 110 2h-1a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    
                    <!-- Icône Lune -->
                    <svg x-show="darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                </button>

                <a href="#" class="notification relative text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                    <i class='bx bxs-bell text-xl'></i>
                    <span class="num absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">8</span>
                </a>

                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main class="bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
            @yield('content')
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script>
        // ✅ DÉFINIR LA FONCTION AVANT ALPINE
        function darkModeManager() {
            return {
                darkMode: localStorage.getItem('appearance') === 'dark' || 
                         (localStorage.getItem('appearance') !== 'light' && 
                          window.matchMedia('(prefers-color-scheme: dark)').matches),
                
                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('appearance', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('appearance', 'light');
                    }
                },
                
                init() {
                    // Synchroniser l'état initial
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                    }
                }
            };
        }

        // Sidebar Menu
        const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

        allSideMenu.forEach(item => {
            const li = item.parentElement;
            item.addEventListener('click', function() {
                allSideMenu.forEach(i => {
                    i.parentElement.classList.remove('active');
                })
                li.classList.add('active');
            })
        });

        // TOGGLE SIDEBAR
        const menuBar = document.querySelector('#content nav .bx.bx-dock-left');
        const sidebar = document.getElementById('sidebar');

        if (menuBar && sidebar) {
            menuBar.addEventListener('click', function() {
                sidebar.classList.toggle('hide');
            })
        }

        const searchButton = document.querySelector('#content nav form .form-input button');
        const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
        const searchForm = document.querySelector('#content nav form');

        if (searchButton && searchForm) {
            searchButton.addEventListener('click', function(e) {
                if (window.innerWidth < 576) {
                    e.preventDefault();
                    searchForm.classList.toggle('show');
                    if (searchForm.classList.contains('show')) {
                        searchButtonIcon.classList.replace('bx-search', 'bx-x');
                    } else {
                        searchButtonIcon.classList.replace('bx-x', 'bx-search');
                    }
                }
            })

            if (window.innerWidth < 768) {
                sidebar.classList.add('hide');
            } else if (window.innerWidth > 576) {
                if (searchButtonIcon) {
                    searchButtonIcon.classList.replace('bx-x', 'bx-search');
                }
                searchForm.classList.remove('show');
            }

            window.addEventListener('resize', function() {
                if (this.innerWidth > 576) {
                    if (searchButtonIcon) {
                        searchButtonIcon.classList.replace('bx-x', 'bx-search');
                    }
                    searchForm.classList.remove('show');
                }
            })
        }
    </script>
</body>

</html>
