@extends('layouts.app')

@section('title', 'Évaluations')

@section('content')
    <div class=" mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- En-tête -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-foreground">📊 Évaluations</h1>
                <p class="mt-1 text-sm text-muted-foreground">
                    Gestion des notes et évaluations des étudiants
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('evaluations.saisir-multiple') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-accent hover:bg-accent/90 text-accent-foreground rounded-lg font-medium transition-all duration-200 text-sm shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Saisie Multiple
                </a>
                <a href="{{ route('evaluations.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-medium transition-all duration-200 text-sm shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouvelle Évaluation
                </a>
            </div>
        </div>

        <!-- Filtres -->
        <div class="bg-card border border-border rounded-lg shadow-sm overflow-hidden mb-8">
            <div class="p-6 border-b border-border bg-muted/30">
                <h2 class="text-sm font-bold text-foreground uppercase tracking-wide flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                            clip-rule="evenodd" />
                    </svg>
                    Filtres
                </h2>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('evaluations.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                        <!-- Étudiant -->
                        <div>
                            <label for="user_id" class="block text-sm font-semibold text-foreground mb-2">
                                Étudiant
                            </label>
                            <select name="user_id" id="user_id"
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all">
                                <option value="">Tous les étudiants</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->matricule }} - {{ $user->getFullName() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Semestre -->
                        <div>
                            <label for="semestre" class="block text-sm font-semibold text-foreground mb-2">
                                Semestre
                            </label>
                            <select name="semestre" id="semestre"
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all">
                                <option value="">Tous les semestres</option>
                                <option value="1" {{ request('semestre') == '1' ? 'selected' : '' }}>Semestre 1
                                </option>
                                <option value="2" {{ request('semestre') == '2' ? 'selected' : '' }}>Semestre 2
                                </option>
                            </select>
                        </div>

                        <!-- Année Académique -->
                        <div>
                            <label for="annee_id" class="block text-sm font-semibold text-foreground mb-2">
                                Année Académique
                            </label>
                            <select name="annee_id" id="annee_id"
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all">
                                <option value="">Toutes les années</option>
                                @foreach ($annees as $annee)
                                    <option value="{{ $annee->id }}"
                                        {{ request('annee_id') == $annee->id ? 'selected' : '' }}>
                                        {{ $annee->libelle }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Bouton Filtrer -->
                        <div class="flex items-end gap-2">
                            <button type="submit"
                                class="flex-1 px-4 py-2.5 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-medium transition-all duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Filtrer
                            </button>
                            @if (request()->hasAny(['user_id', 'semestre', 'annee_id']))
                                <a href="{{ route('evaluations.index') }}"
                                    class="px-4 py-2.5 bg-muted hover:bg-muted/80 text-muted-foreground rounded-lg font-medium transition-all duration-200">
                                    Réinitialiser
                                </a>
                            @endif
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <!-- Tableau des évaluations -->
        <div class="bg-card border border-border rounded-lg shadow-sm overflow-hidden">

            @if ($evaluations->isEmpty())
                <!-- État vide -->
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-muted/50 rounded-full mb-4">
                        <svg class="w-8 h-8 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-foreground mb-2">Aucune évaluation trouvée</h3>
                    <p class="text-sm text-muted-foreground mb-6">
                        @if (request()->hasAny(['user_id', 'semestre', 'annee_id']))
                            Essayez de modifier vos critères de recherche.
                        @else
                            Commencez par créer une nouvelle évaluation.
                        @endif
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        @if (request()->hasAny(['user_id', 'semestre', 'annee_id']))
                            <a href="{{ route('evaluations.index') }}"
                                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-muted hover:bg-muted/80 text-muted-foreground rounded-lg font-medium transition-all duration-200">
                                Réinitialiser
                            </a>
                        @endif
                        <a href="{{ route('evaluations.create') }}"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-medium transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Créer une évaluation
                        </a>
                    </div>
                </div>
            @else
                <!-- Tableau -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-border bg-muted/30">
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wide">
                                    Étudiant</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wide">
                                    Module</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-semibold text-muted-foreground uppercase tracking-wide">
                                    Semestre</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-semibold text-muted-foreground uppercase tracking-wide">
                                    Note</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-semibold text-muted-foreground uppercase tracking-wide">
                                    Appréciation</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wide">
                                    Année</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-semibold text-muted-foreground uppercase tracking-wide">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach ($evaluations as $evaluation)
                                <tr class="hover:bg-muted/30 transition-colors duration-150">

                                    <!-- Étudiant -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0">
                                                @if ($evaluation->user->profile)
                                                    <img class="h-8 w-8 rounded-full object-cover border border-border"
                                                        src="{{ Storage::url($evaluation->user->profile) }}"
                                                        alt="{{ $evaluation->user->name }}">
                                                @else
                                                    <div
                                                        class="h-8 w-8 rounded-full bg-gradient-to-br from-primary/40 to-primary/20 flex items-center justify-center text-xs font-bold text-primary border border-primary/20">
                                                        {{ $evaluation->user->initials() }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-foreground">
                                                    {{ $evaluation->user->getFullName() }}</div>
                                                <div class="text-xs text-muted-foreground">
                                                    {{ $evaluation->user->matricule }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Module -->
                                    <td class="px-6 py-4">
                                        <div>
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary">
                                                {{ $evaluation->module->code }}
                                            </span>
                                            <div class="text-sm text-muted-foreground mt-1">
                                                {{ $evaluation->module->intitule }}</div>
                                        </div>
                                    </td>

                                    <!-- Semestre -->
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $evaluation->semestre == 1 ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                            S{{ $evaluation->semestre }}
                                        </span>
                                    </td>

                                    <!-- Note -->
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex flex-col items-center">
                                            <span
                                                class="text-lg font-bold {{ $evaluation->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ number_format($evaluation->note, 2) }}
                                            </span>
                                            <span class="text-xs text-muted-foreground">/20</span>
                                        </div>
                                    </td>

                                    <!-- Appréciation -->
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold 
                                        @if ($evaluation->note >= 16) bg-green-100 text-green-700
                                        @elseif($evaluation->note >= 14) bg-blue-100 text-blue-700
                                        @elseif($evaluation->note >= 12) bg-yellow-100 text-yellow-700
                                        @elseif($evaluation->note >= 10) bg-orange-100 text-orange-700
                                        @else bg-red-100 text-red-700 @endif">
                                            {{ $evaluation->getAppreciation() }}
                                        </span>
                                    </td>

                                    <!-- Année -->
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300">
                                            📅 {{ $evaluation->anneeAcademique->libelle }}
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-1">

                                            
                                        
                                           
                                            <!-- Voir -->
                                            <a href="{{ route('evaluations.show', $evaluation) }}"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-primary/10 hover:bg-primary/20 text-primary transition-all duration-200"
                                                title="Voir détails">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            <!-- Modifier -->
                                            <a href="{{ route('evaluations.edit', $evaluation) }}"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-100 hover:bg-blue-200 text-blue-700 transition-all duration-200"
                                                title="Modifier">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>

                                            <!-- Supprimer -->
                                            @if (auth()->user()->role->isAtLeast(\App\Enums\Role::ADMIN))
                                                <form action="{{ route('evaluations.destroy', $evaluation) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-100 hover:bg-red-200 text-red-700 transition-all duration-200"
                                                        title="Supprimer">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-border bg-muted/30">
                    {{ $evaluations->links() }}
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

            th,
            td {
                @apply px-3 py-2;
            }
        }
    </style>
@endpush
