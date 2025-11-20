@extends('layouts.app')

@section('title', 'Détails de l\'année académique')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('annees.index') }}" class="text-blue-600 hover:text-blue-900 inline-flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour à la liste
    </a>
    <div class="flex space-x-3">
        @if(!$annee->is_active)
        <form action="{{ route('annees.activate', $annee) }}" method="POST" onsubmit="return confirm('Activer cette année académique ?');">
            @csrf
            <button type="submit" class="btn btn-success">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Activer
            </button>
        </form>
        @endif
        <a href="{{ route('annees.edit', $annee) }}" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Modifier
        </a>
    </div>
</div>

<!-- En-tête de l'année -->
<div class="card mb-6">
    <div class="card-body">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $annee->libelle }}</h1>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm">
                            Du {{ $annee->date_debut->format('d/m/Y') }} au {{ $annee->date_fin->format('d/m/Y') }}
                        </span>
                    </div>
                    <div>
                        @if($annee->is_active)
                        <span class="badge badge-success text-base px-4 py-2">✓ Année Active</span>
                        @else
                        <span class="badge badge-secondary text-base px-4 py-2">Inactive</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Durée</p>
                <p class="text-2xl font-bold text-gray-900">
                    {{ $annee->date_debut->diffInDays($annee->date_fin) }} jours
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Statistiques -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
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
                        <dt class="text-sm font-medium text-gray-500 truncate">Étudiants inscrits</dt>
                        <dd class="flex items-baseline">
                            <div class="text-3xl font-semibold text-gray-900">{{ $stats['total_etudiants'] }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('users.index', ['annee_id' => $annee->id]) }}" class="text-sm text-blue-600 hover:text-blue-900">
                    Voir les étudiants →
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Évaluations enregistrées</dt>
                        <dd class="flex items-baseline">
                            <div class="text-3xl font-semibold text-gray-900">{{ $stats['total_evaluations'] }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('evaluations.index', ['annee_id' => $annee->id]) }}" class="text-sm text-green-600 hover:text-green-900">
                    Voir les évaluations →
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Bilans de compétences</dt>
                        <dd class="flex items-baseline">
                            <div class="text-3xl font-semibold text-gray-900">{{ $stats['total_bilans'] }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('bilans.index', ['annee_id' => $annee->id]) }}" class="text-sm text-purple-600 hover:text-purple-900">
                    Voir les bilans →
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Timeline de progression -->
<div class="card mb-6">
    <div class="card-header">
        <h2 class="text-xl font-semibold text-gray-800">📅 Progression de l'année</h2>
    </div>
    <div class="card-body">
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
                'À venir' => 'bg-blue-500',
                'En cours' => 'bg-green-500',
                'Terminée' => 'bg-gray-500',
            };
        @endphp

        <div class="mb-4">
            <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>{{ $annee->date_debut->format('d/m/Y') }}</span>
                <span class="font-semibold">{{ $status }} - {{ number_format($progress, 1) }}%</span>
                <span>{{ $annee->date_fin->format('d/m/Y') }}</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="{{ $statusColor }} h-4 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600">Jours écoulés</p>
                <p class="text-2xl font-bold text-gray-900">{{ $elapsedDays }}</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600">Jours restants</p>
                <p class="text-2xl font-bold text-gray-900">{{ max(0, $totalDays - $elapsedDays) }}</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600">Durée totale</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalDays }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Actions rapides -->
<div class="card">
    <div class="card-header">
        <h2 class="text-xl font-semibold text-gray-800">⚡ Actions rapides</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('users.create') }}" class="p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all text-center group">
                <svg class="w-8 h-8 mx-auto text-gray-400 group-hover:text-blue-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <p class="text-sm font-medium text-gray-700 group-hover:text-blue-700">Ajouter un étudiant</p>
            </a>

            <a href="{{ route('evaluations.saisir-multiple') }}" class="p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-500 hover:bg-green-50 transition-all text-center group">
                <svg class="w-8 h-8 mx-auto text-gray-400 group-hover:text-green-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <p class="text-sm font-medium text-gray-700 group-hover:text-green-700">Saisir des notes</p>
            </a>

            <a href="{{ route('bilans.create') }}" class="p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-all text-center group">
                <svg class="w-8 h-8 mx-auto text-gray-400 group-hover:text-purple-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-sm font-medium text-gray-700 group-hover:text-purple-700">Créer un bilan</p>
            </a>

            <a href="{{ route('bilans.tableau-recapitulatif', ['annee_id' => $annee->id]) }}" class="p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-orange-500 hover:bg-orange-50 transition-all text-center group">
                <svg class="w-8 h-8 mx-auto text-gray-400 group-hover:text-orange-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <p class="text-sm font-medium text-gray-700 group-hover:text-orange-700">Voir les résultats</p>
            </a>
        </div>
    </div>
</div>
@endsection