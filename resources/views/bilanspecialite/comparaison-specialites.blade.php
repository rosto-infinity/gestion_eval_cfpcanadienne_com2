@extends('layouts.app')

@section('title', 'Comparaison des Spécialités')

@section('content')
<div class="mb-6 flex justify-between items-center no-print">
    <div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('bilan.specialite.index') }}" class="text-blue-600 hover:text-blue-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">📊 Comparaison des Spécialités</h1>
        </div>
        <p class="mt-2 text-sm text-gray-700">
            Analyse comparative des performances académiques
        </p>
    </div>
    <button onclick="window.print()" class="btn btn-primary">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
        </svg>
        Imprimer
    </button>
</div>

<!-- Filtres -->
<div class="card mb-6 no-print">
    <div class="card-body">
        <form method="GET" action="{{ route('bilan.specialite.comparaison') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="annee_id" class="block text-sm font-medium text-gray-700 mb-2">Année académique</label>
                    <select name="annee_id" id="annee_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @foreach($annees as $annee)
                        <option value="{{ $annee->id }}" {{ request('annee_id') == $annee->id ? 'selected' : '' }}>
                            {{ $annee->libelle }} {{ $annee->is_active ? '⭐' : '' }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Spécialités à comparer</label>
                    <div class="space-y-2 max-h-40 overflow-y-auto border rounded-md p-3 bg-gray-50">
                        @foreach($specialites as $specialite)
                        <label class="flex items-center">
                            <input type="checkbox" name="specialites[]" value="{{ $specialite->id }}" 
                                   {{ in_array($specialite->id, $specialiteIds ?? []) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">{{ $specialite->code }} - {{ $specialite->intitule }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Comparer
                </button>
            </div>
        </form>
    </div>
</div>

@if($bilanParSpecialite->isEmpty())
<div class="card">
    <div class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune spécialité sélectionnée</h3>
        <p class="mt-1 text-sm text-gray-500">Sélectionnez au moins une spécialité pour voir la comparaison.</p>
    </div>
</div>
@else

<!-- Graphiques de comparaison -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Graphique radar -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">🎯 Comparaison multi-critères</h3>
        </div>
        <div class="card-body">
            <canvas id="radarChart"></canvas>
        </div>
    </div>

    <!-- Graphique barres groupées -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">📊 Moyennes par semestre</h3>
        </div>
        <div class="card-body">
            <canvas id="barChart"></canvas>
        </div>
    </div>
</div>

<!-- Graphique linéaire taux admission -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="text-lg font-semibold text-gray-900">📈 Taux d'admission et moyennes générales</h3>
    </div>
    <div class="card-body">
        <canvas id="lineChart"></canvas>
    </div>
</div>

<!-- Tableau comparatif -->
<div class="card">
    <div class="card-header">
        <h3 class="text-lg font-semibold text-gray-900">📋 Tableau comparatif détaillé</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">
                        Spécialité
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase">
                        Étudiants
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase bg-blue-50">
                        Moy. S1
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase bg-green-50">
                        Moy. S2
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase bg-purple-50">
                        Moy. Compét.
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase bg-yellow-50">
                        Moy. Gén.
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase bg-green-100">
                        Admis
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase bg-orange-50">
                        Taux
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase">
                        Meilleure
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase">
                        Plus Basse
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($bilanParSpecialite as $bilan)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold">{{ substr($bilan->specialite->code, 0, 2) }}</span>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-bold text-gray-900">{{ $bilan->specialite->code }}</div>
                                <div class="text-xs text-gray-500">{{ Str::limit($bilan->specialite->intitule, 30) }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                            {{ $bilan->total_etudiants }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center bg-blue-50">
                        <span class="font-semibold {{ $bilan->moy_semestre1 >= 10 ? 'text-green-700' : 'text-red-700' }}">
                            {{ number_format($bilan->moy_semestre1, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center bg-green-50">
                        <span class="font-semibold {{ $bilan->moy_semestre2 >= 10 ? 'text-green-700' : 'text-red-700' }}">
                            {{ number_format($bilan->moy_semestre2, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center bg-purple-50">
                        <span class="font-semibold {{ $bilan->moy_competences >= 10 ? 'text-green-700' : 'text-red-700' }}">
                            {{ number_format($bilan->moy_competences, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center bg-yellow-50">
                        <span class="text-lg font-bold {{ $bilan->moyenne_generale >= 10 ? 'text-green-700' : 'text-red-700' }}">
                            {{ number_format($bilan->moyenne_generale, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center bg-green-100">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-200 text-green-800">
                            {{ $bilan->admis }}/{{ $bilan->total_etudiants }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center bg-orange-50">
                        <span class="font-semibold {{ $bilan->taux_admission >= 50 ? 'text-green-700' : 'text-red-700' }}">
                            {{ number_format($bilan->taux_admission, 1) }}%
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="text-sm font-semibold text-green-700">
                            {{ number_format($bilan->meilleure_moyenne, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="text-sm font-semibold text-red-700">
                            {{ number_format($bilan->moyenne_plus_basse, 2) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if($bilanParSpecialite->isNotEmpty())
    const specialites = @json($bilanParSpecialite->pluck('specialite.code'));
    const moyS1 = @json($bilanParSpecialite->pluck('moy_semestre1'));
    const moyS2 = @json($bilanParSpecialite->pluck('moy_semestre2'));
    const moyComp = @json($bilanParSpecialite->pluck('moy_competences'));
    const moyGen = @json($bilanParSpecialite->pluck('moyenne_generale'));
    const tauxAdmission = @json($bilanParSpecialite->pluck('taux_admission'));

    const colors = [
        'rgba(59, 130, 246, 0.8)',    // Bleu
        'rgba(34, 197, 94, 0.8)',     // Vert
        'rgba(168, 85, 247, 0.8)',    // Violet
        'rgba(251, 146, 60, 0.8)',    // Orange
        'rgba(236, 72, 153, 0.8)',    // Rose
        'rgba(14, 165, 233, 0.8)',    // Cyan
    ];

    // Graphique Radar
    const ctxRadar = document.getElementById('radarChart').getContext('2d');
    new Chart(ctxRadar, {
        type: 'radar',
        data: {
            labels: ['Semestre 1', 'Semestre 2', 'Compétences', 'Moy. Générale', 'Taux Admission'],
            datasets: specialites.map((spec, index) => ({
                label: spec,
                data: [
                    moyS1[index],
                    moyS2[index],
                    moyComp[index],
                    moyGen[index],
                    tauxAdmission[index] / 5 // Normaliser sur 20
                ],
                backgroundColor: colors[index % colors.length].replace('0.8', '0.2'),
                borderColor: colors[index % colors.length],
                borderWidth: 2,
                pointBackgroundColor: colors[index % colors.length]
            }))
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                r: {
                    beginAtZero: true,
                    max: 20
                }
            }
        }
    });

    // Graphique barres groupées
    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: specialites,
            datasets: [
                {
                    label: 'Semestre 1',
                    data: moyS1,
                    backgroundColor: 'rgba(59, 130, 246, 0.6)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1
                },
                {
                    label: 'Semestre 2',
                    data: moyS2,
                    backgroundColor: 'rgba(34, 197, 94, 0.6)',
                    borderColor: 'rgb(34, 197, 94)',
                    borderWidth: 1
                },
                {
                    label: 'Compétences',
                    data: moyComp,
                    backgroundColor: 'rgba(168, 85, 247, 0.6)',
                    borderColor: 'rgb(168, 85, 247)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 20
                }
            }
        }
    });

    // Graphique linéaire
    const ctxLine = document.getElementById('lineChart').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: specialites,
            datasets: [
                {
                    label: 'Moyenne Générale',
                    data: moyGen,
                    borderColor: 'rgb(234, 179, 8)',
                    backgroundColor: 'rgba(234, 179, 8, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    yAxisID: 'y'
                },
                {
                    label: 'Taux d\'Admission (%)',
                    data: tauxAdmission,
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Moyenne Générale (/20)'
                    },
                    beginAtZero: true,
                    max: 20
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Taux d\'Admission (%)'
                    },
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });
    @endif
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
    }
</style>
@endpush