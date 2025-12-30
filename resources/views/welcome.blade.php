<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Gestion Évaluations Académiques | Solution Complète') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        /* Styles personnalisés supplémentaires */
        html {
            scroll-behavior: smooth;
        }

        /* Micro-interactions */
        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.1);
        }

        .gradient-text {
            background: linear-gradient(to right, #2563eb, #9333ea);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Animation de fondu au chargement */
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

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }
    </style>
</head>

<body
    class="bg-background text-foreground antialiased selection:bg-primary selection:text-white flex flex-col min-h-screen relative overflow-x-hidden">

    <!-- Grille de fond décorative -->
    <div class="fixed inset-0 bg-grid-pattern pointer-events-none z-0"></div>
    <!-- Halo d'ambiance rouge -->
    <div
        class="fixed top-0 right-0 w-[600px] h-[600px] bg-primary/10 rounded-full blur-[120px] pointer-events-none z-0">
    </div>

    <!-- =======================
         NAVIGATION
         ======================= -->
    <header class="relative z-50 w-full max-w-7xl mx-auto px-6 lg:px-8 py-6 flex justify-between items-center">
        <!-- Logo -->
        <div class="flex items-center gap-2 font-bold text-xl tracking-tight">
            <div
                class="py-2 rounded-lg flex items-center justify-center text-primary-foreground shadow-lg shadow-primary/20">
                <a href="#" class="brand mr-2">
                    <img src="/android-chrome-192x192.png" alt="logo-app-cfpc" style="height:30px; margin-left:13px">
                </a>
            </div>
            <span>Gestion<span class="text-primary">Eval</span></span>
        </div>

        <!-- Desktop Nav -->
        <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-muted-foreground">
            <a href="#features" class="hover:text-primary transition-colors">Fonctionnalités</a>
            <a href="#methodology" class="hover:text-primary transition-colors">Méthodologie</a>
            <a href="#tech" class="hover:text-primary transition-colors">Technologie</a>
        </nav>

        <!-- Auth Buttons -->
        <div class="flex items-center gap-3">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium hover:text-primary transition-colors">Se
                        connecter</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="bg-primary hover:bg-primary/90 text-primary-foreground text-sm font-medium px-4 py-2 rounded-lg transition-colors shadow-sm shadow-primary/20">
                            S'enrengistrer
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </header>

    <main class="relative z-10 flex-grow">

        <!-- =======================
             HERO SECTION
             ======================= -->
        <section class="relative pt-16 pb-20 lg:pt-24 lg:pb-32 overflow-hidden">
            <div
                class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none">
            </div>
            <div
                class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 bg-primary/5 rounded-full blur-3xl pointer-events-none">
            </div>

            <div class="max-w-7xl mx-auto px-6 lg:px-8 grid lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="text-center lg:text-left z-10">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 text-primary text-xs font-semibold mb-6 fade-in-up">
                        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                        Version 1.2.0 Disponible
                    </div>
                    <h1 class="text-4xl lg:text-6xl font-bold tracking-tight mb-6 fade-in-up delay-100">
                        Gestion Evaluation <br>
                        <span class="text-primary">Intelligente & Automatisée</span>
                    </h1>
                    <p class="text-lg text-muted-foreground mb-8 max-w-2xl mx-auto lg:mx-0 fade-in-up delay-200">
                        Simplifiez la vie de votre établissement. Calcul automatique des moyennes (30/70), relevés de
                        notes PDF et suivi des compétences en un seul outil.
                    </p>


                    <!-- Trust Badges -->
                    <div
                        class="mt-10 pt-8 border-t border-border flex items-center justify-center lg:justify-start gap-6 text-sm text-muted-foreground fade-in-up delay-300">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Sécurisé (Laravel Breeze)
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd" />
                            </svg>
                            Mises à jour v1.2
                        </div>
                    </div>
                </div>

                <!-- Dashboard Preview Image -->
                <div class="relative lg:h-[600px] flex items-center justify-center fade-in-up delay-200">
                    <div
                        class="relative w-full max-w-lg aspect-[4/3] rounded-xl bg-card border border-border shadow-2xl overflow-hidden z-10">
                        <!-- Mockup Header -->
                        <div class="h-8 bg-secondary border-b border-border flex items-center px-4 gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-400"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                            <div class="w-3 h-3 rounded-full bg-green-400"></div>
                        </div>
                        <!-- Mockup Content -->
                        <div class="p-6 bg-background">
                            <div class="flex justify-between items-end mb-6">
                                <div>
                                    <div class="h-4 w-32 bg-muted rounded mb-2"></div>
                                    <div class="h-6 w-48 bg-muted-foreground/20 rounded"></div>
                                </div>
                                <div
                                    class="h-8 w-24 bg-primary rounded text-primary-foreground flex items-center justify-center text-xs font-bold">
                                    PDF
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="h-16 bg-card rounded border border-border p-3 flex justify-between">
                                    <div class="h-3 w-24 bg-muted rounded mt-1"></div>
                                    <div class="h-3 w-8 bg-primary/20 rounded mt-1"></div>
                                </div>
                                <div class="h-16 bg-card rounded border border-border p-3 flex justify-between">
                                    <div class="h-3 w-32 bg-muted rounded mt-1"></div>
                                    <div class="h-3 w-8 bg-primary/20 rounded mt-1"></div>
                                </div>
                                <div class="h-16 bg-card rounded border border-border p-3 flex justify-between">
                                    <div class="h-3 w-20 bg-muted rounded mt-1"></div>
                                    <div class="h-3 w-8 bg-primary/20 rounded mt-1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Decorative elements behind -->
                    <div
                        class="absolute top-10 -right-10 w-64 h-64 bg-primary/20 rounded-2xl rotate-6 -z-10 opacity-50">
                    </div>
                    <div
                        class="absolute -bottom-10 -left-10 w-64 h-64 bg-primary/10 rounded-2xl -rotate-6 -z-10 opacity-50">
                    </div>
                </div>
            </div>
        </section>

        <!-- =======================
             FEATURES GRID
             ======================= -->
        <section id="features" class="py-20 bg-card">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl font-bold mb-4 text-foreground">Tout ce qu'il faut pour gérer vos évaluations
                    </h2>
                    <p class="text-muted-foreground">Une suite complète d'outils pédagogiques pour les administrateurs,
                        les enseignants et les étudiants.</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1: Academic Management -->
                    <div
                        class="feature-card p-8 rounded-2xl border border-border bg-background hover:border-primary/30">
                        <div
                            class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-foreground">Gestion Structurelle</h3>
                        <p class="text-muted-foreground text-sm leading-relaxed">
                            Configuration aisée des années académiques, spécialités et modules. Support des coefficients
                            et semestres (S1/S2).
                        </p>
                    </div>

                    <!-- Feature 2: Smart Grading -->
                    <div
                        class="feature-card p-8 rounded-2xl border border-border bg-background hover:border-primary/30">
                        <div
                            class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-foreground">Saisie Intelligente</h3>
                        <p class="text-muted-foreground text-sm leading-relaxed">
                            Saisie simple ou multiple des notes par module ou spécialité. Calcul en temps réel des
                            moyennes semestrielles pondérées.
                        </p>
                    </div>

                    <!-- Feature 3: PDF Reports -->
                    <div
                        class="feature-card p-8 rounded-2xl border border-border bg-background hover:border-primary/30">
                        <div
                            class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-foreground">Relevés & Bilans PDF</h3>
                        <p class="text-muted-foreground text-sm leading-relaxed">
                            Génération automatique de relevés de notes officiels et de bilans de compétences
                            individualisés prêts à imprimer.
                        </p>
                    </div>

                    <!-- Feature 4: Competency Tracking -->
                    <div
                        class="feature-card p-8 rounded-2xl border border-border bg-background hover:border-primary/30">
                        <div
                            class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-foreground">Mode Compétences</h3>
                        <p class="text-muted-foreground text-sm leading-relaxed">
                            Approche moderne mixant évaluations chiffrées (30%) et compétences transversales (70%) pour
                            une note finale juste.
                        </p>
                    </div>

                    <!-- Feature 5: Analytics -->
                    <div
                        class="feature-card p-8 rounded-2xl border border-border bg-background hover:border-primary/30">
                        <div
                            class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-foreground">Statistiques & Dashboard</h3>
                        <p class="text-muted-foreground text-sm leading-relaxed">
                            Tableaux de bord visuels avec Chart.js pour analyser les performances par spécialité,
                            classement et réussite.
                        </p>
                    </div>

                    <!-- Feature 6: Roles -->
                    <div
                        class="feature-card p-8 rounded-2xl border border-border bg-background hover:border-primary/30">
                        <div
                            class="w-12 h-12 bg-muted text-muted-foreground rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-foreground">Gestion des Rôles</h3>
                        <p class="text-muted-foreground text-sm leading-relaxed">
                            Séparation stricte des droits : Admin (Structure), Manager (Saisie), Étudiant
                            (Consultation).
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- =======================
             METHODOLOGY / CALC
             ======================= -->
        <section id="methodology" class="py-20 bg-background">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="bg-card rounded-3xl border border-border shadow-xl overflow-hidden">
                    <div class="grid md:grid-cols-2">
                        <div class="p-10 lg:p-16 flex flex-col justify-center">
                            <h2 class="text-3xl font-bold mb-6 text-foreground">Calcul Automatique & Équitable</h2>
                            <p class="text-muted-foreground mb-8">
                                Notre système prend en charge la complexité du calcul des moyennes académiques selon la
                                formule standardisée de l'établissement (30% Évaluations / 70% Compétences).
                            </p>

                            <div class="space-y-6">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center flex-shrink-0 font-bold">
                                        1</div>
                                    <div>
                                        <h4 class="font-bold text-foreground">Moyennes Semestrielles</h4>
                                        <p class="text-sm text-muted-foreground">Calcul pondéré : Σ (Note × Coeff) / Σ
                                            Coeff</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center flex-shrink-0 font-bold">
                                        2</div>
                                    <div>
                                        <h4 class="font-bold text-foreground">Moyenne Annuelle</h4>
                                        <p class="text-sm text-muted-foreground">Moyenne des deux semestres (S1 + S2) /
                                            2</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center flex-shrink-0 font-bold">
                                        3</div>
                                    <div>
                                        <h4 class="font-bold text-foreground">Décision Finale</h4>
                                        <p class="text-sm text-muted-foreground">(Moyenne Annuelle × 30%) +
                                            (Compétences × 70%)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Visual Formula -->
                        <div
                            class="bg-secondary p-10 lg:p-16 flex items-center justify-center text-foreground relative">
                            <div class="absolute inset-0 opacity-10"
                                style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;">
                            </div>

                            <div class="w-full max-w-sm space-y-6 relative z-10">
                                <div class="flex items-center gap-4">
                                    <div class="text-right flex-1">
                                        <div class="text-xs uppercase tracking-wider text-muted-foreground">Évaluations
                                        </div>
                                        <div class="font-bold text-primary">30%</div>
                                    </div>
                                    <div
                                        class="h-4 w-full bg-background rounded-full overflow-hidden border border-border">
                                        <div class="h-full bg-primary w-[30%]"></div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="text-right flex-1">
                                        <div class="text-xs uppercase tracking-wider text-muted-foreground">Compétences
                                        </div>
                                        <div class="font-bold text-primary">70%</div>
                                    </div>
                                    <div
                                        class="h-4 w-full bg-background rounded-full overflow-hidden border border-border">
                                        <div class="h-full bg-primary w-[70%]"></div>
                                    </div>
                                </div>

                                <div class="border-t border-border pt-6 flex items-center justify-center gap-2">
                                    <span class="text-muted-foreground">=</span>
                                    <span class="text-xl font-bold text-primary">Moyenne Générale</span>
                                </div>

                                <div class="bg-background rounded-lg p-4 text-center border border-border">
                                    <div class="text-sm text-muted-foreground mb-1">Attribution Automatique</div>
                                    <div class="flex justify-between gap-2 text-xs font-mono text-foreground">
                                        <span class="text-primary">≥ 16 Très Bien</span>
                                        <span class="text-primary">≥ 14 Bien</span>
                                        <span class="text-primary">≥ 12 Assez Bien</span>
                                        <span class="text-yellow-500">≥ 10 Passable</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- =======================
             TECH STACK
             ======================= -->
        <section id="tech" class="py-16 border-t border-border">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
                <p class="text-sm font-semibold text-muted-foreground uppercase tracking-widest mb-8">Propulsé par des
                    technologies modernes</p>
                <div
                    class="flex flex-wrap justify-center items-center gap-8 lg:gap-16 opacity-70 grayscale hover:grayscale-0 transition-all duration-500">
                    <!-- Laravel -->
                    <div class="flex items-center gap-2 text-2xl font-bold text-foreground">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M23.642 5.43a.364.364 0 01-.014.1l-3.264 17.735a.5.5 0 01-.216.314.506.506 0 01-.367.064l-5.243-1.108-2.784 3.364a.523.523 0 01-.398.184.494.494 0 01-.273-.081.504.504 0 01-.232-.39l-.243-4.282-6.625-1.4a.5.5 0 01-.295-.194.504.504 0 01-.1-.352L8.16 2.924a.502.502 0 01.62-.544l14.52 2.96a.501.501 0 01.342.09z" />
                        </svg>
                        Laravel 12
                    </div>
                    <!-- MySQL -->
                    <div class="flex items-center gap-2 text-2xl font-bold text-primary">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.002 0c-1.586 0-3.063.233-4.39.625C5.744 1.312 4.3 2.5 3.455 4.07 2.586 5.672 2.12 7.603 2.12 9.73c0 2.15.475 4.093 1.35 5.693.854 1.57 2.295 2.75 4.14 3.414 1.322.39 2.796.615 4.38.615 1.58 0 3.053-.225 4.373-.615 1.847-.664 3.29-1.843 4.146-3.414.875-1.6 1.352-3.543 1.352-5.693 0-2.127-.466-4.058-1.336-5.66-.846-1.57-2.29-2.758-4.156-3.445C15.064.233 13.587 0 12.002 0zm-.517 2.055c.736.007 1.45.067 2.132.174 1.69.266 2.74.92 3.23 1.685.528.83.514 1.88.06 2.65-.463.793-1.39 1.278-2.507 1.278-.56 0-1.172-.12-1.816-.37-1.076-.416-2.032-.53-2.86-.343-.787.18-1.41.612-1.77 1.21-.35.58-.47 1.294-.335 2.045.14.776.56 1.584 1.23 2.34 1.33 1.495 3.722 2.613 6.938 2.613 1.07 0 2.088-.13 3.015-.36.915-.226 1.73-.575 2.41-1.04.15-.105.294-.22.428-.345.278.95.44 1.983.44 3.07 0 1.76-.38 3.36-1.07 4.62-.672 1.22-1.724 2.12-3.062 2.61-1.07.39-2.32.6-3.727.6-1.407 0-2.655-.21-3.724-.6-1.336-.49-2.388-1.39-3.06-2.61-.69-1.26-1.07-2.86-1.07-4.62 0-1.76.38-3.35 1.07-4.61.673-1.22 1.725-2.12 3.06-2.61 1.07-.39 2.318-.59 3.725-.59.19 0 .38 0 .565.01zm.325 4.6c.287 0 .568.05.834.15.65.24 1.14.65 1.46 1.17.325.52.47 1.14.42 1.74-.05.59-.29 1.16-.72 1.59-.424.43-.994.68-1.634.72-.644.05-1.28-.12-1.79-.47-.51-.35-.86-.86-.97-1.44-.11-.58.01-1.2.33-1.71.32-.52.84-.92 1.5-1.13.26-.08.54-.12.82-.12z" />
                        </svg>
                        MySQL
                    </div>
                    <!-- Tailwind -->
                    <div class="flex items-center gap-2 text-2xl font-bold text-cyan-400">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.001 4.8c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624C13.666 10.618 15.027 12 18.001 12c3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C16.337 6.182 14.976 4.8 12.001 4.8zm-6 7.2c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624 1.177 1.194 2.538 2.576 5.512 2.576 3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C10.337 13.382 8.976 12 6.001 12z" />
                        </svg>
                        Tailwind CSS
                    </div>
                    <!-- Chart.js (Generic icon representation) -->
                    <div class="flex items-center gap-2 text-2xl font-bold text-pink-500">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                        Chart.js
                    </div>
                </div>
            </div>
        </section>

        <!-- =======================
             CTA / FOOTER
             ======================= -->
        <section class="py-20 bg-primary text-primary-foreground">
            <div class="max-w-4xl mx-auto px-6 lg:px-8 text-center">
                <h2 class="text-3xl lg:text-4xl font-bold mb-6">Prêt à moderniser votre évaluation ?</h2>
                <p class="text-primary-foreground/90 mb-10 text-lg">
                    Rejoignez les établissements qui utilisent EvalAcad pour gagner du temps et améliorer la précision
                    de leurs résultats académiques.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#register"
                        class="px-8 py-4 bg-background text-primary font-bold rounded-lg hover:bg-muted transition-colors">
                        Créer un compte gratuitement
                    </a>
                    <a href="#demo"
                        class="px-8 py-4 border border-primary-foreground/30 text-primary-foreground font-bold rounded-lg hover:bg-primary-foreground/10 transition-colors">
                        Demander une démo
                    </a>
                </div>
            </div>
        </section>

    </main>

    <footer class="bg-background border-t border-border py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 grid md:grid-cols-4 gap-8 text-sm">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 font-bold text-lg mb-4">
                    <div class="flex items-center gap-2 font-bold text-xl tracking-tight">
            <div
                class="py-2 rounded-lg flex items-center justify-center text-primary-foreground shadow-lg shadow-primary/20">
                <a href="#" class="brand mr-2">
                    <img src="/android-chrome-192x192.png" alt="logo-app-cfpc" style="height:30px; margin-left:13px">
                </a>
            </div>
            <span>Gestion<span class="text-primary">Eval</span></span>
        </div>
                </div>
                <p class="text-muted-foreground mb-6 max-w-xs">
                    Solution de gestion académique développée avec passion pour l'éducation.
                </p>
                <p class="text-muted-foreground text-xs">
                    &copy; 2025 EvalAcad. Tous droits réservés.
                </p>
            </div>

            <div>
                <h4 class="font-bold text-foreground mb-4">Application</h4>
                <ul class="space-y-2 text-muted-foreground">
                    <li><a href="#features" class="hover:text-primary transition-colors">Fonctionnalités</a></li>
                    <li><a href="#methodology" class="hover:text-primary transition-colors">Calculs</a></li>
                    <li><a href="#tech" class="hover:text-primary transition-colors">Technique</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Mises à jour</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-foreground mb-4">Support</h4>
                <ul class="space-y-2 text-muted-foreground">
                    <li><a href="#" class="hover:text-primary transition-colors">Documentation</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Contact</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Confidentialité</a></li>
                    <li><span class="text-muted-foreground">Par WAFFO LELE Rostand</span></li>
                </ul>
            </div>
        </div>
    </footer>

    <!-- Script simple pour gérer l'état actif des liens au scroll -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Animation au défilement simple
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1
            });

            // Sélectionne tous les éléments à animer si besoin (optionnel car le CSS le gère déjà au chargement)
        });
    </script>
</body>

</html>
