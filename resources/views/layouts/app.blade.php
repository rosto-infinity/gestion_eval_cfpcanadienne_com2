<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Inline script and style to detect dark preference and apply immediately to prevent FOUC/White Flash --}}
    <script>
        (function() {
            const stored = localStorage.getItem('darkMode');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = stored !== null ? JSON.parse(stored) : prefersDark;

            if (isDark) {
                document.documentElement.classList.add('dark');
            }

            document.documentElement.classList.add('no-transition');
        })();
    </script>
    <style>
        /* Immediate canvas matching before main stylesheet parses */
        html.dark {
            color-scheme: dark;
            background-color: #0C0C1E;
        }
        html.no-transition * {
            transition: none !important;
        }
    </style>

    <title>{{ $title ?? config('app.name', 'CFPC--Gestion Évaluation') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    {{-- <link rel="stylesheet" href="/resources/css/style.css"> --}}
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('layouts.style')
</head>

<body class="font-sans antialiased" x-data="{ 
    mobileMenuOpen: false,
    toasts: []
}"
x-init="
    $watch('mobileMenuOpen', value => {
        if (value) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    });
    $nextTick(() => document.documentElement.classList.remove('no-transition'));
"
:class="{ 'dark': $store.theme.darkMode }">
    <!-- Mobile Menu Overlay -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition-opacity ease-in-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in-out duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/70 z-40 lg:hidden"
         @click="mobileMenuOpen = false">
    </div>

    <!-- Mobile Sidebar -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition-transform ease-in-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition-transform ease-in-out duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed inset-y-0 left-0 w-80 bg-white dark:bg-gray-800 shadow-xl z-50 lg:hidden overflow-y-auto">
        
        <!-- Mobile Sidebar Content -->
        <div class="flex flex-col h-full">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                <a href="#" class="brand flex items-center">
                    <img src="/android-chrome-192x192.png" alt="logo-app-cfpc" style="height:30px;">
                </a>
                <button @click="mobileMenuOpen = false" 
                        class="p-2 rounded-md text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Mobile Menu -->
            <nav class="flex-1 p-4">
                @include('layouts.sidebar_mobile')
            </nav>
        </div>
    </div>

    
    <!-- Desktop Sidebar -->
    <div class="hidden lg:block">
        @include('layouts.sidebar')
    </div>
    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav class="bg-red-300 -mt-7 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <!-- Mobile Menu Toggle -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="flex gap-2 lg:hidden p-2 rounded-md text-red-500 hover:text-red-700 hover:bg-red-100 hover:border-red-600 dark:hover:bg-red-900 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg> <span>Menu</span>
                </button>
                
                <!-- Desktop Sidebar Toggle -->
                <i class='bx bx-dock-left cursor-pointer text-2xl text-red-500 hidden lg:block'></i>
                <span class="hidden lg:block">Barre Lattérale</span>
            </div>

            <div class="flex justify-around gap-5 items-center">

                <x-theme-toggle />
                <!-- Dark Mode Toggler -->
                <a href="#" class="notification">
                    <i class='bx bxs-bell'></i>
                    <span class="num">8</span>
                </a>
                <a href="#" class="profile">
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
                </a>
            </div>
        </nav>
        <!-- NAVBAR -->

        <!-- Toast Flash Messages -->
        <div x-data="{ mounted: false }" x-init="mounted = true; $nextTick(() => {
            @if (session('success'))
                (() => { const id = Date.now(); toasts.push({ id, type: 'success', message: @js(session('success')) }); setTimeout(() => { toasts = toasts.filter(t => t.id !== id); }, 5000); })();
            @endif
            @if (session('error'))
                (() => { const id = Date.now() + 1; toasts.push({ id, type: 'error', message: @js(session('error')) }); setTimeout(() => { toasts = toasts.filter(t => t.id !== id); }, 5000); })();
            @endif
            @if (session('info'))
                (() => { const id = Date.now() + 2; toasts.push({ id, type: 'info', message: @js(session('info')) }); setTimeout(() => { toasts = toasts.filter(t => t.id !== id); }, 5000); })();
            @endif
        })" class="fixed top-4 right-4 z-[9999] flex flex-col gap-2 max-w-sm w-full pointer-events-none">
            <template x-for="(toast, index) in toasts" :key="toast.id">
                <div x-show="toasts.length > 0"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="translate-x-8 opacity-0"
                     x-transition:enter-end="translate-x-0 opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="translate-x-0 opacity-100"
                     x-transition:leave-end="translate-x-8 opacity-0"
                     class="pointer-events-auto w-full flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg border-l-4"
                     :class="{
                         'bg-green-50 border-green-400 text-green-800': toast.type === 'success',
                         'bg-red-50 border-red-400 text-red-800': toast.type === 'error',
                         'bg-blue-50 border-blue-400 text-blue-800': toast.type === 'info'
                     }">
                    <div class="flex-shrink-0">
                        <template x-if="toast.type === 'success'">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </template>
                        <template x-if="toast.type === 'error'">
                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </template>
                        <template x-if="toast.type === 'info'">
                            <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </template>
                    </div>
                    <p class="text-sm font-medium flex-1" x-text="toast.message"></p>
                    <button @click="toasts.splice(index, 1)" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </template>
        </div>

        <!-- MAIN -->
        <main class="bg-background">
            {{ $slot ?? '' }}
            @yield('content')
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script>
        document.addEventListener('turbo:load', () => {
            // Desktop sidebar toggle functionality
            const sidebar = document.querySelector('#sidebar');
            const sidebarToggle = document.querySelector('.bx-dock-left');
            const content = document.querySelector('#content');

            if (sidebarToggle && sidebar) {
                // Use clone or remove existing listener approach to avoid duplicates if necessary
                // But in SPA body replace, elements are new so standard addEventListener is perfect
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('hide');
                });
            }

            // Search functionality
            const searchForm = document.querySelector('#content nav form');
            const searchButton = document.querySelector('#content nav form button');
            const searchButtonIcon = document.querySelector('#content nav form button .bx');

            if (searchButton) {
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
                });
            }

            // Handle responsive behavior
            function handleResponsive() {
                const innerSidebar = document.querySelector('#sidebar');
                if (window.innerWidth < 768) {
                    // Mobile: hide desktop sidebar
                    if (innerSidebar) {
                        innerSidebar.classList.add('hide');
                    }
                } else {
                    // Desktop: show sidebar by default
                    if (innerSidebar) {
                        innerSidebar.classList.remove('hide');
                    }
                }
                
                const innerSearchForm = document.querySelector('#content nav form');
                const innerSearchButtonIcon = document.querySelector('#content nav form button .bx');
                if (window.innerWidth > 576) {
                    // Reset search form on larger screens
                    if (innerSearchForm && innerSearchButtonIcon) {
                        innerSearchForm.classList.remove('show');
                        innerSearchButtonIcon.classList.replace('bx-x', 'bx-search');
                    }
                }
            }

            // Initial check on load
            handleResponsive();
            
            // Ensure only a single listener on global window
            window.removeEventListener('resize', handleResponsive);
            window.addEventListener('resize', handleResponsive);
        });
    </script>
    @stack('scripts')
</body>

</html>
