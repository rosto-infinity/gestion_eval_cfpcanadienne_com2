@extends('layouts.app')

@section('title', 'Détails de l\'année académique')

@section('content')
<div class=" mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- En-tête avec navigation -->
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <a href="{{ route('annees.index') }}" 
           class="inline-flex items-center gap-2 text-primary hover:text-primary/80 font-semibold transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Retour à la liste
        </a>

        <!-- Boutons d'action -->
        <div class="flex flex-wrap gap-3">
            @if(!$annee->is_active)
            <form action="{{ route('annees.activate', $annee) }}" method="POST" 
                  onsubmit="return confirm('Êtes-vous sûr de vouloir activer cette année académique ?');"
                  class="inline">
                @csrf
                <button type="submit" 
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-semibold transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Activer
                </button>
            </form>
            @endif

            <a href="{{ route('annees.edit', $annee) }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-accent hover:bg-accent/90 text-accent-foreground rounded-lg font-semibold transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Modifier
            </a>
        </div>
    </div>

    <!-- En-tête principal de l'année -->
    <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden mb-8">
        <div class="p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                <div class="flex-1">
                    <h1 class="text-4xl sm:text-5xl font-bold text-foreground mb-4">{{ $annee->libelle }}</h1>
                    
                    <div class="flex flex-wrap items-center gap-6">
                        <!-- Dates -->
                        <div class="flex items-center gap-2 text-muted-foreground">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="font-medium">
                                Du <span class="text-foreground font-semibold">{{ $annee->date_debut->format('d/m/Y') }}</span> 
                                au <span class="text-foreground font-semibold">{{ $annee->date_fin->format('d/m/Y') }}</span>
                            </span>
                        </div>

                        <!-- Statut -->
                        <div>
                            @if($annee->is_active)
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary font-bold text-sm">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Année Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-muted text-muted-foreground font-bold text-sm">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    Inactive
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Durée -->
                <div class="text-right p-4 bg-primary/5 rounded-lg border border-primary/20">
                    <p class="text-sm font-semibold text-muted-foreground uppercase tracking-wide">Durée</p>
                    <p class="text-3xl font-bold text-foreground mt-2">
                        {{ $annee->date_debut->diffInDays($annee->date_fin) }}
                    </p>
                    <p class="text-xs text-muted-foreground mt-1">jours</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Étudiants -->
        <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-muted-foreground uppercase tracking-wide">Étudiants inscrits</p>
                        <p class="text-4xl font-bold text-foreground mt-2">{{ $stats['total_etudiants'] }}</p>
                    </div>
                    <div class="flex-shrink-0 p-3 bg-primary/10 rounded-lg">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
                <a href="{{ route('users.index', ['annee_id' => $annee->id]) }}" 
                   class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-primary hover:text-primary/80 transition-colors">
                    Voir les étudiants
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Évaluations -->
        <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-muted-foreground uppercase tracking-wide">Évaluations</p>
                        <p class="text-4xl font-bold text-foreground mt-2">{{ $stats['total_evaluations'] }}</p>
                    </div>
                    <div class="flex-shrink-0 p-3 bg-accent/10 rounded-lg">
                        <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
                <a href="{{ route('evaluations.index', ['annee_id' => $annee->id]) }}" 
                   class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-accent hover:text-accent/80 transition-colors">
                    Voir les évaluations
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Bilans -->
        <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-muted-foreground uppercase tracking-wide">Bilans</p>
                        <p class="text-4xl font-bold text-foreground mt-2">{{ $stats['total_bilans'] }}</p>
                    </div>
                    <div class="flex-shrink-0 p-3 bg-destructive/10 rounded-lg">
                        <svg class="w-8 h-8 text-destructive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <a href="{{ route('bilans.index', ['annee_id' => $annee->id]) }}" 
                   class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-destructive hover:text-destructive/80 transition-colors">
                    Voir les bilans
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Timeline de progression -->
    <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden mb-8">
        <div class="p-6 border-b border-border">
            <h2 class="text-2xl font-bold text-foreground flex items-center gap-2">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                📅 Progression de l'année
            </h2>
        </div>
        <div class="p-6">
            @php
                $today = now();
                $totalDays = $annee->date_debut->diffInDays($annee->date_fin);
                $elapsedDays = $annee->date_debut->isPast() ? $annee->date_debut->diffInDays(min($today, $annee->date_fin)) : 0;
                $progress = $totalDays > 0 ? min(100, ($elapsedDays / $totalDays) * 100) : 0;
                
                $status = match(true) {
                    $today->isBefore($annee->date_debut) => 'À venir',
                    $today->isAfter($annee->date_fin) => 'Terminée',
                    default => 'En cours'
                };
                
                $statusColor = match($status) {
                    'À venir' => 'bg-primary',
                    'En cours' => 'bg-primary',
                    'Terminée' => 'bg-muted',
                };
                
                $statusBgColor = match($status) {
                    'À venir' => 'bg-primary/10',
                    'En cours' => 'bg-primary/10',
                    'Terminée' => 'bg-muted/10',
                };
            @endphp

            <div class="mb-6">
                <div class="flex justify-between items-center mb-3">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-semibold text-foreground">{{ $annee->date_debut->format('d/m/Y') }}</span>
                        <span class="text-muted-foreground">→</span>
                        <span class="text-sm font-semibold text-foreground">{{ $annee->date_fin->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full {{ $statusBgColor }} text-foreground font-bold text-sm">
                            <span class="w-2 h-2 rounded-full {{ $statusColor }}"></span>
                            {{ $status }}
                        </span>
                        <span class="text-sm font-bold text-foreground">{{ number_format($progress, 1) }}%</span>
                    </div>
                </div>

                <!-- Barre de progression -->
                <div class="w-full bg-muted rounded-full h-3 overflow-hidden">
                    <div class="{{ $statusColor }} h-3 rounded-full transition-all duration-500 ease-out shadow-sm" 
                         style="width: {{ $progress }}%"></div>
                </div>
            </div>

            <!-- Statistiques de progression -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="p-4 bg-muted/30 border border-border rounded-lg text-center">
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Jours écoulés</p>
                    <p class="text-3xl font-bold text-foreground mt-2">{{ $elapsedDays }}</p>
                </div>
                <div class="p-4 bg-muted/30 border border-border rounded-lg text-center">
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Jours restants</p>
                    <p class="text-3xl font-bold text-foreground mt-2">{{ max(0, $totalDays - $elapsedDays) }}</p>
                </div>
                <div class="p-4 bg-muted/30 border border-border rounded-lg text-center">
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Durée totale</p>
                    <p class="text-3xl font-bold text-foreground mt-2">{{ $totalDays }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
        <div class="p-6 border-b border-border">
            <h2 class="text-2xl font-bold text-foreground flex items-center gap-2">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 17v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.381z" clip-rule="evenodd"/>
                </svg>
                ⚡ Actions rapides
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Ajouter un étudiant -->
                <a href="{{ route('users.create') }}" 
                   class="group p-6 border-2 border-dashed border-border rounded-lg hover:border-primary hover:bg-primary/5 transition-all duration-200">
                    <div class="flex flex-col items-center text-center">
                        <div class="p-3 bg-primary/10 rounded-lg group-hover:bg-primary/20 transition-colors mb-3">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-foreground">Ajouter un étudiant</p>
                    </div>
                </a>

                <!-- Saisir des notes -->
                <a href="{{ route('evaluations.saisir-multiple') }}" 
                   class="group p-6 border-2 border-dashed border-border rounded-lg hover:border-accent hover:bg-accent/5 transition-all duration-200">
                    <div class="flex flex-col items-center text-center">
                        <div class="p-3 bg-accent/10 rounded-lg group-hover:bg-accent/20 transition-colors mb-3">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-foreground">Saisir des notes</p>
                    </div>
                </a>

                <!-- Créer un bilan -->
                <a href="{{ route('bilans.create') }}" 
                   class="group p-6 border-2 border-dashed border-border rounded-lg hover:border-destructive hover:bg-destructive/5 transition-all duration-200">
                    <div class="flex flex-col items-center text-center">
                        <div class="p-3 bg-destructive/10 rounded-lg group-hover:bg-destructive/20 transition-colors mb-3">
                            <svg class="w-6 h-6 text-destructive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-foreground">Créer un bilan</p>
                    </div>
                </a>

                <!-- Voir les résultats -->
                <a href="{{ route('bilans.tableau-recapitulatif', ['annee_id' => $annee->id]) }}" 
                   class="group p-6 border-2 border-dashed border-border rounded-lg hover:border-primary hover:bg-primary/5 transition-all duration-200">
                    <div class="flex flex-col items-center text-center">
                        <div class="p-3 bg-primary/10 rounded-lg group-hover:bg-primary/20 transition-colors mb-3">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-foreground">Voir les résultats</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

</div>

@endsection

@push('styles')
<style>
    .card {
        display: block;
    }

    /* Animation de la barre de progression */
    @keyframes slideIn {
        from {
            width: 0;
        }
    }

    .card div[style*="width"] {
        animation: slideIn 1s ease-out;
    }
</style>
@endpush
