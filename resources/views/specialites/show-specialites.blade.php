@extends('layouts.app')

@section('title', 'Détails de la spécialité')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('specialites.index') }}" class="text-blue-600 hover:text-blue-900 inline-flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour à la liste
    </a>
    <a href="{{ route('specialites.edit', $specialite) }}" class="btn btn-primary">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        Modifier
    </a>
</div>

<!-- En-tête de la spécialité -->
<div class="card mb-6">
    <div class="card-body">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-3">
                    <span class="inline-flex items-center justify-center h-16 w-16 rounded-lg bg-gradient-to-br from-blue-400 to-blue-600 text-white text-2xl font-bold">
                        {{ $specialite->code }}
                    </span>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $specialite->intitule }}</h1>
                        <p class="text-sm text-gray-500 mt-1">Code: {{ $specialite->code }}</p>
                    </div>
                </div>
                
                @if($specialite->description)
                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-700">{{ $specialite->description }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Statistiques -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <div class="card-body">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total étudiants</dt>
                        <dd class="flex items-baseline">
                            <div class="text-3xl font-semibold text-gray-900">{{ $stats['total_etudiants'] }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('users.index', ['specialite_id' => $specialite->id]) }}" class="text-sm text-blue-600 hover:text-blue-900">
                    Voir tous les étudiants →
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Étudiants actifs</dt>
                        <dd class="flex items-baseline">
                            <div class="text-3xl font-semibold text-gray-900">{{ $stats['etudiants_actifs'] }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">Taux d'activité</span>
                    <span class="font-semibold text-green-600">
                        {{ $stats['total_etudiants'] > 0 ? number_format(($stats['etudiants_actifs'] / $stats['total_etudiants']) * 100, 1) : 0 }}%
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Liste des étudiants -->
<div class="card">
    <div class="card-header flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">👨‍🎓 Étudiants de la spécialité</h2>
        <a href="{{ route('users.create') }}?specialite_id={{ $specialite->id }}" class="btn btn-sm btn-primary">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Ajouter
        </a>
    </div>
    <div class="card-body">
        @if($etudiants->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun étudiant</h3>
            <p class="mt-1 text-sm text-gray-500">Aucun étudiant n'est inscrit dans cette spécialité.</p>
            <div class="mt-6">
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    Ajouter un étudiant
                </a>
            </div>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Matricule</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom et Prénom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Niveau</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Année</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($etudiants as $etudiant)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">{{ $etudiant->matricule }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($etudiant->profile)
                                <img class="h-8 w-8 rounded-full object-cover mr-3" src="{{ Storage::url($etudiant->profile) }}" alt="{{ $etudiant->name }}">
                                @else
                                <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-xs font-semibold mr-3">
                                    {{ $etudiant->initials() }}
                                </div>
                                @endif
                                <div class="text-sm font-medium text-gray-900">{{ $etudiant->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="badge badge-secondary">{{ $etudiant->niveau->label() }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $etudiant->anneeAcademique->libelle }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('users.show', $etudiant) }}" class="text-blue-600 hover:text-blue-900 mr-3">Voir</a>
                            <a href="{{ route('evaluations.releve-notes', $etudiant) }}" class="text-purple-600 hover:text-purple-900">Relevé</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $etudiants->links() }}
        </div>
        @endif
    </div>
</div>
@endsection