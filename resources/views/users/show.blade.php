@extends('layouts.app')

@section('title', 'Détails de l\'étudiant')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('users.index') }}" class="text-blue-600 hover:text-blue-900 inline-flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour à la liste
    </a>
    <div class="flex space-x-3">
        <a href="{{ route('evaluations.saisir-multiple', ['user_id' => $user->id]) }}" class="btn btn-success">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Saisir notes
        </a>
        <a href="{{ route('evaluations.releve-notes', $user) }}" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Relevé de notes
        </a>
        <a href="{{ route('users.edit', $user) }}" class="btn btn-secondary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
            Modifier
        </a>
    </div>
</div>

<!-- Informations de l'étudiant -->
<div class="card mb-6">
    <div class="card-body">
        <div class="flex items-start space-x-6">
            <!-- Photo de profil -->
            <div class="flex-shrink-0">
                @if($user->profile)
                <img class="h-32 w-32 rounded-full object-cover border-4 border-blue-200" src="{{ Storage::url($user->profile) }}" alt="{{ $user->name }}">
                @else
                <div class="h-32 w-32 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-4xl font-bold border-4 border-blue-200">
                    {{ $user->initials() }}
                </div>
                @endif
            </div>

            <!-- Informations -->
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $user->name }}</h1>
                <div class="flex items-center space-x-4 mb-4">
                    <span class="badge {{ $user->sexe === 'M' ? 'badge-info' : 'badge-danger' }}">
                        {{ $user->sexe === 'M' ? '👨 Masculin' : '👩 Féminin' }}
                    </span>
                    <span class="badge badge-secondary">{{ $user->niveau->label() }}</span>
                    @if($user->bilanCompetence)
                    <span class="badge {{ $user->bilanCompetence->isAdmis() ? 'badge-success' : 'badge-danger' }}">
                        {{ $user->bilanCompetence->getMention() }}
                    </span>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <div>
                        <p class="text-sm text-gray-500">Matricule</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $user->matricule }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Spécialité</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $user->specialite->intitule }}
                            <span class="text-sm text-gray-500">({{ $user->specialite->code }})</span>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Année académique</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $user->anneeAcademique->libelle }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Niveau d'études</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $user->niveau->label() }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Inscription</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $user->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistiques -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total évaluations</dt>
                        <dd class="text-2xl font-semibold text-gray-900">{{ $stats['total_evaluations'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Moyenne Semestre 1</dt>
                        <dd class="text-2xl font-semibold {{ $stats['moyenne_semestre1'] && $stats['moyenne_semestre1'] >= 10 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $stats['moyenne_semestre1'] ? number_format($stats['moyenne_semestre1'], 2) : '-' }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Moyenne Semestre 2</dt>
                        <dd class="text-2xl font-semibold {{ $stats['moyenne_semestre2'] && $stats['moyenne_semestre2'] >= 10 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $stats['moyenne_semestre2'] ? number_format($stats['moyenne_semestre2'], 2) : '-' }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Bilan de compétences</dt>
                        <dd class="text-lg font-semibold text-gray-900">
                            @if($stats['has_bilan'])
                            <span class="badge badge-success">✓ Complété</span>
                            @else
                            <span class="badge badge-warning">En attente</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bilan de compétences -->
@if($user->bilanCompetence)
<div class="card mb-6">
    <div class="card-header">
        <h2 class="text-xl font-semibold text-gray-800">🎯 Bilan de Compétences</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <p class="text-sm text-gray-600 mb-1">Moyenne Évaluations</p>
                <p class="text-3xl font-bold text-blue-600">
                    {{ number_format($user->bilanCompetence->moy_evaluations, 2) }}
                </p>
                <p class="text-xs text-gray-500 mt-1">30% de la note finale</p>
            </div>
            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <p class="text-sm text-gray-600 mb-1">Bilan Compétences</p>
                <p class="text-3xl font-bold text-purple-600">
                    {{ number_format($user->bilanCompetence->moy_competences, 2) }}
                </p>
                <p class="text-xs text-gray-500 mt-1">70% de la note finale</p>
            </div>
            <div class="text-center p-4 {{ $user->bilanCompetence->isAdmis() ? 'bg-green-50' : 'bg-red-50' }} rounded-lg col-span-2">
                <p class="text-sm text-gray-600 mb-1">MOYENNE GÉNÉRALE</p>
                <p class="text-5xl font-bold {{ $user->bilanCompetence->isAdmis() ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format($user->bilanCompetence->moyenne_generale, 2) }}
                </p>
                <p class="text-lg font-semibold mt-2">
                    <span class="badge {{ $user->bilanCompetence->isAdmis() ? 'badge-success' : 'badge-danger' }}">
                        {{ $user->bilanCompetence->getMention() }}
                    </span>
                </p>
            </div>
        </div>

        @if($user->bilanCompetence->observations)
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <p class="text-sm font-medium text-gray-700 mb-2">Observations :</p>
            <p class="text-sm text-gray-600">{{ $user->bilanCompetence->observations }}</p>
        </div>
        @endif

        <div class="mt-6 flex justify-end">
            <a href="{{ route('bilans.show', $user->bilanCompetence) }}" class="btn btn-primary">
                Voir le bilan complet
            </a>
        </div>
    </div>
</div>
@else
<div class="card mb-6">
    <div class="card-body text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun bilan de compétences</h3>
        <p class="mt-1 text-sm text-gray-500">Créez un bilan de compétences pour cet étudiant.</p>
        <div class="mt-6">
            <a href="{{ route('bilans.create', ['user_id' => $user->id]) }}" class="btn btn-primary">
                Créer un bilan
            </a>
        </div>
    </div>
</div>
@endif

<!-- Liste des évaluations récentes -->
<div class="card">
    <div class="card-header">
        <h2 class="text-xl font-semibold text-gray-800">📝 Évaluations récentes</h2>
    </div>
    <div class="card-body">
        @if($user->evaluations->isEmpty())
        <p class="text-center text-gray-500 py-8">Aucune évaluation enregistrée</p>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Module</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Semestre</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Note</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Appréciation</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($user->evaluations->sortByDesc('created_at')->take(10) as $eval)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <span class="badge {{ $eval->semestre == 1 ? 'badge-info' : 'badge-success' }} mr-2">
                                    {{ $eval->module->code }}
                                </span>
                                <span class="text-sm text-gray-900">{{ $eval->module->intitule }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm text-gray-900">S{{ $eval->semestre }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-lg font-bold {{ $eval->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($eval->note, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="badge {{ $eval->note >= 10 ? 'badge-success' : 'badge-danger' }}">
                                {{ $eval->getAppreciation() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $eval->created_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection