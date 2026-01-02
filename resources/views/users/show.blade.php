@extends('layouts.app')

@section('title', 'Détails de l\'étudiant')

@section('content')
<div class="mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- En-tête avec navigation -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <a href="{{ route('users.index') }}" 
           class="inline-flex items-center gap-2 text-sm font-medium text-muted-foreground hover:text-foreground transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Retour à la liste
        </a>
        
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('evaluations.saisir-multiple', ['user_id' => $user->id]) }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-medium transition-all duration-200 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Saisir notes
            </a>
            <a href="{{ route('evaluations.releve-notes', $user) }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-accent hover:bg-accent/90 text-accent-foreground rounded-lg font-medium transition-all duration-200 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Relevé de notes
            </a>
            <a href="{{ route('users.edit', $user) }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-muted hover:bg-muted/80 text-muted-foreground rounded-lg font-medium transition-all duration-200 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Modifier
            </a>
        </div>
    </div>

    <!-- Profil étudiant -->
    <div class="bg-card border border-border rounded-lg shadow-sm overflow-hidden mb-8">
        <div class="p-8">
            <div class="flex flex-col sm:flex-row gap-8">
                
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    @if($user->profile)
                        <img class="h-40 w-40 rounded-xl object-cover border-2 border-primary/20 shadow-md" 
                             src="{{ Storage::url($user->profile) }}" 
                             alt="{{ $user->name }}">
                    @else
                        <div class="h-40 w-40 rounded-xl bg-gradient-to-br from-primary/20 to-primary/10 flex items-center justify-center text-3xl font-bold text-primary border-2 border-primary/20 shadow-md">
                            {{ $user->initials() ?? 'U' }}
                        </div>
                    @endif
                </div>

                <!-- Informations principales -->
                <div class="flex-1">
                    <div class="mb-4">
                        <h1 class="text-3xl font-bold text-foreground mb-2">{{ $user->name }}</h1>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-primary/10 text-primary rounded-full text-sm font-medium">
                                {{ $user->sexe === 'M' ? '👨' : '👩' }}
                                {{ $user->sexe === 'M' ? 'Masculin' : 'Féminin' }}
                            </span>
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-accent/10 text-accent rounded-full text-sm font-medium">
                                📚 
                                @if (is_object($user->niveau))
                                    {{ $user->niveau->label() }}
                                @else
                                    {{ $user->niveau ?? 'N/A' }}
                                @endif
                            </span>
                            @if($user->bilanCompetence)
                                <span class="inline-flex items-center gap-1 px-3 py-1 {{ $user->bilanCompetence->isAdmis() ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded-full text-sm font-medium">
                                    {{ $user->bilanCompetence->isAdmis() ? '✓' : '✗' }}
                                    {{ $user->bilanCompetence->getMention() }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Grille d'informations -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                        <div>
                            <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1">Matricule</p>
                            <p class="text-sm font-semibold text-foreground">{{ $user->matricule ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1">Email</p>
                            <p class="text-sm font-semibold text-foreground truncate">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1">Spécialité</p>
                            <p class="text-sm font-semibold text-foreground">
                                {{ $user->specialite?->intitule ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1">Année académique</p>
                            <p class="text-sm font-semibold text-foreground">{{ $user->anneeAcademique?->libelle ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1">Inscription</p>
                            <p class="text-sm font-semibold text-foreground">
                                @if (is_string($user->created_at))
                                    {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}
                                @else
                                    {{ $user->created_at->format('d/m/Y') }}
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1">Dernière mise à jour</p>
                            <p class="text-sm font-semibold text-foreground">
                                @if (is_string($user->updated_at))
                                    {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y') }}
                                @else
                                    {{ $user->updated_at->format('d/m/Y') }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informations Complémentaires -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Informations Civiles -->
        <div class="bg-card border border-border rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 border-b border-border bg-muted/30">
                <h2 class="text-lg font-bold text-foreground flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                    Informations Civiles
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-border">
                    <span class="text-sm font-semibold text-muted-foreground">Date de naissance</span>
                    <span class="text-sm font-medium text-foreground">
                        @if ($user->date_naissance)
                            @if (is_string($user->date_naissance))
                                {{ \Carbon\Carbon::parse($user->date_naissance)->format('d/m/Y') }}
                            @else
                                {{ $user->date_naissance->format('d/m/Y') }}
                            @endif
                        @else
                            -
                        @endif
                    </span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-border">
                    <span class="text-sm font-semibold text-muted-foreground">Lieu de naissance</span>
                    <span class="text-sm font-medium text-foreground">{{ $user->lieu_naissance ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-semibold text-muted-foreground">Nationalité</span>
                    <span class="text-sm font-medium text-foreground">{{ $user->nationalite ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Contact -->
        <div class="bg-card border border-border rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 border-b border-border bg-muted/30">
                <h2 class="text-lg font-bold text-foreground flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                    </svg>
                    Contact
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-border">
                    <span class="text-sm font-semibold text-muted-foreground">Téléphone</span>
                    <span class="text-sm font-medium text-foreground">{{ $user->telephone ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-border">
                    <span class="text-sm font-semibold text-muted-foreground">Téléphone d'urgence</span>
                    <span class="text-sm font-medium text-orange-600">{{ $user->telephone_urgence ?? '-' }}</span>
                </div>
                <div class="py-2">
                    <span class="text-sm font-semibold text-muted-foreground">Adresse</span>
                    <p class="text-sm font-medium text-foreground mt-1">{{ $user->adresse ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Documents et Statut -->
        <div class="bg-card border border-border rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 border-b border-border bg-muted/30">
                <h2 class="text-lg font-bold text-foreground flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                    </svg>
                    Documents et Statut
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-border">
                    <span class="text-sm font-semibold text-muted-foreground">Pièce d'identité</span>
                    <span class="text-sm font-medium text-foreground">{{ $user->piece_identite ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-semibold text-muted-foreground">Statut</span>
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold {{ $user->statut === 'actif' ? 'bg-green-100 text-green-700' : ($user->statut === 'inactif' ? 'bg-gray-100 text-gray-700' : ($user->statut === 'suspendu' ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700')) }}">
                        @switch($user->statut)
                            @case('actif')
                                ✅ Actif
                            @break
                            @case('inactif')
                                ⏸️ Inactif
                            @break
                            @case('suspendu')
                                ⛔ Suspendu
                            @break
                            @case('archive')
                                📦 Archivé
                            @break
                            @default
                                ❓ Inconnu
                        @endswitch
                    </span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-semibold text-muted-foreground">Photo de profil</span>
                    @if($user->profile)
                        <a href="{{ Storage::url($user->profile) }}" target="_blank" class="text-primary hover:underline text-sm">
                            Voir la photo
                        </a>
                    @else
                        <span class="text-sm text-muted-foreground">Aucune photo</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques clés -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        
        <!-- Total évaluations -->
        <div class="bg-card border border-border rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Total évaluations</p>
                    <p class="text-3xl font-bold text-foreground">{{ $stats['total_evaluations'] }}</p>
                </div>
                <div class="p-3 bg-primary/10 rounded-lg">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Moyenne S1 -->
        <div class="bg-card border border-border rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Moyenne S1</p>
                    <p class="text-3xl font-bold {{ $stats['moyenne_semestre1'] && $stats['moyenne_semestre1'] >= 10 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $stats['moyenne_semestre1'] ? number_format($stats['moyenne_semestre1'], 2) : '-' }}
                    </p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Moyenne S2 -->
        <div class="bg-card border border-border rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Moyenne S2</p>
                    <p class="text-3xl font-bold {{ $stats['moyenne_semestre2'] && $stats['moyenne_semestre2'] >= 10 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $stats['moyenne_semestre2'] ? number_format($stats['moyenne_semestre2'], 2) : '-' }}
                    </p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Bilan de compétences -->
        <div class="bg-card border border-border rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Bilan</p>
                    <p class="text-sm font-semibold text-foreground">
                        @if($stats['has_bilan'])
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold">✓ Complété</span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-amber-100 text-amber-700 rounded text-xs font-bold">⏳ En attente</span>
                        @endif
                    </p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    <!-- Bilan de compétences -->
    @if($user->bilanCompetence)
        <div class="bg-card border border-border rounded-lg shadow-sm overflow-hidden mb-8">
            <div class="p-6 border-b border-border bg-muted/30">
                <h2 class="text-lg font-bold text-foreground flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    Bilan de Compétences
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    
                    <!-- Moyenne Évaluations -->
                    <div class="p-4 bg-blue-50 dark:bg-blue-950/30 border border-blue-200 dark:border-blue-800 rounded-lg text-center">
                        <p class="text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wide mb-2">Moyenne Évaluations</p>
                        <p class="text-3xl font-bold text-blue-700 dark:text-blue-300">
                            {{ number_format($user->bilanCompetence->moy_evaluations, 2) }}
                        </p>
                        <p class="text-xs text-blue-600 dark:text-blue-400 mt-2 font-medium">30% de la note finale</p>
                    </div>

                    <!-- Moyenne Compétences -->
                    <div class="p-4 bg-purple-50 dark:bg-purple-950/30 border border-purple-200 dark:border-purple-800 rounded-lg text-center">
                        <p class="text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase tracking-wide mb-2">Bilan Compétences</p>
                        <p class="text-3xl font-bold text-purple-700 dark:text-purple-300">
                            {{ number_format($user->bilanCompetence->moy_competences, 2) }}
                        </p>
                        <p class="text-xs text-purple-600 dark:text-purple-400 mt-2 font-medium">70% de la note finale</p>
                    </div>

                    <!-- Moyenne Générale -->
                    <div class="p-4 {{ $user->bilanCompetence->isAdmis() ? 'bg-green-50 dark:bg-green-950/30 border-green-200 dark:border-green-800' : 'bg-red-50 dark:bg-red-950/30 border-red-200 dark:border-red-800' }} border rounded-lg text-center sm:col-span-2">
                        <p class="text-xs font-semibold {{ $user->bilanCompetence->isAdmis() ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} uppercase tracking-wide mb-2">Moyenne Générale</p>
                        <p class="text-4xl font-bold {{ $user->bilanCompetence->isAdmis() ? 'text-green-700 dark:text-green-300' : 'text-red-700 dark:text-red-300' }}">
                            {{ number_format($user->bilanCompetence->moyenne_generale, 2) }}
                        </p>
                        <p class="mt-3">
                            <span class="inline-flex items-center gap-1 px-3 py-1 {{ $user->bilanCompetence->isAdmis() ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300' }} rounded-full text-sm font-bold">
                                {{ $user->bilanCompetence->isAdmis() ? '✓' : '✗' }}
                                {{ $user->bilanCompetence->getMention() }}
                            </span>
                        </p>
                    </div>

                </div>

                @if($user->bilanCompetence->observations)
                    <div class="p-4 bg-muted/50 border border-border rounded-lg mb-6">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Observations</p>
                        <p class="text-sm text-foreground">{{ $user->bilanCompetence->observations }}</p>
                    </div>
                @endif

                <div class="flex justify-end">
                    <a href="{{ route('bilans.show', $user->bilanCompetence) }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-medium transition-all duration-200 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Voir le bilan complet
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-card border border-border rounded-lg shadow-sm overflow-hidden mb-8">
            <div class="p-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-muted/50 rounded-full mb-4">
                    <svg class="w-8 h-8 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-foreground mb-2">Aucun bilan de compétences</h3>
                <p class="text-sm text-muted-foreground mb-6">Créez un bilan de compétences pour cet étudiant.</p>
                <a href="{{ route('bilans.create', ['user_id' => $user->id]) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-medium transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Créer un bilan
                </a>
            </div>
        </div>
    @endif

    <!-- Évaluations récentes -->
    <div class="bg-card border border-border rounded-lg shadow-sm overflow-hidden">
        <div class="p-6 border-b border-border bg-muted/30">
            <h2 class="text-lg font-bold text-foreground flex items-center gap-2">
                <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 100-2H3a1 1 0 00-1 1v14a1 1 0 001 1h14a1 1 0 001-1V4a1 1 0 00-1-1h-2a1 1 0 100 2h1v13H4V5z" clip-rule="evenodd"/>
                </svg>
                Évaluations Récentes
            </h2>
        </div>
        <div class="p-6">
            @if($user->evaluations->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto w-12 h-12 text-muted-foreground mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-sm text-muted-foreground">Aucune évaluation enregistrée</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-border">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wide">Module</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-muted-foreground uppercase tracking-wide">Semestre</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-muted-foreground uppercase tracking-wide">Note</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wide">Appréciation</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wide">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach($user->evaluations->sortByDesc('created_at')->take(10) as $eval)
                                <tr class="hover:bg-muted/30 transition-colors">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-primary/10 text-primary rounded text-xs font-bold">
                                                {{ $eval->module->code }}
                                            </span>
                                            <span class="text-sm font-medium text-foreground">{{ $eval->module->intitule }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="text-sm font-medium text-foreground">S{{ $eval->semestre }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="text-lg font-bold {{ $eval->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ number_format($eval->note, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center gap-1 px-2 py-1 {{ $eval->note >= 10 ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300' }} rounded text-xs font-bold">
                                            {{ $eval->note >= 10 ? '✓' : '✗' }}
                                            {{ $eval->getAppreciation() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-muted-foreground">
                                        @if (is_string($eval->created_at))
                                            {{ \Carbon\Carbon::parse($eval->created_at)->format('d/m/Y H:i') }}
                                        @else
                                            {{ $eval->created_at->format('d/m/Y H:i') }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($user->evaluations->count() > 10)
                    <div class="mt-4 text-center">
                        <a href="{{ route('evaluations.index', ['user_id' => $user->id]) }}" 
                           class="text-sm font-medium text-primary hover:text-primary/80 transition-colors">
                            Voir toutes les évaluations →
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </div>

</div>

@endsection

@push('styles')
<style>
    /* Smooth transitions */
    * {
        @apply transition-colors duration-200;
    }

    /* Table hover effect */
    tbody tr {
        @apply hover:bg-muted/50;
    }

    /* Badge styles */
    .badge {
        @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .grid-cols-1 {
            @apply grid-cols-1;
        }
    }
</style>
@endpush
