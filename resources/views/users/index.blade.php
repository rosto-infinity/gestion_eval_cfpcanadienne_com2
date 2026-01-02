@extends('layouts.app')

@section('title', 'Étudiants')

@section('content')
<div class=" mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- En-tête -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-foreground">👨‍🎓 Étudiants</h1>
            <p class="mt-1 text-sm text-muted-foreground">
                Gérez et consultez la liste de tous les étudiants
            </p>
        </div>
        <div class="flex flex-wrap gap-2">
            <button onclick="location.reload()" 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-muted hover:bg-muted/80 text-muted-foreground rounded-lg font-medium transition-all duration-200 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Recharger
            </button>
            <a href="{{ route('users.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-medium transition-all duration-200 text-sm shadow-sm hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouvel étudiant
            </a>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-card border border-border rounded-lg shadow-sm overflow-hidden mb-8">
        <div class="p-6 border-b border-border bg-muted/30">
            <h2 class="text-sm font-bold text-foreground uppercase tracking-wide flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"/>
                </svg>
                Filtres
            </h2>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ route('users.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <!-- Recherche -->
                    <div>
                        <label for="search" class="block text-sm font-semibold text-foreground mb-2">
                            Rechercher
                        </label>
                        <input type="text" 
                               name="search" 
                               id="search" 
                               value="{{ request('search') }}"
                               placeholder="Nom, prénom, matricule..."
                               class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all">
                    </div>

                    <!-- Spécialité -->
                    <div>
                        <label for="specialite_id" class="block text-sm font-semibold text-foreground mb-2">
                            Spécialité
                        </label>
                        <select name="specialite_id" id="specialite_id" 
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all">
                            <option value="">Toutes les spécialités</option>
                            @foreach($specialites as $specialite)
                                <option value="{{ $specialite->id }}" {{ request('specialite_id') == $specialite->id ? 'selected' : '' }}>
                                    {{ $specialite->intitule }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Année académique -->
                    <div>
                        <label for="annee_id" class="block text-sm font-semibold text-foreground mb-2">
                            Année académique
                        </label>
                        <select name="annee_id" id="annee_id" 
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all">
                            <option value="">Toutes les années</option>
                            @foreach($annees as $annee)
                                <option value="{{ $annee->id }}" {{ request('annee_id') == $annee->id ? 'selected' : '' }}>
                                    {{ $annee->libelle }} {{ $annee->is_active ? '(Active)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bouton Filtrer -->
                    <div class="flex items-end">
                        <button type="submit" 
                                class="w-full px-4 py-2.5 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-medium transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Filtrer
                        </button>
                    </div>

                </div>

                <!-- Lien réinitialiser -->
                @if(request()->hasAny(['search', 'specialite_id', 'annee_id']))
                    <div class="flex justify-end">
                        <a href="{{ route('users.index') }}" 
                           class="text-sm font-medium text-primary hover:text-primary/80 transition-colors">
                            Réinitialiser les filtres
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Liste des étudiants -->
    <div class="bg-card border border-border rounded-lg shadow-sm overflow-hidden">
        
        @if($users->isEmpty())
            <!-- État vide -->
            <div class="p-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-muted/50 rounded-full mb-4">
                    <svg class="w-8 h-8 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-foreground mb-2">Aucun étudiant trouvé</h3>
                <p class="text-sm text-muted-foreground mb-6">
                    @if(request()->hasAny(['search', 'specialite_id', 'annee_id']))
                        Essayez de modifier vos critères de recherche.
                    @else
                        Commencez par ajouter un nouvel étudiant.
                    @endif
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    @if(request()->hasAny(['search', 'specialite_id', 'annee_id']))
                        <a href="{{ route('users.index') }}" 
                           class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-muted hover:bg-muted/80 text-muted-foreground rounded-lg font-medium transition-all duration-200">
                            Réinitialiser
                        </a>
                    @endif
                    <a href="{{ route('users.create') }}" 
                       class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-medium transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Ajouter un étudiant
                    </a>
                </div>
            </div>
        @else
            <!-- Tableau -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-border bg-muted/30">
                            <th class="px-6 py-3 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wide">Photo</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wide">Matricule</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wide">Nom et Prénom</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wide">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wide">Sexe</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wide">Niveau</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wide">Spécialité</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wide">Année</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wide">Statut</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-muted-foreground uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach($users as $user)
                            <tr class="hover:bg-muted/30 transition-colors duration-150">
                                
                                <!-- Photo -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex-shrink-0">
                                        @if($user->profile)
                                            <img class="h-10 w-10 rounded-full object-cover border border-border" 
                                                 src="{{ Storage::url($user->profile) }}" 
                                                 alt="{{ $user->name }}"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-primary/40 to-primary/20 flex items-center justify-center text-xs font-bold text-primary hidden border border-primary/20">
                                                {{ $user->initials() }}
                                            </div>
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-primary/40 to-primary/20 flex items-center justify-center text-xs font-bold text-primary border border-primary/20">
                                                {{ $user->initials() }}
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Matricule -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-foreground">{{ $user->matricule ?? '-' }}</span>
                                </td>

                                <!-- Nom et Email -->
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-foreground">{{ $user->name }}</div>
                                    <div class="text-xs text-muted-foreground truncate">{{ $user->email }}</div>
                                </td>

                                <!-- Contact -->
                                <td class="px-6 py-4">
                                    <div class="text-xs text-muted-foreground">
                                        @if($user->telephone)
                                            <div class="flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                                </svg>
                                                {{ $user->telephone }}
                                            </div>
                                        @endif
                                        @if($user->telephone_urgence)
                                            <div class="flex items-center gap-1 text-orange-600">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ $user->telephone_urgence }}
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Sexe -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold {{ $user->sexe === 'M' ? 'bg-blue-100 text-blue-700' : ($user->sexe === 'F' ? 'bg-pink-100 text-pink-700' : 'bg-gray-100 text-gray-700') }}">
                                        {{ $user->sexe === 'M' ? '👨' : ($user->sexe === 'F' ? '👩' : '🧑') }}
                                        {{ $user->sexe === 'M' ? 'M' : ($user->sexe === 'F' ? 'F' : 'Autre') }}
                                    </span>
                                </td>

                                <!-- Niveau -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-accent/10 text-accent">
                                        {{ $user->niveau?->label() ?? 'N/A' }}
                                    </span>
                                </td>

                                <!-- Spécialité -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->specialite)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary">
                                            📚 {{ $user->specialite->intitule }}
                                        </span>
                                    @else
                                        <span class="text-xs text-muted-foreground">-</span>
                                    @endif
                                </td>

                                <!-- Année Académique -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->anneeAcademique)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300">
                                            📅 {{ $user->anneeAcademique->libelle }}
                                        </span>
                                    @else
                                        <span class="text-xs text-muted-foreground">-</span>
                                    @endif
                                </td>

                                <!-- Statut -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold {{ $user->statut === 'actif' ? 'bg-green-100 text-green-700' : ($user->statut === 'inactif' ? 'bg-gray-100 text-gray-700' : ($user->statut === 'suspendu' ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700')) }}">
                                        @switch($user->statut)
                                            @case('actif')
                                                ✅ Actif
                                            @case('inactif')
                                                ⏸️ Inactif
                                            @case('suspendu')
                                                ⛔ Suspendu
                                            @case('archive')
                                                📦 Archivé
                                            @default
                                                ❓ Inconnu
                                        @endswitch
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex justify-end gap-1">
                                        
                                        <!-- Voir détails -->
                                        <a href="{{ route('users.show', $user) }}" 
                                           class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-primary/10 hover:bg-primary/20 text-primary transition-all duration-200" 
                                           title="Voir détails">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>

                                        <!-- Relevé de notes -->
                                        @if($user->anneeAcademique)
                                            <a href="{{ route('evaluations.releve-notes', $user) }}" 
                                               class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-accent/10 hover:bg-accent/20 text-accent transition-all duration-200" 
                                               title="Relevé de notes">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </a>

                                            <!-- Saisir notes -->
                                            <a href="{{ route('evaluations.saisir-multiple', ['user_id' => $user->id]) }}" 
                                               class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-green-100 hover:bg-green-200 text-green-700 transition-all duration-200" 
                                               title="Saisir notes">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @endif

                                        <!-- Modifier -->
                                        <a href="{{ route('users.edit', $user) }}" 
                                           class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-100 hover:bg-blue-200 text-blue-700 transition-all duration-200" 
                                           title="Modifier">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </a>

                                        <!-- Supprimer -->
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" 
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-100 hover:bg-red-200 text-red-700 transition-all duration-200" 
                                                    title="Supprimer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>

                                       

                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-border bg-muted/30">
                {{ $users->links() }}
            </div>

        @endif

    </div>

</div>

@endsection

@push('styles')
<style>
    /* Smooth transitions */
    * {
        @apply transition-colors duration-200;
    }

    /* Select styling */
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23666' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
        padding-right: 2.5rem;
        appearance: none;
    }

    @media (prefers-color-scheme: dark) {
        select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23aaa' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        }
    }

    /* Table row hover */
    tbody tr {
        @apply hover:bg-muted/30;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .overflow-x-auto {
            @apply -mx-6 -mb-6;
        }

        table {
            @apply text-sm;
        }

        th, td {
            @apply px-3 py-2;
        }
    }
</style>
@endpush
