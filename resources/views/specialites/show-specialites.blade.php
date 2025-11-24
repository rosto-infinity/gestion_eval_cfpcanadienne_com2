@extends('layouts.app')

@section('title', 'Détails de la spécialité')

@section('content')
<div class="min-h-screen" style="background-color: var(--background)">
    <!-- En-tête avec navigation -->
    <div class="mb-8 flex justify-between items-center">
        <a 
            href="{{ route('specialites.index') }}" 
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg transition-all duration-200 hover:shadow-md"
            style="color: var(--primary); background-color: var(--secondary)"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span class="font-medium">{{ __('Retour') }}</span>
        </a>
        
        <a 
            href="{{ route('specialites.edit', $specialite) }}" 
            class="inline-flex items-center gap-2 px-6 py-2 rounded-lg font-semibold transition-all duration-200 hover:shadow-lg active:scale-95"
            style="background-color: var(--primary); color: var(--primary-foreground)"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            {{ __('Modifier') }}
        </a>
    </div>

    <!-- En-tête de la spécialité -->
    <div class="mb-8 rounded-xl border-2 overflow-hidden shadow-sm transition-all duration-200 hover:shadow-md" style="background-color: var(--card); border-color: var(--border)">
        <div class="p-8">
            <div class="flex items-start justify-between gap-6">
                <!-- Avatar & Infos -->
                <div class="flex items-start gap-6 flex-1">
                    <div 
                        class="h-20 w-20 rounded-xl flex items-center justify-center text-3xl font-bold text-white flex-shrink-0"
                        style="background: linear-gradient(135deg, var(--primary), var(--primary) 100%)"
                    >
                        {{ strtoupper(substr($specialite->code, 0, 2)) }}
                    </div>
                    
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold mb-1" style="color: var(--foreground)">
                            {{ $specialite->intitule }}
                        </h1>
                        <p class="text-sm font-medium mb-4" style="color: var(--muted-foreground)">
                            {{ __('Code') }}: <span style="color: var(--primary)">{{ $specialite->code }}</span>
                        </p>
                        
                        @if($specialite->description)
                        <div class="p-4 rounded-lg" style="background-color: var(--secondary); border-left: 3px solid var(--primary)">
                            <p class="text-sm leading-relaxed" style="color: var(--foreground)">
                                {{ $specialite->description }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Badge de statut -->
                <div class="text-right">
                    <span 
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold"
                        style="background-color: var(--secondary); color: var(--primary)"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ __('Active') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Total Étudiants -->
        <div class="rounded-xl border-2 overflow-hidden transition-all duration-200 hover:shadow-md" style="background-color: var(--card); border-color: var(--border)">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium mb-2" style="color: var(--muted-foreground)">
                            {{ __('Total Étudiants') }}
                        </p>
                        <p class="text-4xl font-bold" style="color: var(--foreground)">
                            {{ $stats['total_etudiants'] }}
                        </p>
                    </div>
                    <div 
                        class="p-3 rounded-lg"
                        style="background-color: var(--secondary)"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--primary)">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
                
                <a 
                    href="{{ route('users.index', ['specialite_id' => $specialite->id]) }}" 
                    class="mt-4 inline-flex items-center gap-1 text-sm font-medium transition-opacity hover:opacity-75"
                    style="color: var(--primary)"
                >
                    {{ __('Voir tous') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Étudiants Actifs -->
        <div class="rounded-xl border-2 overflow-hidden transition-all duration-200 hover:shadow-md" style="background-color: var(--card); border-color: var(--border)">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium mb-2" style="color: var(--muted-foreground)">
                            {{ __('Étudiants Actifs') }}
                        </p>
                        <p class="text-4xl font-bold" style="color: var(--foreground)">
                            {{ $stats['etudiants_actifs'] }}
                        </p>
                        <div class="mt-3 flex items-center gap-2">
                            <div class="flex-1 h-1.5 rounded-full overflow-hidden" style="background-color: var(--secondary)">
                                <div 
                                    class="h-full transition-all duration-300"
                                    style="width: {{ $stats['total_etudiants'] > 0 ? ($stats['etudiants_actifs'] / $stats['total_etudiants']) * 100 : 0 }}%; background: linear-gradient(90deg, var(--primary), var(--primary))"
                                ></div>
                            </div>
                            <span class="text-sm font-semibold" style="color: var(--primary)">
                                {{ $stats['total_etudiants'] > 0 ? number_format(($stats['etudiants_actifs'] / $stats['total_etudiants']) * 100, 1) : 0 }}%
                            </span>
                        </div>
                    </div>
                    <div 
                        class="p-3 rounded-lg"
                        style="background-color: var(--secondary)"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #10b981">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des étudiants -->
    <div class="rounded-xl border-2 overflow-hidden" style="background-color: var(--card); border-color: var(--border)">
        <!-- En-tête du tableau -->
        <div class="flex justify-between items-center p-6 border-b-2" style="border-color: var(--border)">
            <h2 class="text-xl font-bold flex items-center gap-2" style="color: var(--foreground)">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--primary)">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                {{ __('Étudiants Inscrits') }}
            </h2>
            <a 
                href="{{ route('users.create') }}?specialite_id={{ $specialite->id }}" 
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg font-semibold transition-all duration-200 hover:shadow-md active:scale-95"
                style="background-color: var(--primary); color: var(--primary-foreground)"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('Ajouter') }}
            </a>
        </div>

        <!-- Contenu -->
        <div class="p-6">
            @if($etudiants->isEmpty())
            <!-- État vide -->
            <div class="text-center py-16">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4" style="background-color: var(--secondary)">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--muted-foreground)">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-1" style="color: var(--foreground)">
                    {{ __('Aucun étudiant inscrit') }}
                </h3>
                <p class="text-sm mb-6" style="color: var(--muted-foreground)">
                    {{ __('Aucun étudiant n\'est encore inscrit dans cette spécialité.') }}
                </p>
                <a 
                    href="{{ route('users.create') }}" 
                    class="inline-flex items-center gap-2 px-6 py-2 rounded-lg font-semibold transition-all duration-200 hover:shadow-lg active:scale-95"
                    style="background-color: var(--primary); color: var(--primary-foreground)"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Ajouter un étudiant') }}
                </a>
            </div>

            @else
            <!-- Tableau des étudiants -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border)">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider" style="color: var(--muted-foreground)">
                                {{ __('Matricule') }}
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider" style="color: var(--muted-foreground)">
                                {{ __('Nom & Prénom') }}
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider" style="color: var(--muted-foreground)">
                                {{ __('Niveau') }}
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider" style="color: var(--muted-foreground)">
                                {{ __('Année Académique') }}
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider" style="color: var(--muted-foreground)">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: var(--border)">
                        @foreach($etudiants as $etudiant)
                        <tr class="transition-all duration-200 hover:bg-opacity-50" style="background-color: transparent">
                            <!-- Matricule -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold" style="color: var(--primary)">
                                    {{ $etudiant->matricule }}
                                </span>
                            </td>

                            <!-- Nom & Prénom -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($etudiant->profile)
                                    <img 
                                        class="h-10 w-10 rounded-full object-cover ring-2" 
                                        src="{{ Storage::url($etudiant->profile) }}" 
                                        alt="{{ $etudiant->name }}"
                                        style="--tw-ring-color: var(--primary)"
                                    >
                                    @else
                                    <div 
                                        class="h-10 w-10 rounded-full flex items-center justify-center text-xs font-bold text-white"
                                        style="background: linear-gradient(135deg, var(--primary), var(--primary))"
                                    >
                                        {{ strtoupper(substr($etudiant->name, 0, 2)) }}
                                    </div>
                                    @endif
                                    <div>
                                        <p class="text-sm font-semibold" style="color: var(--foreground)">
                                            {{ $etudiant->name }}
                                        </p>
                                        <p class="text-xs" style="color: var(--muted-foreground)">
                                            {{ $etudiant->email }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <!-- Niveau -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span 
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold"
                                    style="background-color: var(--secondary); color: var(--primary)"
                                >
                                    {{ $etudiant->niveau->label() }}
                                </span>
                            </td>

                            <!-- Année Académique -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm" style="color: var(--foreground)">
                                {{ $etudiant->anneeAcademique->libelle ?? 'N/A' }}
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a 
                                        href="{{ route('users.show', $etudiant) }}" 
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200 hover:shadow-md"
                                        style="background-color: var(--secondary); color: var(--primary)"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        {{ __('Voir') }}
                                    </a>
                                    <a 
                                        href="{{ route('evaluations.releve-notes', $etudiant) }}" 
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200 hover:shadow-md"
                                        style="background-color: var(--secondary); color: var(--foreground)"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        {{ __('Relevé') }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($etudiants->hasPages())
            <div class="mt-6 pt-6 border-t-2" style="border-color: var(--border)">
                {{ $etudiants->links() }}
            </div>
            @endif
            @endif
        </div>
    </div>
</div>

<style>
    /* Animations fluides */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-in {
        animation: slideIn 0.3s ease-out;
    }
</style>
@endsection
