@extends('layouts.public')

@section('title', 'Journal des mises a jour')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- En-tete du journal -->
    <div class="mb-16">
        <div class="flex items-center gap-2 mb-3">
            <span class="w-2.5 h-2.5 bg-primary rounded-full"></span>
            <span class="text-xs font-bold tracking-widest uppercase text-primary">Changelog</span>
        </div>
        <h1 class="text-5xl font-black tracking-tight text-foreground mb-4 leading-tight">
            Journal des mises a jour
        </h1>
        <p class="text-xl text-muted-foreground font-medium max-w-2xl">
            Les dernieres nouveautes de la plateforme, version apres version.
        </p>
    </div>

    <!-- Ligne de temps (Timeline) -->
    <div class="relative border-l-2 border-dashed border-gray-900/30 dark:border-gray-300/40 ml-3 sm:ml-6 space-y-16">

        <!-- VERSION 1.4 : ACTUELLE -->
        <div class="relative pl-8 sm:pl-12 group">
            <span class="absolute -left-[6px] top-1 flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-primary shadow-sm"></span>
            </span>
            
            <div class="flex items-center gap-3 mb-3">
                <time class="text-sm font-semibold text-muted-foreground">
                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </time>
                <span class="px-2.5 py-0.5 text-xs font-bold bg-primary text-primary-foreground rounded-md">
                    v1.4.0
                </span>
                <span class="px-2.5 py-0.5 text-[10px] font-extrabold uppercase tracking-wider bg-accent text-accent-foreground rounded-full shadow-sm">
                    Actuel
                </span>
            </div>

            <h2 class="text-3xl font-black text-foreground mb-6 leading-snug tracking-tight">
                Architecture Actions & Resources -- Separation des couches
            </h2>

            <div class="text-foreground/90 max-w-none">
                <p class="text-lg leading-relaxed mb-6">
                    Refonte architecturale complete : extraction de la logique metier dans des Actions dediees,
                    standardisation des transformations via API Resources, et adoption des fonctionnalites Laravel 13.
                </p>

                <div class="grid gap-6 mt-8">

                    <!-- A. Couche metier : Actions -->
                    <div class="bg-card border border-border rounded-xl p-6 shadow-sm hover:shadow-md transition-all">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-card-foreground mb-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            Couche metier -- Extract Actions
                        </h3>
                        <ul class="space-y-2 list-disc list-inside text-sm leading-relaxed text-muted-foreground">
                            <li><code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">CloseAcademicYearAction</code> : verrouillage global de l'annee, cloture des bilans, Context + Log.</li>
                            <li><code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">SyncModuleSpecialtyAction</code> : validation des ponderations (coefficient max 10) avec transaction DB.</li>
                            <li><code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">GenerateSpecialtyReportAction</code> : agregation SQL laterale via <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">withAvg</code> + <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">toResourceCollection()</code>.</li>
                            <li><code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">ComputeMasteryMatrixAction</code> : paliers d'acquisition par <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">lazyById(100)</code> + transformation memoire.</li>
                        </ul>
                    </div>

                    <!-- B. API Resources -->
                    <div class="bg-card border border-border rounded-xl p-6 shadow-sm hover:shadow-md transition-all">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-card-foreground mb-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path></svg>
                            Couche de presentation -- API Resources
                        </h3>
                        <ul class="space-y-2 list-disc list-inside text-sm leading-relaxed text-muted-foreground">
                            <li>Creation de <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">AnneeAcademiqueResource</code>, <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">EvaluationResource</code>, <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">ModuleResource</code>, <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">SpecialiteResource</code>, <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">BilanResource</code>.</li>
                            <li>Enregistrement des ressources par defaut via <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">#[UseResource]</code> sur les modeles.</li>
                            <li>Utilisation de <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">$collection->toResourceCollection()</code> (Laravel 13) au lieu de <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">XResource::collection()</code>.</li>
                            <li>Resources ad-hoc sans modele : <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">MasteryMatrixResource</code> et <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">DashboardStatsResource</code>.</li>
                        </ul>
                    </div>

                    <!-- C. Conditions feneales & Agregateurs -->
                    <div class="bg-card border border-border rounded-xl p-6 shadow-sm hover:shadow-md transition-all">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-card-foreground mb-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Conditions feneales & Agregateurs automatiques
                        </h3>
                        <ul class="space-y-2 list-disc list-inside text-sm leading-relaxed text-muted-foreground">
                            <li><code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">whenLoaded('relation')</code> : chargement conditionnel des relations pour eviter le N+1 lors de la serialisation.</li>
                            <li><code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">whenPivotLoaded('module_specialite')</code> : coefficient visible uniquement lors du listing croise Module-Specialite.</li>
                            <li><code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">whenCounted('evaluations')</code> : compteurs injectes directement depuis SQL sans requete supplementaire.</li>
                            <li><code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">whenAggregated('evaluations', 'note', 'avg')</code> : moyennes calculees dynamiquement par SQL.</li>
                            <li><code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">whenNotNull($this->appreciation)</code> : appreciation masquee pour les evaluations non notees.</li>
                            <li><code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">#[PreserveKeys]</code> sur <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">SpecialiteResource</code> pour conserver les ID comme cles de map dans le frontend.</li>
                        </ul>
                    </div>

                    <!-- D. Dashboard -->
                    <div class="bg-card border border-border rounded-xl p-6 shadow-sm hover:shadow-md transition-all">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-card-foreground mb-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            Dashboard Invokable & Concurrency
                        </h3>
                        <ul class="space-y-2 list-disc list-inside text-sm leading-relaxed text-muted-foreground">
                            <li>Migration du <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">DashboardController</code> vers un controleur invokable (<code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">__invoke</code>).</li>
                            <li>Parallelisation des 8 requetes statistiques via <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">Concurrency::run()</code> pour le dashboard admin.</li>
                            <li>Parallelisation des requetes etudiant (evaluations, notes par semestre, notes par module) via <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">Concurrency::run()</code>.</li>
                        </ul>
                    </div>

                    <!-- E. Messages flash -->
                    <div class="bg-card border border-border rounded-xl p-6 shadow-sm hover:shadow-md transition-all">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-card-foreground mb-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            Notifications toast & Internationalisation
                        </h3>
                        <ul class="space-y-2 list-disc list-inside text-sm leading-relaxed text-muted-foreground">
                            <li>Messages flash migres en toasts flottants (haut droite) avec animation Alpine.js et auto-disparition a 5s.</li>
                            <li>Tous les messages de validation et flash entierement en francais.</li>
                            <li>Nettoyage des emojis dans les messages de validation.</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <!-- VERSION 1.3 -->
        <div class="relative pl-8 sm:pl-12">
            <span class="absolute -left-[6px] top-1 rounded-full h-3 w-3 bg-primary border border-border shadow-sm"></span>
            
            <div class="flex items-center gap-3 mb-3">
                <time class="text-sm font-semibold text-muted-foreground">
                    Mai 2026
                </time>
                <span class="px-2.5 py-0.5 text-xs font-bold bg-primary text-primary-foreground rounded-md">
                    v1.3.0
                </span>
            </div>

            <h2 class="text-2xl font-bold text-foreground mb-4 leading-tight tracking-tight">
                Architecture Laravel 13 & Optimisation Ultra Performance
            </h2>

            <div class="text-foreground/90 max-w-none">
                <p class="text-lg leading-relaxed mb-6">
                    Mise a niveau majeure exploitant Laravel 13 et PHP 8.4 pour des performances atomiques.
                </p>

                <div class="grid gap-6 mt-8">

                    <div class="bg-card border border-border rounded-xl p-6 shadow-sm hover:shadow-md transition-all">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-card-foreground mb-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Accelération Concurrency API
                        </h3>
                        <ul class="space-y-2 list-disc list-inside text-sm leading-relaxed text-muted-foreground">
                            <li>Integration de <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">Concurrency::run()</code> pour le chargement parallele des statistiques lourdes et menus.</li>
                            <li>Dechargement asynchrone des logs d'audit avec <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">defer()</code> liberant instantanement l'interface utilisateur.</li>
                        </ul>
                    </div>

                    <div class="bg-card border border-border rounded-xl p-6 shadow-sm hover:shadow-md transition-all">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-card-foreground mb-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path></svg>
                            Modernisation SQL Fluide
                        </h3>
                        <ul class="space-y-2 list-disc list-inside text-sm leading-relaxed text-muted-foreground">
                            <li>Elimination massive des boucles N+1 SQL via les jointures laterales correlees <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">leftJoinLateral()</code>.</li>
                            <li>Refactorisation des moteurs de recherche hybrides unifies avec <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">whereAny()</code> et recherches insensibles a la casse <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">whereLike()</code>.</li>
                        </ul>
                    </div>

                    <div class="bg-card border border-border rounded-xl p-6 shadow-sm hover:shadow-md transition-all">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-card-foreground mb-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Observabilité & Infrastructure
                        </h3>
                        <ul class="space-y-2 list-disc list-inside text-sm leading-relaxed text-muted-foreground">
                            <li>Montée en version du socle vers Laravel 13.8 et PHP 8.4.</li>
                            <li>Traçabilite des requetes de bout en bout via l'injection globale d'un <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">trace_id</code> Contextuel persistant.</li>
                            <li>Iterations paresseuses par segments <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">lazyById()</code> economisant 90% de memoire vive sur le traitement de masse.</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <!-- VERSION 1.2 -->
        <div class="relative pl-8 sm:pl-12">
            <span class="absolute -left-[6px] top-1 rounded-full h-3 w-3 bg-primary border border-border shadow-sm"></span>
            
            <div class="flex items-center gap-3 mb-3">
                <time class="text-sm font-semibold text-muted-foreground">
                    Avril 2026
                </time>
                <span class="px-2.5 py-0.5 text-xs font-bold bg-primary text-primary-foreground rounded-md">
                    v1.2.0
                </span>
            </div>

            <h2 class="text-2xl font-bold text-foreground mb-4 leading-tight tracking-tight">
                Stabilisation des Evaluations & Refonte des Modules
            </h2>

            <div class="text-foreground/90 max-w-none">
                <p class="text-lg leading-relaxed mb-6">
                    Mise en place des fondations robustes pour la capture des notes et la generation de documents officiels.
                </p>

                <div class="grid gap-6 mt-8">

                    <div class="bg-card border border-border rounded-xl p-6 shadow-sm hover:shadow-md transition-all">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-card-foreground mb-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            Saisie groupée par Specialite
                        </h3>
                        <ul class="space-y-2 list-disc list-inside text-sm leading-relaxed text-muted-foreground">
                            <li>Interface unifiee de saisie d'evaluation groupee par Specialite avec jointure laterale <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">leftJoinLateral()</code>.</li>
                            <li>Saisie multiple transactionnelle avec verification d'unicite et validation des coefficients.</li>
                        </ul>
                    </div>

                    <div class="bg-card border border-border rounded-xl p-6 shadow-sm hover:shadow-md transition-all">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-card-foreground mb-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Generation de documents PDF
                        </h3>
                        <ul class="space-y-2 list-disc list-inside text-sm leading-relaxed text-muted-foreground">
                            <li>Moteur de generation et export des releves de notes au format PDF securise via <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">PdfService</code>.</li>
                            <li>Export des bilans de competences individuels et des tableaux recapitulatifs.</li>
                        </ul>
                    </div>

                    <div class="bg-card border border-border rounded-xl p-6 shadow-sm hover:shadow-md transition-all">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-card-foreground mb-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Autorisation granulaire
                        </h3>
                        <ul class="space-y-2 list-disc list-inside text-sm leading-relaxed text-muted-foreground">
                            <li>Mise en conformite du systeme d'autorisation granulaire (Multi-roles) : superadmin, admin, manager, etudiant.</li>
                            <li>Middleware <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">role:admin,superadmin</code> applique via attributs PHP 8 <code class="text-xs bg-muted px-1 py-0.5 rounded text-foreground">#[Middleware]</code> sur les controleurs.</li>
                        </ul>
                    </div>

                    <div class="bg-card border border-border rounded-xl p-6 shadow-sm hover:shadow-md transition-all">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-card-foreground mb-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path></svg>
                            Bilans & Statistiques
                        </h3>
                        <ul class="space-y-2 list-disc list-inside text-sm leading-relaxed text-muted-foreground">
                            <li>Deploiement initial du tableau recapitulatif des bilans par classe avec stats globales.</li>
                            <li>Calcul automatique des moyennes semestrielles, de la moyenne de competences et de la moyenne generale ponderee (30% evals + 70% competences).</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection