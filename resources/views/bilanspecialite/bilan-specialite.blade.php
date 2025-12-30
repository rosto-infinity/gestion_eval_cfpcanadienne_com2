@extends('layouts.app')

@section('title', 'Bilan par Spécialité')

@section('content')
<!-- En-tête avec accent primary -->
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 no-print bg-primary/5 rounded-lg p-6 border border-border/50">
    <div>
        <h1 class="text-3xl font-bold text-foreground">📈 Bilan par Spécialité</h1>
        <p class="mt-2 text-sm text-muted-foreground">
            Vue d'ensemble des performances académiques par spécialité
        </p>
    </div>
    <div class="flex flex-wrap gap-2 w-full sm:w-auto">
        <a href="{{ route('bilan.specialite.comparaison', request()->all()) }}" 
           class="flex items-center gap-2 px-4 py-2 bg-secondary hover:bg-secondary/80 text-secondary-foreground rounded-lg font-medium transition-all duration-200 flex-1 sm:flex-none justify-center sm:justify-start">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <span class="hidden sm:inline">Comparaison</span>
        </a>
        
        <button onclick="window.print()" 
                class="flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-medium transition-all duration-200 shadow-sm flex-1 sm:flex-none justify-center sm:justify-start">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            <span class="hidden sm:inline">Imprimer</span>
        </button>
        
        <a href="{{ route('bilan.specialite.export-pdf', request()->all()) }}" 
           class="flex items-center gap-2 px-4 py-2 bg-accent hover:bg-accent/80 text-accent-foreground rounded-lg font-medium transition-all duration-200 flex-1 sm:flex-none justify-center sm:justify-start">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="hidden sm:inline">Exporter PDF</span>
        </a>
    </div>
</div>

<!-- Filtres -->
<div class="card mb-6 no-print bg-card border border-border rounded-lg shadow-sm">
    <div class="p-6">
        <form method="GET" action="{{ route('bilan.specialite.index') }}" class="flex flex-col sm:flex-row items-end gap-4">
            <div class="flex-1 w-full">
                <label for="annee_id" class="block text-sm font-semibold text-foreground mb-2">Année académique</label>
                <select name="annee_id" id="annee_id" 
                        class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all">
                    @foreach($annees as $annee)
                    <option value="{{ $annee->id }}" {{ request('annee_id', $anneeActive?->id) == $annee->id ? 'selected' : '' }}>
                        {{ $annee->libelle }} {{ $annee->is_active ? '⭐' : '' }}
                    </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" 
                    class="flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-semibold transition-all duration-200 whitespace-nowrap w-full sm:w-auto justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filtrer
            </button>
        </form>
    </div>
</div>

<!-- Statistiques globales -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <!-- Spécialités -->
    <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Spécialités</p>
                    <p class="text-3xl font-bold text-foreground mt-2">{{ $statsGlobales['total_specialites'] }}</p>
                </div>
                <div class="bg-primary/10 rounded-full p-3">
                    <svg class="h-8 w-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Étudiants -->
    <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Total Étudiants</p>
                    <p class="text-3xl font-bold text-foreground mt-2">{{ $statsGlobales['total_etudiants'] }}</p>
                </div>
                <div class="bg-primary/10 rounded-full p-3">
                    <svg class="h-8 w-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Taux d'Admission -->
    <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Taux d'Admission</p>
                    <p class="text-3xl font-bold text-foreground mt-2">{{ number_format($statsGlobales['taux_admission'], 1) }}%</p>
                </div>
                <div class="bg-primary/10 rounded-full p-3">
                    <svg class="h-8 w-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Moyenne Générale -->
    <div class="card bg-primary/5 border border-primary/20 rounded-lg shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-primary uppercase tracking-wide">Moy. Générale</p>
                    <p class="text-3xl font-bold text-primary mt-2">{{ number_format($statsGlobales['moyenne_generale'], 2) }}/20</p>
                </div>
                <div class="bg-primary/20 rounded-full p-3">
                    <svg class="h-8 w-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tableau principal -->
<div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
    <div class="p-6 border-b border-border">
        <h2 class="text-xl font-bold text-foreground">📊 Tableau récapitulatif par spécialité</h2>
    </div>
    <div class="overflow-x-auto">
        @if($bilanParSpecialite->isEmpty())
        <div class="text-center py-16 px-6">
            <svg class="mx-auto h-12 w-12 text-muted-foreground/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="mt-4 text-sm font-semibold text-foreground">Aucune donnée</h3>
            <p class="mt-1 text-sm text-muted-foreground">Aucun bilan trouvé pour l'année sélectionnée.</p>
        </div>
        @else
        <table class="w-full">
            <thead class="bg-muted/50 border-b border-border">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-muted-foreground uppercase tracking-wider">Spécialité</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-muted-foreground uppercase tracking-wider">Étudiants</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-muted-foreground uppercase tracking-wider bg-primary/5">Moy. S1</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-muted-foreground uppercase tracking-wider bg-primary/5">Moy. S2</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-muted-foreground uppercase tracking-wider bg-primary/5">Moy. Compét.</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-muted-foreground uppercase tracking-wider bg-primary/10">Moy. Gén.</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-muted-foreground uppercase tracking-wider">Admis</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-muted-foreground uppercase tracking-wider">Non Admis</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-muted-foreground uppercase tracking-wider">Taux Admission</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-muted-foreground uppercase tracking-wider no-print">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @foreach($bilanParSpecialite as $bilan)
                <tr class="hover:bg-muted/30 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 bg-primary/20 rounded-md flex items-center justify-center flex-shrink-0">
                                <span class="text-sm font-bold text-primary">{{ substr($bilan->specialite->code, 0, 2) }}</span>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-foreground">{{ $bilan->specialite->code }}</div>
                                <div class="text-xs text-muted-foreground">{{ $bilan->specialite->intitule }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-primary/10 text-primary">
                            {{ $bilan->total_etudiants }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center bg-primary/5">
                        <span class="text-sm font-semibold text-foreground">{{ number_format($bilan->moy_semestre1, 2) }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center bg-primary/5">
                        <span class="text-sm font-semibold text-foreground">{{ number_format($bilan->moy_semestre2, 2) }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center bg-primary/5">
                        <span class="text-sm font-semibold text-foreground">{{ number_format($bilan->moy_competences, 2) }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center bg-primary/10">
                        <span class="text-base font-bold text-primary">{{ number_format($bilan->moyenne_generale, 2) }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-primary/10 text-primary">
                            {{ $bilan->admis }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-muted text-muted-foreground">
                            {{ $bilan->non_admis }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="flex items-center justify-center gap-2">
                            <div class="w-12 h-1.5 bg-muted rounded-full overflow-hidden">
                                <div class="h-full bg-primary transition-all" style="width: {{ $bilan->taux_admission }}%"></div>
                            </div>
                            <span class="text-xs font-semibold text-foreground">{{ number_format($bilan->taux_admission, 0) }}%</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center no-print">
                        <a href="{{ route('bilan.specialite.show', ['specialite' => $bilan->specialite->id] + request()->all()) }}" 
                           class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-primary bg-primary/10 hover:bg-primary/20 rounded-md transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <span class="hidden sm:inline">Détails</span>
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
    <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
        <div class="p-6 border-b border-border">
            <h3 class="text-lg font-bold text-foreground">📊 Moyennes générales par spécialité</h3>
        </div>
        <div class="p-6">
            <canvas id="moyennesChart"></canvas>
        </div>
    </div>
    
    <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
        <div class="p-6 border-b border-border">
            <h3 class="text-lg font-bold text-foreground">📈 Taux d'admission par spécialité</h3>
        </div>
        <div class="p-6">
            <canvas id="admissionChart"></canvas>
        </div>
    </div>
</div>

@endsection


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const specialites = @json($bilanParSpecialite->pluck('specialite.code'));
    const moyennesGenerales = @json($bilanParSpecialite->pluck('moyenne_generale'));
    const tauxAdmission = @json($bilanParSpecialite->pluck('taux_admission'));
    
    // Récupérer les couleurs du thème CSS
    const computedStyle = getComputedStyle(document.documentElement);
    const primaryColor = computedStyle.getPropertyValue('--primary').trim();
    const foregroundColor = computedStyle.getPropertyValue('--foreground').trim();
    const mutedColor = computedStyle.getPropertyValue('--muted').trim();
    
    // Convertir HSL en RGB pour Chart.js
    const hslToRgb = (hsl) => {
        const match = hsl.match(/hsl\(([^,]+),\s*([^,]+),\s*([^)]+)\)/);
        if (!match) return hsl;
        
        let h = parseInt(match[1]) / 360;
        let s = parseInt(match[2]) / 100;
        let l = parseInt(match[3]) / 100;
        
        let r, g, b;
        if (s === 0) {
            r = g = b = l;
        } else {
            const hue2rgb = (p, q, t) => {
                if (t < 0) t += 1;
                if (t > 1) t -= 1;
                if (t < 1/6) return p + (q - p) * 6 * t;
                if (t < 1/2) return q;
                if (t < 2/3) return p + (q - p) * (2/3 - t) * 6;
                return p;
            };
            const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
            const p = 2 * l - q;
            r = hue2rgb(p, q, h + 1/3);
            g = hue2rgb(p, q, h);
            b = hue2rgb(p, q, h - 1/3);
        }
        
        return `rgb(${Math.round(r * 255)}, ${Math.round(g * 255)}, ${Math.round(b * 255)})`;
    };
    
    const primaryRgb = hslToRgb(`hsl(${primaryColor})`);
    
    // Graphique des moyennes
    const ctxMoyennes = document.getElementById('moyennesChart').getContext('2d');
    new Chart(ctxMoyennes, {
        type: 'bar',
        data: {
            labels: specialites,
            datasets: [{
                label: 'Moyenne Générale',
                data: moyennesGenerales,
                backgroundColor: `${primaryRgb.replace('rgb', 'rgba').replace(')', ', 0.8)')}`,
                borderColor: primaryRgb,
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 20,
                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: { color: foregroundColor }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: foregroundColor }
                }
            },
            plugins: { legend: { display: false } }
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
                backgroundColor: `${primaryRgb.replace('rgb', 'rgba').replace(')', ', 0.1)')}`,
                borderColor: primaryRgb,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: primaryRgb,
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
                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: { color: foregroundColor }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: foregroundColor }
                }
            },
            plugins: { legend: { display: false } }
        }
    });
</script>

<style>
    @media print {
        .no-print { display: none !important; }
        @page { size: landscape; margin: 1cm; }
        body { background: white; }
    }
</style>



