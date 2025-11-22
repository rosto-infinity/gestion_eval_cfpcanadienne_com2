@extends('layouts.app')

@section('title', 'Tableau Récapitulatif des Résultats')

@section('content')
<div class="mb-6 flex justify-between items-center no-print">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">📊 Tableau Récapitulatif des Résultats</h1>
        <p class="mt-2 text-sm text-gray-700">Classement général des étudiants par moyenne</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('bilans.index') }}" class="btn btn-secondary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Retour
        </a>
        <button onclick="window.print()" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Imprimer
        </button>
        <a href="{{ route('bilans.tableau-recapitulatif.export-pdf', request()->all()) }}" class="btn btn-success">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Exporter PDF
        </a>
    </div>
</div>

<!-- Filtres -->
<div class="card mb-6 no-print">
    <div class="card-body">
        <form method="GET" action="{{ route('bilans.tableau-recapitulatif') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="annee_id" class="block text-sm font-medium text-gray-700 mb-2">Année académique</label>
                <select name="annee_id" id="annee_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @foreach($annees as $annee)
                    <option value="{{ $annee->id }}" {{ request('annee_id', optional($annees->where('is_active', true)->first())->id) == $annee->id ? 'selected' : '' }}>
                        {{ $annee->libelle }} {{ $annee->is_active ? '⭐ (Active)' : '' }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="specialite_id" class="block text-sm font-medium text-gray-700 mb-2">Spécialité</label>
                <select name="specialite_id" id="specialite_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Toutes les spécialités</option>
                    @foreach($specialites as $specialite)
                    <option value="{{ $specialite->id }}" {{ request('specialite_id') == $specialite->id ? 'selected' : '' }}>
                        {{ $specialite->code }} - {{ $specialite->intitule }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="btn btn-primary w-full">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filtrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Statistiques générales -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total étudiants</dt>
                        <dd class="text-2xl font-semibold text-gray-900">{{ $stats['total'] }}</dd>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Admis</dt>
                        <dd class="text-2xl font-semibold text-green-600">{{ $stats['admis'] }}</dd>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Moy. générale</dt>
                        <dd class="text-2xl font-semibold text-blue-600">
                            {{ $stats['moyenne_generale'] ? number_format($stats['moyenne_generale'], 2) : '-' }}
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
                    <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Meilleure note</dt>
                        <dd class="text-2xl font-semibold text-green-500">
                            {{ $stats['meilleure_moyenne'] ? number_format($stats['meilleure_moyenne'], 2) : '-' }}
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
                    <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Note la plus basse</dt>
                        <dd class="text-2xl font-semibold text-red-500">
                            {{ $stats['moyenne_la_plus_basse'] ? number_format($stats['moyenne_la_plus_basse'], 2) : '-' }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Graphique de répartition -->
@if($stats['total'] > 0)
<div class="card mb-6 no-print">
    <div class="card-header">
        <h2 class="text-xl font-semibold text-gray-800">📈 Répartition des résultats</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Taux de réussite -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Taux de réussite</span>
                    <span class="text-sm font-bold text-green-600">
                        {{ number_format(($stats['admis'] / $stats['total']) * 100, 1) }}%
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="bg-green-500 h-4 rounded-full" style="width: {{ ($stats['admis'] / $stats['total']) * 100 }}%"></div>
                </div>
                <div class="flex justify-between mt-2 text-xs text-gray-600">
                    <span>{{ $stats['admis'] }} admis</span>
                    <span>{{ $stats['total'] - $stats['admis'] }} ajournés</span>
                </div>
            </div>

            <!-- Distribution des moyennes -->
            <div>
                @php
                    $excellent = $bilans->filter(fn($b) => $b->moyenne_generale >= 16)->count();
                    $tresBien = $bilans->filter(fn($b) => $b->moyenne_generale >= 14 && $b->moyenne_generale < 16)->count();
                    $bien = $bilans->filter(fn($b) => $b->moyenne_generale >= 12 && $b->moyenne_generale < 14)->count();
                    $passable = $bilans->filter(fn($b) => $b->moyenne_generale >= 10 && $b->moyenne_generale < 12)->count();
                    $insuffisant = $bilans->filter(fn($b) => $b->moyenne_generale < 10)->count();
                @endphp
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-700">Excellent (≥16)</span>
                        <span class="font-semibold text-green-600">{{ $excellent }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-700">Très bien (14-16)</span>
                        <span class="font-semibold text-blue-600">{{ $tresBien }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-700">Bien (12-14)</span>
                        <span class="font-semibold text-indigo-600">{{ $bien }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-700">Passable (10-12)</span>
                        <span class="font-semibold text-yellow-600">{{ $passable }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-700">Insuffisant (<10)</span>
                        <span class="font-semibold text-red-600">{{ $insuffisant }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Tableau des résultats -->
<div class="card" id="tableau-resultats">
    <div class="card-header bg-gradient-to-r from-blue-600 to-purple-600 text-white">
        <h2 class="text-xl font-semibold">🏆 Classement des étudiants</h2>
    </div>
    <div class="card-body">
        @if($bilans->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun résultat</h3>
            <p class="mt-1 text-sm text-gray-500">Aucun bilan de compétences n'a été trouvé avec les critères sélectionnés.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rang</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Matricule</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom et Prénom</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Spécialité</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">S1</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">S2</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Éval (30%)</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Comp (70%)</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Moy. Gén.</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Mention</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($bilans as $index => $bilan)
                    <tr class="hover:bg-gray-50 {{ $index < 3 ? 'bg-yellow-50' : '' }}">
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center">
                                @if($index === 0)
                                <span class="text-3xl" title="1ère place">🥇</span>
                                @elseif($index === 1)
                                <span class="text-3xl" title="2ème place">🥈</span>
                                @elseif($index === 2)
                                <span class="text-3xl" title="3ème place">🥉</span>
                                @else
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-sm font-semibold text-gray-700">
                                    {{ $index + 1 }}
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">{{ $bilan->user->matricule }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                @if($bilan->user->profile)
                                <img class="h-8 w-8 rounded-full object-cover mr-2 no-print" src="{{ Storage::url($bilan->user->profile) }}" alt="{{ $bilan->user->name }}">
                                @endif
                                <span class="text-sm font-medium text-gray-900">{{ $bilan->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $bilan->user->specialite->code }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm">
                            {{ $bilan->moy_eval_semestre1 ? number_format($bilan->moy_eval_semestre1, 2) : '-' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm">
                            {{ $bilan->moy_eval_semestre2 ? number_format($bilan->moy_eval_semestre2, 2) : '-' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                            {{ $bilan->moy_evaluations ? number_format($bilan->moy_evaluations, 2) : '-' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                            {{ $bilan->moy_competences ? number_format($bilan->moy_competences, 2) : '-' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <span class="text-lg font-bold {{ $bilan->moyenne_generale >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($bilan->moyenne_generale, 2) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $bilan->isAdmis() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $bilan->getMention() }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <!-- Footer du tableau -->
    @if(!$bilans->isEmpty())
    <div class="card-body bg-gray-50 border-t text-center text-sm text-gray-600">
        <p>Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
        <p class="mt-1">Total: {{ $bilans->count() }} étudiant(s) • Admis: {{ $stats['admis'] }} • Taux de réussite: {{ number_format(($stats['admis'] / $stats['total']) * 100, 1) }}%</p>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        .card {
            break-inside: avoid;
            box-shadow: none;
            border: 1px solid #e5e7eb;
        }
        body {
            background: white;
        }
        @page {
            size: landscape;
            margin: 1cm;
        }
    }
</style>
@endpush