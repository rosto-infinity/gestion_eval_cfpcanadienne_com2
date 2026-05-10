@extends('layouts.public')

@section('title', 'Journal des mises à jour')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- En-tête du journal -->
    <div class="mb-16">
        <div class="flex items-center gap-2 mb-3">
            <span class="w-2.5 h-2.5 bg-primary rounded-full"></span>
            <span class="text-xs font-bold tracking-widest uppercase text-primary">Changelog</span>
        </div>
        <h1 class="text-5xl font-black tracking-tight text-foreground mb-4 leading-tight">
            Journal des mises à jour
        </h1>
        <p class="text-xl text-muted-foreground font-medium max-w-2xl">
            Les dernières nouveautés de la plateforme, version après version.
        </p>
    </div>

    <!-- Ligne de temps (Timeline) -->
    <div class="relative border-l border-border ml-3 sm:ml-6 space-y-16">

        <!-- VERSION 1.3 : AUJOURD'HUI -->
        <div class="relative pl-8 sm:pl-12 group">
            <!-- Puce point -->
            <span class="absolute -left-[6px] top-1 flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-primary shadow-sm"></span>
            </span>
            
            <!-- Date et Badge -->
            <div class="flex items-center gap-3 mb-3">
                <time class="text-sm font-semibold text-muted-foreground">
                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </time>
                <span class="px-2.5 py-0.5 text-xs font-bold border border-primary/20 bg-primary/10 text-primary rounded-md">
                    v1.3.0
                </span>
                <span class="px-2.5 py-0.5 text-[10px] font-extrabold uppercase tracking-wider bg-accent text-accent-foreground rounded-full shadow-sm">
                    Actuel
                </span>
            </div>

            <!-- Titre version -->
            <h2 class="text-3xl font-black text-foreground mb-6 leading-snug tracking-tight">
                Architecture Laravel 13 & Optimisation Ultra Performance
            </h2>

            <!-- Contenu descriptive -->
            <div class="text-foreground/90 max-w-none">
                <p class="text-lg leading-relaxed mb-6">
                    Cette mise à niveau majeure fait basculer le cœur de l'application vers une architecture de niveau Expert, exploitant les technologies de pointe pour des performances atomiques.
                </p>

                <div class="grid gap-6 mt-8">
                    <!-- Feature item -->
                    <div class="bg-card border border-border rounded-xl p-6 shadow-sm hover:shadow-md transition-all">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-card-foreground mb-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Accélération Concurrency API
                        </h3>
                        <ul class="space-y-2 list-disc list-inside text-sm leading-relaxed text-muted-foreground">
                            <li>Intégration de <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">Concurrency::run()</code> pour charger les statistiques lourdes et menus en parallèle.</li>
                            <li>Déchargement asynchrone des logs d'audit avec <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">defer()</code> libérant instantanément l'interface utilisateur.</li>
                        </ul>
                    </div>

                    <!-- Feature item -->
                    <div class="bg-card border border-border rounded-xl p-6 shadow-sm hover:shadow-md transition-all">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-card-foreground mb-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path></svg>
                            Modernisation SQL Fluide
                        </h3>
                        <ul class="space-y-2 list-disc list-inside text-sm leading-relaxed text-muted-foreground">
                            <li>Élimination massive des boucles N+1 SQL via les jointures latérales corrélées <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">leftJoinLateral()</code>.</li>
                            <li>Refactorisation des moteurs de recherche hybrides unifiés avec le nouveau paradigme <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">whereAny()</code> et recherches insensibles à la casse <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">whereLike()</code>.</li>
                        </ul>
                    </div>

                    <!-- Feature item -->
                    <div class="bg-card border border-border rounded-xl p-6 shadow-sm hover:shadow-md transition-all">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-card-foreground mb-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Observabilité & Infrastructure
                        </h3>
                        <ul class="space-y-2 list-disc list-inside text-sm leading-relaxed text-muted-foreground">
                            <li>Montée en version du socle vers **Laravel 13.8** et **PHP 8.4**.</li>
                            <li>Traçabilité des requêtes de bout en bout via l'injection globale d'un <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">trace_id</code> Contextuel persistant.</li>
                            <li>Itérations paresseuses par segments <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">lazyById()</code> économisant 90% de mémoire vive sur le traitement de masse.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- VERSION 1.2 : ANCIENNE -->
        <div class="relative pl-8 sm:pl-12">
            <!-- Puce point -->
            <span class="absolute -left-[6px] top-1 rounded-full h-3 w-3 bg-muted border border-border shadow-sm"></span>
            
            <!-- Date et Badge -->
            <div class="flex items-center gap-3 mb-3">
                <time class="text-sm font-semibold text-muted-foreground">
                    Avril 2026
                </time>
                <span class="px-2.5 py-0.5 text-xs font-bold border border-border bg-muted text-muted-foreground rounded-md">
                    v1.2.0
                </span>
            </div>

            <!-- Titre version -->
            <h2 class="text-2xl font-bold text-foreground mb-4 leading-tight tracking-tight">
                Stabilisation des Évaluations & Refonte des Modules
            </h2>

            <!-- Contenu descriptive -->
            <div class="text-muted-foreground text-base leading-relaxed">
                <p class="mb-4">
                    Mise en place des fondations robustes pour la capture des notes et la génération de documents officiels.
                </p>
                <ul class="space-y-1.5 list-disc list-inside text-sm">
                    <li>Interface unifiée de saisie d'évaluation groupée par Spécialité.</li>
                    <li>Moteur de génération et export des relevés de notes au format PDF sécurisé.</li>
                    <li>Mise en conformité du système d'autorisation granulaire (Multi-rôles).</li>
                    <li>Déploiement initial du tableau récapitulatif des bilans par classe.</li>
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection
