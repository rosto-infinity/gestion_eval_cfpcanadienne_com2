@extends('layouts.app')

@section('title', 'Détails de l\'Évaluation')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Breadcrumb -->
    <div class="mb-8">
        <a href="{{ route('evaluations.index') }}" 
           class="inline-flex items-center gap-2 text-primary hover:text-primary/80 font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Retour aux évaluations
        </a>
    </div>

    <!-- En-tête avec Actions -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">📊 Détails de l'Évaluation</h1>
            <p class="mt-2 text-sm text-muted-foreground">
                Consultation complète de l'évaluation
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('evaluations.edit', $evaluation) }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-accent hover:bg-accent/90 text-accent-foreground rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Modifier
            </a>
             @if(auth()->user()->role->isAtLeast(\App\Enums\Role::ADMIN))
            <form action="{{ route('evaluations.destroy', $evaluation) }}" method="POST" class="inline" 
                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ?');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-destructive hover:bg-destructive/90 text-destructive-foreground rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Supprimer
                </button>
            </form>
            @endif

        </div>
    </div>

    <!-- Cartes Principales (3 colonnes) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <!-- Carte Note -->
        <div class="bg-gradient-to-br from-primary/10 to-primary/5 border border-primary/20 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-primary uppercase tracking-wide">Note Obtenue</h3>
                <svg class="w-6 h-6 text-primary/40" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
            <div class="text-4xl font-bold {{ $evaluation->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                {{ number_format($evaluation->note, 2) }}
            </div>
            <p class="text-xs text-muted-foreground mt-2">/20</p>
            <div class="mt-4 pt-4 border-t border-primary/10">
                <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Statut</p>
                @if($evaluation->note >= 10)
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                        <span class="w-2 h-2 rounded-full bg-green-600"></span>
                        Validée
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                        <span class="w-2 h-2 rounded-full bg-red-600"></span>
                        Non Validée
                    </span>
                @endif
            </div>
        </div>

        <!-- Carte Appréciation -->
        <div class="bg-gradient-to-br from-accent/10 to-accent/5 border border-accent/20 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-accent uppercase tracking-wide">Appréciation</h3>
                <svg class="w-6 h-6 text-accent/40" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18.868 3.884c.419-.419.419-1.098 0-1.517a1.075 1.075 0 00-1.52 0l-5.528 5.528-2.36-2.36a1.075 1.075 0 00-1.52 1.52l3.4 3.4a1.075 1.075 0 001.52 0l6.428-6.428z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="text-3xl font-bold text-foreground mb-4">
                {{ $evaluation->getAppreciation() }}
            </div>
            <div class="space-y-2">
                <div class="flex items-center justify-between text-xs p-2 rounded bg-muted/30">
                    <span class="text-muted-foreground">Très Bien</span>
                    <span class="font-semibold text-foreground">≥ 16</span>
                </div>
                <div class="flex items-center justify-between text-xs p-2 rounded bg-muted/30">
                    <span class="text-muted-foreground">Bien</span>
                    <span class="font-semibold text-foreground">14-15</span>
                </div>
                <div class="flex items-center justify-between text-xs p-2 rounded bg-muted/30">
                    <span class="text-muted-foreground">Assez Bien</span>
                    <span class="font-semibold text-foreground">12-13</span>
                </div>
                <div class="flex items-center justify-between text-xs p-2 rounded bg-muted/30">
                    <span class="text-muted-foreground">Passable</span>
                    <span class="font-semibold text-foreground">10-11</span>
                </div>
                <div class="flex items-center justify-between text-xs p-2 rounded bg-muted/30">
                    <span class="text-muted-foreground">Insuffisant</span>
                    <span class="font-semibold text-foreground">&lt; 10</span>
                </div>
            </div>
        </div>

        <!-- Carte Informations -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-50/50 dark:from-blue-950/20 dark:to-blue-900/10 border border-blue-200 dark:border-blue-800 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-blue-900 dark:text-blue-100 uppercase tracking-wide">Informations</h3>
                <svg class="w-6 h-6 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="space-y-3">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1">Semestre</p>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold {{ $evaluation->semestre == 1 ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                        <span class="w-2 h-2 rounded-full {{ $evaluation->semestre == 1 ? 'bg-green-600' : 'bg-blue-600' }}"></span>
                        S{{ $evaluation->semestre }}
                    </span>
                </div>
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1">Année Académique</p>
                    <p class="text-sm font-semibold text-foreground">{{ $evaluation->anneeAcademique->libelle }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1">ID</p>
                    <p class="text-sm font-mono text-muted-foreground">{{ $evaluation->id }}</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Layout 2 colonnes -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <!-- Colonne 1 : Informations (2/3) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Informations Étudiant -->
            <div class="bg-card border border-border rounded-xl p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                    </svg>
                    <h2 class="text-lg font-bold text-foreground uppercase tracking-wide">Étudiant</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 bg-muted/30 rounded-lg border border-border/50">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Nom Complet</p>
                        <p class="text-sm font-semibold text-foreground">{{ $evaluation->user->getFullName() }}</p>
                    </div>
                    <div class="p-4 bg-muted/30 rounded-lg border border-border/50">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Matricule</p>
                        <p class="text-sm font-mono font-semibold text-foreground">{{ $evaluation->user->matricule }}</p>
                    </div>
                    <div class="p-4 bg-muted/30 rounded-lg border border-border/50">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Email</p>
                        <p class="text-sm text-primary truncate">{{ $evaluation->user->email }}</p>
                    </div>
                    <div class="p-4 bg-muted/30 rounded-lg border border-border/50">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Spécialité</p>
                        <p class="text-sm font-semibold text-foreground">
                            {{ $evaluation->user->specialite?->intitule ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Informations Module -->
            <div class="bg-card border border-border rounded-xl p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-accent" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.669 0-3.218.51-4.5 1.385A7.968 7.968 0 009 4.804z"/>
                    </svg>
                    <h2 class="text-lg font-bold text-foreground uppercase tracking-wide">Module</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 bg-muted/30 rounded-lg border border-border/50">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Code</p>
                        <p class="text-sm font-mono font-semibold text-foreground">{{ $evaluation->module->code }}</p>
                    </div>
                    <div class="p-4 bg-muted/30 rounded-lg border border-border/50">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Intitulé</p>
                        <p class="text-sm font-semibold text-foreground">{{ $evaluation->module->intitule }}</p>
                    </div>
                    <div class="p-4 bg-muted/30 rounded-lg border border-border/50">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Crédits</p>
                        <p class="text-sm font-semibold text-foreground">{{ $evaluation->module->credit ?? '-' }}</p>
                    </div>
                    <div class="p-4 bg-muted/30 rounded-lg border border-border/50">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Coefficient</p>
                        <p class="text-sm font-semibold text-foreground">{{ $evaluation->module->coefficient ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Analyse de la Note -->
            <div class="bg-card border border-border rounded-xl p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                    </svg>
                    <h2 class="text-lg font-bold text-foreground uppercase tracking-wide">Analyse</h2>
                </div>

                <!-- Barre de progression -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-foreground">Progression</span>
                        <span class="text-sm font-bold {{ $evaluation->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format(($evaluation->note / 20) * 100, 1) }}%
                        </span>
                    </div>
                    <div class="w-full bg-muted rounded-full h-3 overflow-hidden">
                        <div class="h-full {{ $evaluation->note >= 10 ? 'bg-green-500' : 'bg-red-500' }} rounded-full transition-all duration-500" 
                             style="width: {{ ($evaluation->note / 20) * 100 }}%"></div>
                    </div>
                </div>

                <!-- Seuils -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="p-3 bg-red-50 dark:bg-red-950/20 rounded-lg border border-red-200 dark:border-red-800">
                        <p class="text-xs font-bold text-red-900 dark:text-red-100 uppercase tracking-wide mb-1">Insuffisant</p>
                        <p class="text-lg font-bold text-red-600">&lt; 10</p>
                        @if($evaluation->note < 10)
                            <p class="text-xs text-red-600 mt-1">✓ Votre note</p>
                        @else
                            <p class="text-xs text-red-500 mt-1">+{{ number_format($evaluation->note - 10, 2) }}</p>
                        @endif
                    </div>
                    <div class="p-3 bg-orange-50 dark:bg-orange-950/20 rounded-lg border border-orange-200 dark:border-orange-800">
                        <p class="text-xs font-bold text-orange-900 dark:text-orange-100 uppercase tracking-wide mb-1">Passable</p>
                        <p class="text-lg font-bold text-orange-600">10-11</p>
                        @if($evaluation->note >= 10 && $evaluation->note < 12)
                            <p class="text-xs text-orange-600 mt-1">✓ Votre note</p>
                        @elseif($evaluation->note < 10)
                            <p class="text-xs text-orange-500 mt-1">+{{ number_format(10 - $evaluation->note, 2) }}</p>
                        @else
                            <p class="text-xs text-orange-500 mt-1">+{{ number_format($evaluation->note - 11, 2) }}</p>
                        @endif
                    </div>
                    <div class="p-3 bg-yellow-50 dark:bg-yellow-950/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                        <p class="text-xs font-bold text-yellow-900 dark:text-yellow-100 uppercase tracking-wide mb-1">Assez Bien</p>
                        <p class="text-lg font-bold text-yellow-600">12-13</p>
                        @if($evaluation->note >= 12 && $evaluation->note < 14)
                            <p class="text-xs text-yellow-600 mt-1">✓ Votre note</p>
                        @elseif($evaluation->note < 12)
                            <p class="text-xs text-yellow-500 mt-1">+{{ number_format(12 - $evaluation->note, 2) }}</p>
                        @else
                            <p class="text-xs text-yellow-500 mt-1">+{{ number_format($evaluation->note - 13, 2) }}</p>
                        @endif
                    </div>
                    <div class="p-3 bg-green-50 dark:bg-green-950/20 rounded-lg border border-green-200 dark:border-green-800">
                        <p class="text-xs font-bold text-green-900 dark:text-green-100 uppercase tracking-wide mb-1">Excellent</p>
                        <p class="text-lg font-bold text-green-600">≥ 14</p>
                        @if($evaluation->note >= 14)
                            <p class="text-xs text-green-600 mt-1">✓ Votre note</p>
                        @else
                            <p class="text-xs text-green-500 mt-1">+{{ number_format(14 - $evaluation->note, 2) }}</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- Colonne 2 : Panneaux Informatifs (1/3) -->
        <div class="lg:col-span-1 space-y-6">

            <!-- Historique -->
            <div class="bg-card border border-border rounded-xl p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-muted-foreground" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h12a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    <h3 class="text-sm font-bold text-foreground uppercase tracking-wide">Historique</h3>
                </div>
                <div class="space-y-3">
                    <div class="p-3 bg-muted/30 rounded-lg border border-border/50">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1">Créée</p>
                        <p class="text-sm font-semibold text-foreground">{{ $evaluation->created_at->format('d/m/Y') }}</p>
                        <p class="text-xs text-muted-foreground">{{ $evaluation->created_at->format('H:i:s') }}</p>
                    </div>
                    <div class="p-3 bg-muted/30 rounded-lg border border-border/50">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1">Modifiée</p>
                        <p class="text-sm font-semibold text-foreground">{{ $evaluation->updated_at->format('d/m/Y') }}</p>
                        <p class="text-xs text-muted-foreground">{{ $evaluation->updated_at->format('H:i:s') }}</p>
                    </div>
                </div>
            </div>

            <!-- Résumé Rapide -->
            <div class="bg-gradient-to-br from-primary/10 to-primary/5 border border-primary/20 rounded-xl p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <h3 class="text-sm font-bold text-primary uppercase tracking-wide">Résumé</h3>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center justify-between p-2 rounded bg-white dark:bg-background/50">
                        <span class="text-muted-foreground">Étudiant</span>
                        <span class="font-semibold text-foreground truncate">{{ $evaluation->user->matricule }}</span>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded bg-white dark:bg-background/50">
                        <span class="text-muted-foreground">Module</span>
                        <span class="font-semibold text-foreground truncate">{{ $evaluation->module->code }}</span>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded bg-white dark:bg-background/50">
                        <span class="text-muted-foreground">Note</span>
                        <span class="font-bold {{ $evaluation->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format($evaluation->note, 2) }}/20
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded bg-white dark:bg-background/50">
                        <span class="text-muted-foreground">Appréciation</span>
                        <span class="text-xs font-bold">{{ $evaluation->getAppreciation() }}</span>
                    </div>
                </div>
            </div>

            <!-- Aide -->
            <div class="bg-blue-50 dark:bg-blue-950/20 border border-blue-200 dark:border-blue-800 rounded-xl p-5">
                <div class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="text-xs font-bold text-blue-900 dark:text-blue-100 uppercase tracking-wide mb-2">💡 Actions</h3>
                        <ul class="text-xs text-blue-800 dark:text-blue-200 space-y-1.5">
                            <li class="flex items-start gap-1.5">
                                <span class="font-bold">•</span>
                                <span>Cliquez sur Modifier</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="font-bold">•</span>
                                <span>Mettez à jour la note</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="font-bold">•</span>
                                <span>Enregistrez les changements</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Boutons d'action bas de page -->
    <div class="flex items-center justify-between pt-6 border-t border-border gap-4">
        <a href="{{ route('evaluations.index') }}" 
           class="px-6 py-2.5 text-foreground bg-muted hover:bg-muted/80 rounded-lg font-medium transition-all duration-200">
            Retour à la liste
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('evaluations.edit', $evaluation) }}" 
               class="px-6 py-2.5 text-accent bg-accent/10 hover:bg-accent/20 rounded-lg font-medium transition-all duration-200 border border-accent/20">
                Modifier
            </a>
        </div>
    </div>

</div>

@endsection

@push('styles')
<style>
    /* Smooth animations */
    * {
        @apply transition-colors duration-200;
    }

    /* Progress bar animation */
    @keyframes slideIn {
        from {
            width: 0;
        }
        to {
            width: var(--width, 100%);
        }
    }

    /* Card entrance animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .bg-card {
        animation: fadeInUp 0.5s ease-out;
    }

    /* Gradient text */
    .gradient-text {
        @apply bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation des cartes
    const cards = document.querySelectorAll('[class*="rounded-xl"]');
    cards.forEach((card, index) => {
        card.style.animation = `fadeInUp 0.5s ease-out ${index * 0.05}s both`;
    });

    // Animation de la barre de progression
    const progressBar = document.querySelector('[style*="width"]');
    if (progressBar) {
        const width = progressBar.style.width;
        progressBar.style.width = '0';
        setTimeout(() => {
            progressBar.style.animation = 'slideIn 1s ease-out forwards';
            progressBar.style.width = width;
        }, 100);
    }
});

// Confirmation suppression
function confirmDelete(message = 'Êtes-vous sûr ?') {
    return confirm(message);
}
</script>
@endpush
