@extends('layouts.app')

@section('title', 'Années Académiques')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- En-tête -->
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Années Académiques</h1>
            <p class="mt-2 text-sm text-gray-700">Gestion des périodes scolaires</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('annees.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouvelle Année
            </a>
        </div>
    </div>

    <!-- Info année active -->
    @php
        $activeYear = $annees->firstWhere('is_active', true);
    @endphp
    @if($activeYear)
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-medium text-green-800">
                    Année Académique Active: <span class="font-bold">{{ $activeYear->libelle }}</span>
                </p>
                <p class="text-xs text-green-700 mt-1">
                    Du {{ $activeYear->date_debut->format('d/m/Y') }} au {{ $activeYear->date_fin->format('d/m/Y') }}
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Tableau des années -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Libellé</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Période</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    {{-- <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Étudiants</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Évaluations</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Bilans</th> --}}
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($annees as $annee)
                <tr class="hover:bg-gray-50 {{ $annee->is_active ? 'bg-green-50' : '' }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($annee->is_active)
                                <span class="text-2xl mr-2">⭐</span>
                            @endif
                            <div>
                                <div class="text-sm font-bold text-gray-900">{{ $annee->libelle }}</div>
                                @if($annee->is_active)
                                    <span class="text-xs text-green-600 font-medium">Année en cours</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            <div>📅 {{ $annee->date_debut->format('d/m/Y') }}</div>
                            <div class="text-gray-500">→ {{ $annee->date_fin->format('d/m/Y') }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if($annee->is_active)
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Inactive
                            </span>
                        @endif
                    </td>
                    {{-- <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $annee->users_count }} étudiant(s)
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                            {{ $annee->evaluations_count }} éval(s)
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                            {{ $annee->bilans_competences_count }} bilan(s)
                        </span>
                    </td> --}}
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            @if(!$annee->is_active)
                                <form action="{{ route('annees.activate', $annee) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900 font-medium">
                                        Activer
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('annees.show', $annee) }}" class="text-indigo-600 hover:text-indigo-900">Voir</a>
                            <a href="{{ route('annees.edit', $annee) }}" class="text-yellow-600 hover:text-yellow-900">Modifier</a>
                            @if(!$annee->is_active)
                                <form action="{{ route('annees.destroy', $annee) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-500 text-lg">Aucune année académique trouvée</p>
                            <a href="{{ route('annees.create') }}" class="mt-4 text-indigo-600 hover:text-indigo-900">Créer la première année</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $annees->links() }}
    </div>

    <!-- Information importante -->
    <div class="mt-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    <strong>Note importante:</strong> Une seule année peut être active à la fois. L'activation d'une nouvelle année désactivera automatiquement l'année précédente.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection