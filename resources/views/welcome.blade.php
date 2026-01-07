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
.parent {
    position: relative;
    overflow: hidden;
    height: 144px; /* 3 * 48px (h-16 + space-y-3) */
}

.parent.smooth-scroll > div {
    position: absolute;
    width: 100%;
}

@keyframes smoothScrollUp {
    0% {
        transform: translateY(144px); /* Démarre du bas */
    }
    100% {
        transform: translateY(-48px); /* Monte vers le haut et disparaît */
    }
}
.enfant1 {
    animation: smoothScrollUp 12s linear infinite;
    animation-delay: 0s;
}

.enfant2 {
    animation: smoothScrollUp 12s linear infinite;
    animation-delay: 4s;
}

.enfant3 {
    animation: smoothScrollUp 12s linear infinite;
    animation-delay: 8s;
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
                        <a href="{{ route('login') }}"
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
                            <div class="space-y-3 parent smooth-scroll">
                                <div class="enfant1 h-16 bg-card rounded border border-border p-3 flex justify-between">
                                    <div class="h-3 w-24 bg-muted rounded mt-1"></div>
                                    <div class="h-3 w-8 bg-primary/20 rounded mt-1"></div>
                                </div>
                                <div class="enfant2 h-16 bg-card rounded border border-border p-3 flex justify-between">
                                    <div class="h-3 w-32 bg-muted rounded mt-1"></div>
                                    <div class="h-3 w-8 bg-primary/20 rounded mt-1"></div>
                                </div>
                                <div class="enfant3 h-16 bg-card rounded border border-border p-3 flex justify-between">
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
             SPECIALITIES SECTION
             ======================= -->
        <section class="py-20 bg-card">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl font-bold mb-4 text-foreground">Spécialités Agréées TIC en DQP</h2>
                    <p class="text-muted-foreground">Découvrez nos 9 spécialités professionnelles reconnues</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Secrétariat Bureautique -->
                    <div class="bg-background rounded-xl p-6 border border-border hover:border-primary/30 transition-all">
                        <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2 2v5a2 2 0 002 2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-foreground">Secrétariat Bureautique</h3>
                        <div class="text-sm text-muted-foreground mb-4">
                            <p class="mb-2"><strong>Durée:</strong> 12 mois</p>
                            <p class="mb-2"><strong>Accès:</strong> 3è / BEPC / CAP / GCE O Level</p>
                            <p>Formation aux outils bureautiques, gestion administrative et communication professionnelle.</p>
                        </div>
                        <div class="text-xs text-primary font-semibold">1090 heures</div>
                    </div>

                    <!-- Comptabilité Informatisée -->
                    <div class="bg-background rounded-xl p-6 border border-border hover:border-primary/30 transition-all">
                        <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M15 7h6m0 10v-3m-3 3h.01M15 17h.01M5 7h14"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-foreground">Comptabilité Informatisée</h3>
                        <div class="text-sm text-muted-foreground mb-4">
                            <p class="mb-2"><strong>Durée:</strong> 12 mois</p>
                            <p class="mb-2"><strong>Accès:</strong> Terminale / Upper Sixth</p>
                            <p>Utilisation de logiciels comptables, gestion financière et analyse.</p>
                        </div>
                        <div class="text-xs text-primary font-semibold">1220 heures</div>
                    </div>

                    <!-- Webmestre -->
                    <div class="bg-background rounded-xl p-6 border border-border hover:border-primary/30 transition-all">
                        <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9 9m0 9a9 9 0 019-9 9m-9-9a9 9 0 00-9 9"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-foreground">Webmestre</h3>
                        <div class="text-sm text-muted-foreground mb-4">
                            <p class="mb-2"><strong>Durée:</strong> 12 mois</p>
                            <p class="mb-2"><strong>Accès:</strong> BAC / GCE A Level</p>
                            <p>Création, maintenance et gestion de sites web et applications.</p>
                        </div>
                        <div class="text-xs text-primary font-semibold">1270 heures</div>
                    </div>

                    <!-- Secrétariat de Direction -->
                    <div class="bg-background rounded-xl p-6 border border-border hover:border-primary/30 transition-all">
                        <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 19 7.5 19S10.832 18.477 13 17.753V6.253z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-foreground">Secrétariat de Direction</h3>
                        <div class="text-sm text-muted-foreground mb-4">
                            <p class="mb-2"><strong>Durée:</strong> 12 mois</p>
                            <p class="mb-2"><strong>Accès:</strong> BAC / GCE A Level</p>
                            <p>Support aux cadres supérieurs, organisation et communication.</p>
                        </div>
                        <div class="text-xs text-primary font-semibold">1440 heures</div>
                    </div>

                    <!-- Secrétariat Comptable -->
                    <div class="bg-background rounded-xl p-6 border border-border hover:border-primary/30 transition-all">
                        <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M15 7h6m0 10v-3m-3 3h.01M15 17h.01M5 7h14"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-foreground">Secrétariat Comptable</h3>
                        <div class="text-sm text-muted-foreground mb-4">
                            <p class="mb-2"><strong>Durée:</strong> 12 mois</p>
                            <p class="mb-2"><strong>Accès:</strong> Première / Lower Sixth</p>
                            <p>Combinaison de secrétariat et comptabilité informatisée.</p>
                        </div>
                        <div class="text-xs text-primary font-semibold">1530 heures</div>
                    </div>

                    <!-- Maintenance Informatique -->
                    <div class="bg-background rounded-xl p-6 border border-border hover:border-primary/30 transition-all">
                        <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-foreground">Maintenance Informatique</h3>
                        <div class="text-sm text-muted-foreground mb-4">
                            <p class="mb-2"><strong>Durée:</strong> 12 mois</p>
                            <p class="mb-2"><strong>Accès:</strong> Première / Lower Sixth</p>
                            <p>Diagnostic et réparation des systèmes informatiques.</p>
                        </div>
                        <div class="text-xs text-primary font-semibold">920 heures</div>
                    </div>

                    <!-- Développement d'Application -->
                    <div class="bg-background rounded-xl p-6 border border-border hover:border-primary/30 transition-all">
                        <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4m6-4v1a3 3 0 00-3 3H7a3 3 0 00-3-3v-1a3 3 0 003 3h14a3 3 0 003-3v-1z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-foreground">Développement d'Application</h3>
                        <div class="text-sm text-muted-foreground mb-4">
                            <p class="mb-2"><strong>Durée:</strong> 12 mois</p>
                            <p class="mb-2"><strong>Accès:</strong> BAC / GCE A Level</p>
                            <p>Conception et développement d'applications web et mobiles.</p>
                        </div>
                        <div class="text-xs text-primary font-semibold">1170 heures</div>
                    </div>

                    <!-- Graphisme de Production -->
                    <div class="bg-background rounded-xl p-6 border border-border hover:border-primary/30 transition-all">
                        <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586 1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586 1.586a2 2 0 012.828 0L20 14"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-foreground">Graphisme de Production</h3>
                        <div class="text-sm text-muted-foreground mb-4">
                            <p class="mb-2"><strong>Durée:</strong> 12 mois</p>
                            <p class="mb-2"><strong>Accès:</strong> Terminale / Upper Sixth</p>
                            <p>Conception graphique, création de supports visuels et impression.</p>
                        </div>
                        <div class="text-xs text-primary font-semibold">990 heures</div>
                    </div>

                    <!-- Maintenance des Réseaux -->
                    <div class="bg-background rounded-xl p-6 border border-border hover:border-primary/30 transition-all">
                        <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H5m14 0h-2m2 6h2M3 9h6"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-foreground">Maintenance des Réseaux</h3>
                        <div class="text-sm text-muted-foreground mb-4">
                            <p class="mb-2"><strong>Durée:</strong> 12 mois</p>
                            <p class="mb-2"><strong>Accès:</strong> Terminale / Upper Sixth</p>
                            <p>Configuration, sécurité et maintenance des réseaux informatiques.</p>
                        </div>
                        <div class="text-xs text-primary font-semibold">1100 heures</div>
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
                        logo-
                        Laravel 12
                    </div>
                    <!-- MySQL -->
                    <div class="flex items-center gap-2 text-2xl font-bold text-primary">
                       logo-
                        MySQL
                    </div>
                    <!-- Tailwind -->
                    <div class="flex items-center gap-2 text-2xl font-bold text-cyan-400">
                        logo-
                        Tailwind CSS
                    </div>
                    <!-- Chart.js (Generic icon representation) -->
                    <div class="flex items-center gap-2 text-2xl font-bold text-pink-500">
                        logo-
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
            <!-- Logo et Description -->
            <div>
                <div class="flex items-center gap-2 font-bold text-lg mb-4">
                    <div class="flex items-center justify-center text-primary-foreground shadow-lg shadow-primary/20">
                        <a href="#" class="brand">
                            <img src="/android-chrome-192x192.png" alt="logo-app-cfpc" style="height:35px; margin-left:10px">
                        </a>
                    </div>
                    <span>Gestion<span class="text-primary">Eval</span></span>
                </div>
                <p class="text-muted-foreground mb-6">
                    Solution de gestion académique développée avec passion pour l'éducation.
                </p>
                <p class="text-muted-foreground text-xs">
                    &copy; 2025 EvalAcad. Tous droits réservés.
                </p>
            </div>

            <!-- Application -->
            <div>
                <h4 class="font-bold text-foreground mb-4">Application</h4>
                <ul class="space-y-2 text-muted-foreground">
                    <li><a href="#features" class="hover:text-primary transition-colors">Fonctionnalités</a></li>
                    <li><a href="#methodology" class="hover:text-primary transition-colors">Calculs</a></li>
                    <li><a href="#tech" class="hover:text-primary transition-colors">Technique</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-primary transition-colors">Connexion</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h4 class="font-bold text-foreground mb-4">Support</h4>
                <ul class="space-y-2 text-muted-foreground">
                    <li><a href="#" class="hover:text-primary transition-colors">Documentation</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Contact</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Aide</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">FAQ</a></li>
                </ul>
            </div>

            <!-- Légal -->
            <div>
                <h4 class="font-bold text-foreground mb-4">Légal</h4>
                <ul class="space-y-2 text-muted-foreground">
                    <li><a href="#" class="hover:text-primary transition-colors">Confidentialité</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Conditions d'utilisation</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Mentions légales</a></li>
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
