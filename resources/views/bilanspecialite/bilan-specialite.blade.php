@extends('layouts.app')

@section('title', 'Bilan par Spécialité')

@section('content')
<div class="mb-6 flex justify-between items-center no-print">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">📈 Bilan par Spécialité</h1>
        <p class="mt-2 text-sm text-gray-700">
            Vue d'ensemble des performances académiques par spécialité
        </p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('bilan.specialite.comparaison', request()->all()) }}" class="btn btn-secondary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Comparaison
        </a>
        <button onclick="window.print()" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Imprimer
        </button>
        <a href="{{ route('bilan.specialite.export-pdf', request()->all()) }}" class="btn btn-success">
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
        <form method="GET" action="{{ route('bilan.specialite.index') }}" class="flex items-end space-x-4">
            <div class="flex-1">
                <label for="annee_id" class="block text-sm font-medium text-gray-700 mb-2">Année académique</label>
                <select name="annee_id" id="annee_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @foreach($annees as $annee)
                    <option value="{{ $annee->id }}" {{ request('annee_id', $anneeActive?->id) == $annee->id ? 'selected' : '' }}>
                        {{ $annee->libelle }} {{ $annee->is_active ? '⭐' : '' }}
                    </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filtrer
            </button>
        </form>
    </div>
</div>

<!-- Statistiques globales -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="card bg-gradient-to-br from-blue-500 to-blue-600 text-white">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Spécialités</p>
                    <p class="text-3xl font-bold">{{ $statsGlobales['total_specialites'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-gradient-to-br from-green-500 to-green-600 text-white">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Total Étudiants</p>
                    <p class="text-3xl font-bold">{{ $statsGlobales['total_etudiants'] }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-gradient-to-br from-purple-500 to-purple-600 text-white">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Taux d'Admission</p>
                    <p class="text-3xl font-bold">{{ number_format($statsGlobales['taux_admission'], 1) }}%</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-gradient-to-br from-yellow-500 to-yellow-600 text-white">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Moy. Générale</p>
                    <p class="text-3xl font-bold">{{ number_format($statsGlobales['moyenne_generale'], 2) }}/20</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tableau principal -->
<div class="card">
    <div class="card-header">
        <h2 class="text-xl font-semibold text-gray-900">📊 Tableau récapitulatif par spécialité</h2>
    </div>
    <div class="overflow-x-auto">
        @if($bilanParSpecialite->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune donnée</h3>
            <p class="mt-1 text-sm text-gray-500">Aucun bilan trouvé pour l'année sélectionnée.</p>
        </div>
        @else
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Spécialité
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Étudiants
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-blue-50">
                        Moy. S1
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-green-50">
                        Moy. S2
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-purple-50">
                        Moy. Compét.
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-yellow-50">
                        Moy. Gén.
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-green-100">
                        Admis
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-red-100">
                        Non Admis
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Taux Admission
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider no-print">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($bilanParSpecialite as $bilan)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-lg">{{ substr($bilan->specialite->code, 0, 2) }}</span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-gray-900">{{ $bilan->specialite->code }}</div>
                                <div class="text-xs text-gray-500">{{ $bilan->specialite->intitule }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                            {{ $bilan->total_etudiants }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center bg-blue-50">
                        <span class="text-base font-semibold {{ $bilan->moy_semestre1 >= 10 ? 'text-green-700' : 'text-red-700' }}">
                            {{ number_format($bilan->moy_semestre1, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center bg-green-50">
                        <span class="text-base font-semibold {{ $bilan->moy_semestre2 >= 10 ? 'text-green-700' : 'text-red-700' }}">
                            {{ number_format($bilan->moy_semestre2, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center bg-purple-50">
                        <span class="text-base font-semibold {{ $bilan->moy_competences >= 10 ? 'text-green-700' : 'text-red-700' }}">
                            {{ number_format($bilan->moy_competences, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center bg-yellow-50">
                        <span class="text-lg font-bold {{ $bilan->moyenne_generale >= 10 ? 'text-green-700' : 'text-red-700' }}">
                            {{ number_format($bilan->moyenne_generale, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center bg-green-100">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-200 text-green-800">
                            {{ $bilan->admis }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center bg-red-100">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-200 text-red-800">
                            {{ $bilan->non_admis }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="flex items-center justify-center">
                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                <div class="bg-gradient-to-r from-green-400 to-green-600 h-2 rounded-full transition-all" style="width: {{ $bilan->taux_admission }}%"></div>
                            </div>
                            <span class="text-sm font-semibold {{ $bilan->taux_admission >= 50 ? 'text-green-700' : 'text-red-700' }}">
                                {{ number_format($bilan->taux_admission, 1) }}%
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center no-print">
                        <a href="{{ route('bilan.specialite.show', ['specialite' => $bilan->specialite->id] + request()->all()) }}" 
                           class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Détails
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

<!-- Graphiques -->
<div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6 no-print">
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">📊 Moyennes générales par spécialité</h3>
        </div>
        <div class="card-body">
            <canvas id="moyennesChart"></canvas>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">📈 Taux d'admission par spécialité</h3>
        </div>
        <div class="card-body">
            <canvas id="admissionChart"></canvas>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const specialites = @json($bilanParSpecialite->pluck('specialite.code'));
    const moyennesGenerales = @json($bilanParSpecialite->pluck('moyenne_generale'));
    const tauxAdmission = @json($bilanParSpecialite->pluck('taux_admission'));
    
    // Graphique des moyennes
    const ctxMoyennes = document.getElementById('moyennesChart').getContext('2d');
    new Chart(ctxMoyennes, {
        type: 'bar',
        data: {
            labels: specialites,
            datasets: [{
                label: 'Moyenne Générale',
                data: moyennesGenerales,
                backgroundColor: 'rgba(59, 130, 246, 0.6)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 20,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    
    // Graphique des taux d'admission
    const ctxAdmission = document.getElementById('admissionChart').getContext('2d');
    new Chart(ctxAdmission, {
        type: 'line',
        data: {
            labels: specialites,
            datasets: [{
                label: 'Taux d\'Admission (%)',
                data: tauxAdmission,
                backgroundColor: 'rgba(34, 197, 94, 0.2)',
                borderColor: 'rgb(34, 197, 94)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: 'rgb(34, 197, 94)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>

<style>
    @media print {
        .no-print {
            display: none !important;
        }
        @page {
            size: landscape;
            margin: 1cm;
        }
        body {
            background: white;
        }
        .card {
            box-shadow: none;
            border: 1px solid #e5e7eb;
        }
    }
</style>
@endpush