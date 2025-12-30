
@extends('layouts.app')

@section('title', 'Détail de la spécialité - ' . $specialite->code)

@section('content')
<!-- En-tête avec navigation -->
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 no-print bg-primary/5 rounded-lg p-6 border border-border/50">
    <div class="flex-1">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('bilan.specialite.index') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-primary/10 hover:bg-primary/20 transition-colors duration-200">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-foreground">
                    📋 {{ $specialite->code }}
                </h1>
                <p class="text-sm text-muted-foreground mt-1">{{ $specialite->intitule }}</p>
            </div>
        </div>
        <p class="text-sm text-muted-foreground mt-2">
            Détail des évaluations et bilan des compétences par étudiant
        </p>
    </div>
    
    <div class="flex flex-wrap gap-2 w-full sm:w-auto">
        <button onclick="window.print()" 
                class="flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-medium transition-all duration-200 shadow-sm flex-1 sm:flex-none justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            <span class="hidden sm:inline">Imprimer</span>
        </button>
        <a href="{{ route('bilan.specialite.export-detail-pdf', ['specialite' => $specialite->id] + request()->all()) }}" 
           class="flex items-center gap-2 px-4 py-2 bg-accent hover:bg-accent/80 text-accent-foreground rounded-lg font-medium transition-all duration-200 flex-1 sm:flex-none justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="hidden sm:inline">Exporter PDF</span>
        </a>
    </div>
</div>

<!-- Filtre année -->
<div class="card mb-6 no-print bg-card border border-border rounded-lg shadow-sm">
    <div class="p-6">
        <form method="GET" action="{{ route('bilan.specialite.show', $specialite) }}" class="flex flex-col sm:flex-row items-end gap-4">
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




<!-- Tableau principal -->
<div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
    <div class="p-6 border-b border-border">
        <h2 class="text-xl font-bold text-foreground">📊 Détail des étudiants</h2>
    </div>
    <div class="overflow-x-auto">
        @if($etudiants->isEmpty())
        <div class="text-center py-16 px-6">
            <svg class="mx-auto h-12 w-12 text-muted-foreground/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <h3 class="mt-4 text-sm font-semibold text-foreground">Aucun étudiant</h3>
            <p class="mt-1 text-sm text-muted-foreground">Aucun étudiant inscrit dans cette spécialité.</p>
        </div>
        @else
        <table class="w-full text-sm">
            <thead class="bg-muted/50 border-b border-border">
                <tr>
                    <th rowspan="2" class="px-4 py-3 text-center font-bold text-foreground border-r border-border" style="min-width: 40px;">
                        N°
                    </th>
                    <th rowspan="2" class="px-4 py-3 text-left font-bold text-foreground border-r border-border" style="min-width: 220px;">
                        <div>Nom et prénoms</div>
                        <div class="text-xs font-normal text-muted-foreground">Names and first names</div>
                    </th>
                    <th colspan="7" class="px-4 py-3 text-center font-bold text-foreground border-r border-border bg-primary/5">
                        Évaluations semestrielles (30%)
                    </th>
                    <th colspan="6" class="px-4 py-3 text-center font-bold text-foreground border-r border-border bg-primary/5">
                        Semestre 2 (30%)
                    </th>
                    <th rowspan="2" class="px-4 py-3 text-center font-bold text-foreground border-r border-border bg-primary/10" style="min-width: 100px;">
                        <div>Bilan des compétences</div>
                        <div class="text-xs font-normal">(70%)</div>
                    </th>
                    <th rowspan="2" class="px-4 py-3 text-center font-bold text-primary bg-primary/10" style="min-width: 100px;">
                        <div>Moy. Gén.</div>
                        <div class="text-xs font-normal">(100%)</div>
                    </th>
                </tr>
                <tr class="border-b border-border">
                    <!-- Semestre 1 -->
                    <th class="px-2 py-2 text-center font-bold text-foreground border-r border-border bg-primary/5">
                        <div class="text-xs">Semestre 1</div>
                    </th>
                    @for($i = 1; $i <= 5; $i++)
                    <th class="px-2 py-2 text-center font-bold text-foreground border-r border-border bg-primary/5">M{{ $i }}</th>
                    @endfor
                    <th class="px-2 py-2 text-center font-bold text-foreground border-r border-border bg-primary/10">
                        <div class="text-xs">Moy. S1</div>
                    </th>
                    
                    <!-- Semestre 2 -->
                    @for($i = 6; $i <= 10; $i++)
                    <th class="px-2 py-2 text-center font-bold text-foreground border-r border-border bg-primary/5">M{{ $i }}</th>
                    @endfor
                    <th class="px-2 py-2 text-center font-bold text-foreground bg-primary/10">
                        <div class="text-xs">Moy. S2</div>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @foreach($etudiants as $index => $data)
                @php
                    $etudiant = $data->etudiant;
                    $evalS1 = $data->evaluations_s1->keyBy('module.code');
                    $evalS2 = $data->evaluations_s2->keyBy('module.code');
                    $isAdmis = $data->moyenne_generale >= 10;
                @endphp
                <tr class="hover:bg-muted/30 transition-colors duration-150">
                    <!-- N° -->
                    <td class="px-4 py-3 text-center font-semibold text-foreground border-r border-border">
                        {{ $index + 1 }}
                    </td>
                    
                    <!-- Nom -->
                    <td class="px-4 py-3 border-r border-border">
                        <div class="flex items-center gap-3">
                            @if($etudiant->profile)
                            <img class="h-8 w-8 rounded-full object-cover no-print" src="{{ Storage::url($etudiant->profile) }}" alt="{{ $etudiant->name }}">
                            @else
                            <div class="h-8 w-8 rounded-full bg-primary/20 flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-bold text-primary">{{ substr($etudiant->name, 0, 1) }}</span>
                            </div>
                            @endif
                            <div>
                                <div class="font-semibold text-foreground">{{ strtoupper($etudiant->name) }}</div>
                                <div class="text-xs text-muted-foreground">{{ $etudiant->matricule }}</div>
                            </div>
                        </div>
                    </td>
                    
                    <!-- Semestre 1 - Label -->
                    <td class="px-2 py-3 text-center bg-primary/5 border-r border-border"></td>
                    
                    <!-- Notes Semestre 1 (M1-M5) -->
                    @for($i = 1; $i <= 5; $i++)
                    @php
                        $eval = $evalS1->get("M{$i}");
                        $note = $eval?->note ?? null;
                        $isValid = $note && $note >= 10;
                    @endphp
                    <td class="px-2 py-3 text-center font-semibold border-r border-border bg-primary/5 {{ $isValid ? 'text-primary' : ($note ? 'text-muted-foreground' : '') }}">
                        {{ $note ? number_format($note, 0) : '-' }}
                    </td>
                    @endfor
                    
                    <!-- Moyenne Semestre 1 -->
                    <td class="px-2 py-3 text-center font-bold text-base border-r border-border bg-primary/10 text-primary">
                        {{ $data->moy_semestre1 > 0 ? number_format($data->moy_semestre1, 2) : '-' }}
                    </td>
                    
                    <!-- Notes Semestre 2 (M6-M10) -->
                    @for($i = 6; $i <= 10; $i++)
                    @php
                        $eval = $evalS2->get("M{$i}");
                        $note = $eval?->note ?? null;
                        $isValid = $note && $note >= 10;
                    @endphp
                    <td class="px-2 py-3 text-center font-semibold border-r border-border bg-primary/5 {{ $isValid ? 'text-primary' : ($note ? 'text-muted-foreground' : '') }}">
                        {{ $note ? number_format($note, 0) : '-' }}
                    </td>
                    @endfor
                    
                    <!-- Moyenne Semestre 2 -->
                    <td class="px-2 py-3 text-center font-bold text-base border-r border-border bg-primary/10 text-primary">
                        {{ $data->moy_semestre2 > 0 ? number_format($data->moy_semestre2, 2) : '-' }}
                    </td>
                    
                    <!-- Bilan des compétences (70%) -->
                    <td class="px-2 py-3 text-center font-bold text-base border-r border-border bg-primary/10 text-primary">
                        {{ $data->moy_competences > 0 ? number_format($data->moy_competences, 2) : '-' }}
                    </td>
                    
                    <!-- Moyenne Générale (100%) -->
                    <td class="px-2 py-3 text-center font-bold text-lg bg-primary/10 {{ $isAdmis ? 'text-primary' : 'text-muted-foreground' }}">
                        {{ $data->moyenne_generale > 0 ? number_format($data->moyenne_generale, 2) : '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

<!-- Statistiques de la spécialité -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6 pt-10">
    <!-- Total Étudiants -->
    <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Total Étudiants</p>
                    <p class="text-3xl font-bold text-foreground mt-2">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-primary/10 rounded-full p-3">
                    <svg class="h-8 w-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Admis -->
    <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Admis</p>
                    <p class="text-3xl font-bold text-foreground mt-2">{{ $stats['admis'] }}</p>
                </div>
                <div class="bg-primary/10 rounded-full p-3">
                    <svg class="h-8 w-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Non Admis -->
    <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Non Admis</p>
                    <p class="text-3xl font-bold text-foreground mt-2">{{ $stats['non_admis'] }}</p>
                </div>
                <div class="bg-primary/10 rounded-full p-3">
                    <svg class="h-8 w-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
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
                    <p class="text-3xl font-bold text-foreground mt-2">{{ number_format($stats['taux_admission'], 1) }}%</p>
                </div>
                <div class="bg-primary/10 rounded-full p-3">
                    <svg class="h-8 w-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
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
                    <p class="text-3xl font-bold text-primary mt-2">{{ number_format($stats['moy_generale'], 2) }}/20</p>
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


<!-- SECTION GRAPHIQUES AJOUTÉE -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6 no-print pt-10">
    <!-- Graphique Admission -->
    <div class="card bg-card border border-border rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-bold text-foreground mb-4">Réussite vs Échec</h3>
        <div class="relative h-64">
            <canvas id="chart-admission"></canvas>
        </div>
    </div>

    <!-- Graphique Comparatif Moyennes -->
    <div class="card bg-card border border-border rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-bold text-foreground mb-4">Comparaison des Moyennes</h3>
        <div class="relative h-64">
            <canvas id="chart-moyennes"></canvas>
        </div>
    </div>
</div>
<!-- Légende et informations -->
<div class="card mt-6 bg-primary/5 border border-primary/20 rounded-lg shadow-sm no-print overflow-hidden">
    <div class="p-6">
        <div class="flex items-start gap-4">
            <div class="bg-primary/20 rounded-full p-3 flex-shrink-0">
                <svg class="h-6 w-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-bold text-foreground mb-3">💡 Information sur le calcul :</h3>
                <ul class="space-y-2 text-sm text-muted-foreground">
                    <li class="flex gap-2">
                        <span class="text-primary font-bold">•</span>
                        <span><strong class="text-foreground">Évaluations semestrielles (30%)</strong> : Moyenne des modules M1 à M10</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-primary font-bold">•</span>
                        <span><strong class="text-foreground">Moy. S1</strong> = Moyenne des modules M1 à M5 (Semestre 1)</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-primary font-bold">•</span>
                        <span><strong class="text-foreground">Moy. S2</strong> = Moyenne des modules M6 à M10 (Semestre 2)</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-primary font-bold">•</span>
                        <span><strong class="text-foreground">Bilan des compétences (70%)</strong> = Évaluation pratique des compétences</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-primary font-bold">•</span>
                        <span><strong class="text-foreground">Moy. Gén. (100%)</strong> = [(Moy. S1 + Moy. S2) / 2 × 30%] + [Bilan compétences × 70%]</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Récupérer les couleurs depuis vos variables CSS pour respecter le thème
        const rootStyles = getComputedStyle(document.documentElement);
        
        // Fallback si les variables ne sont pas chargées (par ex en développement)
        const getVar = (name, fallback) => {
            const val = rootStyles.getPropertyValue(name).trim();
            return val || fallback;
        };

        const colorPrimary = getVar('--color-primary', 'hsl(0 90% 62%)');
        const colorForeground = getVar('--color-foreground', 'hsl(223.8 0% 98%)');
        const colorMuted = getVar('--color-muted', 'hsl(223.8 0% 14.94%)');
        const colorDestructive = getVar('--color-destructive', 'hsl(358.8 100% 70%)');
        const colorBackground = getVar('--color-background', 'hsl(223.8 0% 3.94%)');
        const colorBorder = getVar('--color-border', 'hsl(223.8 0% 15.51%)');

        // Chart 1: Réussite vs Échec (Doughnut)
        const ctxAdmission = document.getElementById('chart-admission');
        if (ctxAdmission) {
            new Chart(ctxAdmission, {
                type: 'doughnut',
                data: {
                    labels: ['Admis', 'Non Admis'],
                    datasets: [{
                        data: [{{ $stats['admis'] }}, {{ $stats['non_admis'] }}],
                        backgroundColor: [
                            colorPrimary,      // Rouge pour Admis
                            colorMuted          // Gris pour Non Admis
                        ],
                        borderColor: colorBackground,
                        borderWidth: 2,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: colorForeground,
                                font: { family: "'Instrument Sans', sans-serif" },
                                padding: 20
                            }
                        },
                        tooltip: {
                            bodyColor: colorForeground,
                            backgroundColor: colorBorder,
                            borderColor: colorPrimary,
                            borderWidth: 1
                        }
                    }
                }
            });
        }

        // Chart 2: Comparaison des Moyennes (Bar)
        const ctxMoyennes = document.getElementById('chart-moyennes');
        if (ctxMoyennes) {
            new Chart(ctxMoyennes, {
                type: 'bar',
                data: {
                    labels: ['Moy. S1', 'Moy. S2', 'Compétences (70%)', 'Moy. Générale'],
                    datasets: [{
                        label: 'Moyennes',
                        data: [
                            {{ number_format($stats['moy_semestre1'], 2) }},
                            {{ number_format($stats['moy_semestre2'], 2) }},
                            {{ number_format($stats['moy_competences'], 2) }},
                            {{ number_format($stats['moy_generale'], 2) }}
                        ],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)', // Couleur neutre 1
                            'rgba(54, 162, 235, 0.5)', // Couleur neutre 2
                            'rgba(255, 206, 86, 0.5)', // Couleur neutre 3
                            colorPrimary                // Votre Rouge Principal pour la Moyenne Générale
                        ],
                        borderColor: colorBorder,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 20,
                            grid: { color: colorBorder },
                            ticks: { color: colorForeground }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: colorForeground }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            bodyColor: colorForeground,
                            backgroundColor: colorBorder,
                            borderColor: colorPrimary,
                            borderWidth: 1
                        }
                    }
                }
            });
        }
    });
</script>
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        
        table {
            font-size: 7px;
            page-break-inside: avoid;
        }
        
        th, td {
            padding: 3px 2px !important;
        }
        
        tr {
            page-break-inside: avoid;
        }
        
        @page {
            size: landscape;
            margin: 0.5cm;
        }
        
        body {
            background: white;
            color: #1a1a1a;
        }
    }
</style>

