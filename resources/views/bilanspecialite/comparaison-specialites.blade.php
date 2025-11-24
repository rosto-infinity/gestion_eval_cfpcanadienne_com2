@extends('layouts.app')

@section('title', 'Comparaison des Spécialités')

@section('content')
<div class="min-h-screen" style="background-color: var(--background)">
    <!-- En-tête avec navigation -->
    <div class="mb-8 flex justify-between items-center no-print">
        <div>
            <div class="flex items-center space-x-4">
                <a 
                    href="{{ route('bilan.specialite.index') }}" 
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg transition-all duration-200 hover:shadow-md"
                    style="color: var(--primary); background-color: var(--secondary)"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="font-medium">Retour</span>
                </a>
                
                <div>
                    <h1 class="text-3xl font-bold" style="color: var(--foreground)">
                        📊 Comparaison des Spécialités
                    </h1>
                    <p class="mt-2 text-sm" style="color: var(--muted-foreground)">
                        Analyse comparative des performances académiques
                    </p>
                </div>
            </div>
        </div>
        
        <button 
            onclick="window.print()" 
            class="inline-flex items-center gap-2 px-6 py-2 rounded-lg font-semibold transition-all duration-200 hover:shadow-lg active:scale-95"
            style="background-color: var(--primary); color: var(--primary-foreground)"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Imprimer
        </button>
    </div>

    <!-- Filtres -->
    <div class="mb-6 rounded-xl border-2 overflow-hidden transition-all duration-200 hover:shadow-md no-print" style="background-color: var(--card); border-color: var(--border)">
        <div class="p-6">
            <form method="GET" action="{{ route('bilan.specialite.comparaison') }}" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Année académique -->
                    <div>
                        <label for="annee_id" class="block text-sm font-semibold mb-3" style="color: var(--foreground)">
                            📅 Année académique
                        </label>
                        <select 
                            name="annee_id" 
                            id="annee_id" 
                            class="w-full px-4 py-2.5 rounded-lg border-2 transition-all duration-200"
                            style="background-color: var(--background); border-color: var(--border); color: var(--foreground)"
                        >
                            @foreach($annees as $annee)
                            <option value="{{ $annee->id }}" {{ request('annee_id') == $annee->id ? 'selected' : '' }}>
                                {{ $annee->libelle }} {{ $annee->is_active ? '⭐' : '' }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Spécialités à comparer -->
                    <div>
                        <label class="block text-sm font-semibold mb-3" style="color: var(--foreground)">
                            🎓 Spécialités à comparer
                        </label>
                        <div 
                            class="space-y-2 max-h-48 overflow-y-auto border-2 rounded-lg p-4"
                            style="background-color: var(--background); border-color: var(--border)"
                        >
                            @foreach($specialites as $specialite)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input 
                                    type="checkbox" 
                                    name="specialites[]" 
                                    value="{{ $specialite->id }}" 
                                    {{ in_array($specialite->id, $specialiteIds ?? []) ? 'checked' : '' }}
                                    class="w-4 h-4 rounded transition-all duration-200"
                                    style="accent-color: var(--primary)"
                                >
                                <span 
                                    class="text-sm font-medium transition-all duration-200 group-hover:opacity-75"
                                    style="color: var(--foreground)"
                                >
                                    {{ $specialite->code }} - {{ $specialite->intitule }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t-2" style="border-color: var(--border)">
                    <button 
                        type="submit" 
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg font-semibold transition-all duration-200 hover:shadow-lg active:scale-95"
                        style="background-color: var(--primary); color: var(--primary-foreground)"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Comparer
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($bilanParSpecialite->isEmpty())
    <!-- État vide -->
    <div class="rounded-xl border-2 overflow-hidden" style="background-color: var(--card); border-color: var(--border)">
        <div class="text-center py-16 px-6">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4" style="background-color: var(--secondary)">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--muted-foreground)">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold mb-2" style="color: var(--foreground)">
                Aucune spécialité sélectionnée
            </h3>
            <p class="text-sm" style="color: var(--muted-foreground)">
                Sélectionnez au moins une spécialité pour voir la comparaison.
            </p>
        </div>
    </div>

    @else
    <!-- Graphiques de comparaison -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Graphique radar -->
        <div class="rounded-xl border-2 overflow-hidden transition-all duration-200 hover:shadow-md" style="background-color: var(--card); border-color: var(--border)">
            <div class="p-6 border-b-2" style="border-color: var(--border)">
                <h3 class="text-lg font-bold flex items-center gap-2" style="color: var(--foreground)">
                    <span style="color: var(--primary)">🎯</span>
                    Comparaison multi-critères
                </h3>
            </div>
            <div class="p-6">
                <canvas id="radarChart"></canvas>
            </div>
        </div>

        <!-- Graphique barres groupées -->
        <div class="rounded-xl border-2 overflow-hidden transition-all duration-200 hover:shadow-md" style="background-color: var(--card); border-color: var(--border)">
            <div class="p-6 border-b-2" style="border-color: var(--border)">
                <h3 class="text-lg font-bold flex items-center gap-2" style="color: var(--foreground)">
                    <span style="color: var(--primary)">📊</span>
                    Moyennes par semestre
                </h3>
            </div>
            <div class="p-6">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Graphique linéaire taux admission -->
    <div class="rounded-xl border-2 overflow-hidden transition-all duration-200 hover:shadow-md mb-6" style="background-color: var(--card); border-color: var(--border)">
        <div class="p-6 border-b-2" style="border-color: var(--border)">
            <h3 class="text-lg font-bold flex items-center gap-2" style="color: var(--foreground)">
                <span style="color: var(--primary)">📈</span>
                Taux d'admission et moyennes générales
            </h3>
        </div>
        <div class="p-6">
            <canvas id="lineChart"></canvas>
        </div>
    </div>

    <!-- Tableau comparatif -->
    <div class="rounded-xl border-2 overflow-hidden transition-all duration-200 hover:shadow-md" style="background-color: var(--card); border-color: var(--border)">
        <div class="p-6 border-b-2" style="border-color: var(--border)">
            <h3 class="text-lg font-bold flex items-center gap-2" style="color: var(--foreground)">
                <span style="color: var(--primary)">📋</span>
                Tableau comparatif détaillé
            </h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border)">
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--muted-foreground)">
                            Spécialité
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider" style="color: var(--muted-foreground)">
                            Étudiants
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider" style="color: var(--muted-foreground); background-color: var(--secondary)">
                            Moy. S1
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider" style="color: var(--muted-foreground); background-color: var(--secondary)">
                            Moy. S2
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider" style="color: var(--muted-foreground); background-color: var(--secondary)">
                            Moy. Compét.
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider" style="color: var(--primary); background-color: var(--secondary); font-weight: 900">
                            Moy. Gén.
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider" style="color: var(--muted-foreground); background-color: var(--secondary)">
                            Admis
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider" style="color: var(--primary); background-color: var(--secondary); font-weight: 900">
                            Taux %
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider" style="color: var(--muted-foreground)">
                            Meilleure
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider" style="color: var(--muted-foreground)">
                            Plus Basse
                        </th>
                    </tr>
                </thead>
                <tbody style="border-color: var(--border)">
                    @foreach($bilanParSpecialite as $index => $bilan)
                    <tr class="border-b transition-all duration-200 hover:opacity-75" style="border-color: var(--border)">
                        <!-- Spécialité -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div 
                                    class="h-10 w-10 rounded-lg flex items-center justify-center text-xs font-bold text-white"
                                    style="background: linear-gradient(135deg, var(--primary), var(--primary))"
                                >
                                    {{ strtoupper(substr($bilan->specialite->code, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold" style="color: var(--foreground)">
                                        {{ $bilan->specialite->code }}
                                    </p>
                                    <p class="text-xs" style="color: var(--muted-foreground)">
                                        {{ Str::limit($bilan->specialite->intitule, 25) }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <!-- Total Étudiants -->
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span 
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold"
                                style="background-color: var(--secondary); color: var(--primary)"
                            >
                                {{ $bilan->total_etudiants }}
                            </span>
                        </td>

                        <!-- Moy. S1 -->
                        <td class="px-6 py-4 whitespace-nowrap text-center" style="background-color: var(--secondary)">
                            <span 
                                class="font-bold text-sm"
                                style="color: {{ $bilan->moy_semestre1 >= 10 ? 'var(--primary)' : '#ef4444' }}"
                            >
                                {{ number_format($bilan->moy_semestre1, 2) }}
                            </span>
                        </td>

                        <!-- Moy. S2 -->
                        <td class="px-6 py-4 whitespace-nowrap text-center" style="background-color: var(--secondary)">
                            <span 
                                class="font-bold text-sm"
                                style="color: {{ $bilan->moy_semestre2 >= 10 ? 'var(--primary)' : '#ef4444' }}"
                            >
                                {{ number_format($bilan->moy_semestre2, 2) }}
                            </span>
                        </td>

                        <!-- Moy. Compétences -->
                        <td class="px-6 py-4 whitespace-nowrap text-center" style="background-color: var(--secondary)">
                            <span 
                                class="font-bold text-sm"
                                style="color: {{ $bilan->moy_competences >= 10 ? 'var(--primary)' : '#ef4444' }}"
                            >
                                {{ number_format($bilan->moy_competences, 2) }}
                            </span>
                        </td>

                        <!-- Moy. Générale (Mise en avant) -->
                        <td class="px-6 py-4 whitespace-nowrap text-center" style="background-color: var(--secondary)">
                            <span 
                                class="text-lg font-black"
                                style="color: {{ $bilan->moyenne_generale >= 10 ? 'var(--primary)' : '#ef4444' }}"
                            >
                                {{ number_format($bilan->moyenne_generale, 2) }}
                            </span>
                        </td>

                        <!-- Admis -->
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span 
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold"
                                style="background-color: var(--secondary); color: var(--primary)"
                            >
                                {{ $bilan->admis }}/{{ $bilan->total_etudiants }}
                            </span>
                        </td>

                        <!-- Taux Admission (Mise en avant) -->
                        <td class="px-6 py-4 whitespace-nowrap text-center" style="background-color: var(--secondary)">
                            <span 
                                class="font-black text-sm"
                                style="color: {{ $bilan->taux_admission >= 50 ? 'var(--primary)' : '#ef4444' }}"
                            >
                                {{ number_format($bilan->taux_admission, 1) }}%
                            </span>
                        </td>

                        <!-- Meilleure Note -->
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span 
                                class="text-sm font-bold"
                                style="color: var(--primary)"
                            >
                                {{ number_format($bilan->meilleure_moyenne, 2) }}
                            </span>
                        </td>

                        <!-- Plus Basse Note -->
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span 
                                class="text-sm font-bold"
                                style="color: #ef4444"
                            >
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
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if($bilanParSpecialite->isNotEmpty())
    const primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--primary').trim();
    const secondaryColor = getComputedStyle(document.documentElement).getPropertyValue('--secondary').trim();
    const mutedColor = getComputedStyle(document.documentElement).getPropertyValue('--muted-foreground').trim();
    
    const specialites = @json($bilanParSpecialite->pluck('specialite.code'));
    const moyS1 = @json($bilanParSpecialite->pluck('moy_semestre1'));
    const moyS2 = @json($bilanParSpecialite->pluck('moy_semestre2'));
    const moyComp = @json($bilanParSpecialite->pluck('moy_competences'));
    const moyGen = @json($bilanParSpecialite->pluck('moyenne_generale'));
    const tauxAdmission = @json($bilanParSpecialite->pluck('taux_admission'));

    // Palette de couleurs dérivée de primary
    const colors = [
        'rgba(246, 83, 83, 0.8)',     // Primary
        'rgba(59, 130, 246, 0.8)',    // Bleu
        'rgba(168, 85, 247, 0.8)',    // Violet
        'rgba(251, 146, 60, 0.8)',    // Orange
        'rgba(236, 72, 153, 0.8)',    // Rose
        'rgba(14, 165, 233, 0.8)',    // Cyan
    ];

    const colorsBorder = [
        'rgb(246, 83, 83)',
        'rgb(59, 130, 246)',
        'rgb(168, 85, 247)',
        'rgb(251, 146, 60)',
        'rgb(236, 72, 153)',
        'rgb(14, 165, 233)',
    ];

    const chartOptions = {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                labels: {
                    color: mutedColor,
                    font: {
                        family: "ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto",
                        size: 12,
                        weight: '600'
                    }
                }
            }
        }
    };

    // ============ GRAPHIQUE RADAR ============
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
                    tauxAdmission[index] / 5
                ],
                backgroundColor: colors[index % colors.length].replace('0.8', '0.15'),
                borderColor: colorsBorder[index % colorsBorder.length],
                borderWidth: 2.5,
                pointBackgroundColor: colorsBorder[index % colorsBorder.length],
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }))
        },
        options: {
            ...chartOptions,
            scales: {
                r: {
                    beginAtZero: true,
                    max: 20,
                    grid: {
                        color: secondaryColor
                    },
                    ticks: {
                        color: mutedColor,
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });

    // ============ GRAPHIQUE BARRES ============
    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: specialites,
            datasets: [
                {
                    label: 'Semestre 1',
                    data: moyS1,
                    backgroundColor: colors[0].replace('0.8', '0.7'),
                    borderColor: colorsBorder[0],
                    borderWidth: 1.5,
                    borderRadius: 6
                },
                {
                    label: 'Semestre 2',
                    data: moyS2,
                    backgroundColor: colors[1].replace('0.8', '0.7'),
                    borderColor: colorsBorder[1],
                    borderWidth: 1.5,
                    borderRadius: 6
                },
                {
                    label: 'Compétences',
                    data: moyComp,
                    backgroundColor: colors[2].replace('0.8', '0.7'),
                    borderColor: colorsBorder[2],
                    borderWidth: 1.5,
                    borderRadius: 6
                }
            ]
        },
        options: {
            ...chartOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 20,
                    grid: {
                        color: secondaryColor
                    },
                    ticks: {
                        color: mutedColor,
                        font: {
                            size: 11
                        }
                    }
                },
                x: {
                    ticks: {
                        color: mutedColor,
                        font: {
                            size: 11,
                            weight: '600'
                        }
                    }
                }
            }
        }
    });

    // ============ GRAPHIQUE LINÉAIRE ============
    const ctxLine = document.getElementById('lineChart').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: specialites,
            datasets: [
                {
                    label: 'Moyenne Générale',
                    data: moyGen,
                    borderColor: colorsBorder[0],
                    backgroundColor: colors[0].replace('0.8', '0.1'),
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointBackgroundColor: colorsBorder[0],
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                    yAxisID: 'y'
                },
                {
                    label: 'Taux d\'Admission (%)',
                    data: tauxAdmission,
                    borderColor: colorsBorder[1],
                    backgroundColor: colors[1].replace('0.8', '0.1'),
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointBackgroundColor: colorsBorder[1],
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            ...chartOptions,
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
                        text: 'Moyenne Générale (/20)',
                        color: mutedColor,
                        font: {
                            size: 12,
                            weight: '600'
                        }
                    },
                    beginAtZero: true,
                    max: 20,
                    grid: {
                        color: secondaryColor
                    },
                    ticks: {
                        color: mutedColor,
                        font: {
                            size: 11
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Taux d\'Admission (%)',
                        color: mutedColor,
                        font: {
                            size: 12,
                            weight: '600'
                        }
                    },
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        drawOnChartArea: false
                    },
                    ticks: {
                        color: mutedColor,
                        font: {
                            size: 11
                        }
                    }
                },
                x: {
                    ticks: {
                        color: mutedColor,
                        font: {
                            size: 11,
                            weight: '600'
                        }
                    }
                }
            }
        }
    });
    @endif
</script>

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

    /* Scroll personnalisé */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: var(--background);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--border);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--muted-foreground);
    }

    /* Impression */
    @media print {
        .no-print {
            display: none !important;
        }
        
        @page {
            size: landscape A4;
            margin: 1cm;
        }
        
        body {
            background-color: white !important;
        }
        
        * {
            box-shadow: none !important;
        }
    }
</style>
@endpush
