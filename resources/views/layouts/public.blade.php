<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Inline script to prevent dark mode flash --}}
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

    <title>@yield('title', config('app.name', 'CFPC--Gestion Évaluation'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
        }
        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.1);
        }
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    @stack('styles')
</head>

<body class="bg-background text-foreground antialiased selection:bg-primary selection:text-white flex flex-col min-h-screen relative overflow-x-hidden"
      x-data="{ darkMode: JSON.parse(localStorage.getItem('darkMode') || JSON.stringify(window.matchMedia('(prefers-color-scheme: dark)').matches)) }"
      x-init="$watch('darkMode', value => { localStorage.setItem('darkMode', JSON.stringify(value)); document.documentElement.classList.toggle('dark', value); }); $nextTick(() => document.documentElement.classList.remove('no-transition'))"
      :class="{ 'dark': darkMode }">

    <!-- Grille de fond décorative -->
    <div class="fixed inset-0 bg-grid-pattern pointer-events-none z-0 opacity-50"></div>
    <!-- Halo d'ambiance rouge -->
    <div class="fixed top-0 right-0 w-[600px] h-[600px] bg-primary/10 rounded-full blur-[120px] pointer-events-none z-0"></div>

    <!-- HEADER / NAVIGATION PUBLIC -->
    <header class="relative z-50 w-full max-w-7xl mx-auto px-6 lg:px-8 py-6 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('welcome') }}" class="flex items-center gap-2 font-bold text-xl tracking-tight hover:opacity-90 transition-opacity">
            <div class="flex items-center justify-center w-10 h-10 bg-white text-primary-foreground rounded-xl shadow-lg shadow-primary/20">
                <img src="/android-chrome-192x192.png" alt="logo-cfpc" class="w-7 h-7">
            </div>
            <span>Gestion<span class="text-primary">Eval</span></span>
        </a>

        <!-- Liens Desktop -->
        <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-muted-foreground">
            <!-- Theme Toggle -->
            <button @click="darkMode = !darkMode" type="button"
                    class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200"
                    aria-label="Toggle dark mode">
                <i class="bx bx-sun text-yellow-500 text-xl dark:hidden"></i>
                <i class="bx bx-moon text-blue-400 text-xl hidden dark:block"></i>
            </button>
            @if(request()->routeIs('welcome'))
                <a href="#features" class="hover:text-foreground transition-colors">Fonctionnalités</a>
                <a href="#methodology" class="hover:text-foreground transition-colors">Méthodologie</a>
                <a href="#tech" class="hover:text-foreground transition-colors">Technologie</a>
            @else
                <a href="{{ route('welcome') }}" class="hover:text-foreground transition-colors">Accueil</a>
            @endif
            <a href="{{ route('changelog') }}" class="hover:text-foreground transition-colors {{ request()->routeIs('changelog') ? 'text-primary' : '' }}">Changelog</a>
            
            @auth
                <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-primary text-primary-foreground rounded-lg hover:bg-primary/90 transition-all shadow-sm">
                    Tableau de Bord
                </a>
            @else
                <a href="{{ route('login') }}" class="px-5 py-2.5 bg-primary text-primary-foreground rounded-lg hover:bg-primary/90 transition-all shadow-sm">
                    Connexion
                </a>
            @endauth
        </nav>
    </header>

    <!-- MAIN CONTENT -->
    <main class="flex-grow relative z-10">
        @yield('content')
    </main>

    <!-- FOOTER GLOBAL -->
    @include('layouts.footer')

    @stack('scripts')
</body>
</html>
