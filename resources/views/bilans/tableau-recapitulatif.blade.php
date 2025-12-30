@extends('layouts.app')

@section('title', 'Tableau Récapitulatif des Résultats')

@section('content')
<div class=" mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- En-tête -->
    <div class="flex items-center justify-between mb-6 no-print">
        <div>
            <h1 class="text-2xl font-bold text-foreground">Classement des étudiants</h1>
            <p class="text-xs text-muted-foreground mt-1">Résultats par moyenne générale</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('bilans.index') }}" class="px-3 py-2 text-xs font-medium text-muted-foreground bg-muted hover:bg-muted/80 rounded transition-colors inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour
            </a>
            <button onclick="window.print()" class="px-3 py-2 text-xs font-medium text-primary-foreground bg-primary hover:bg-primary/90 rounded transition-colors inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Imprimer
            </button>
            <a href="{{ route('bilans.tableau-recapitulatif.pdf', request()->all()) }}" class="px-3 py-2 text-xs font-medium text-primary-foreground bg-primary hover:bg-primary/90 rounded transition-colors inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                PDF
            </a>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-card border border-border rounded-lg p-4 mb-6 no-print">
        <form method="GET" action="{{ route('bilans.tableau-recapitulatif') }}" class="grid grid-cols-1 md:grid-cols-3 gap-3">
            
            <div>
                <label for="annee_id" class="block text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1.5">Année académique</label>
                <select name="annee_id" id="annee_id" class="w-full px-3 py-2 text-sm border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors">
                    @foreach($annees as $annee)
                    <option value="{{ $annee->id }}" {{ request('annee_id', optional($annees->where('is_active', true)->first())->id) == $annee->id ? 'selected' : '' }}>
                        {{ $annee->libelle }} {{ $annee->is_active ? '(Active)' : '' }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="specialite_id" class="block text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1.5">Spécialité</label>
                <select name="specialite_id" id="specialite_id" class="w-full px-3 py-2 text-sm border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors">
                    <option value="">Toutes les spécialités</option>
                    @foreach($specialites as $specialite)
                    <option value="{{ $specialite->id }}" {{ request('specialite_id') == $specialite->id ? 'selected' : '' }}>
                        {{ $specialite->code }} - {{ $specialite->intitule }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full px-3 py-2 text-xs font-medium text-primary-foreground bg-primary hover:bg-primary/90 rounded transition-colors inline-flex items-center justify-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filtrer
                </button>
            </div>

        </form>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
        
        <div class="bg-card border border-border rounded-lg p-4">
            <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Total</p>
            <p class="text-2xl font-bold text-foreground mt-1">{{ $stats['total'] }}</p>
        </div>

        <div class="bg-card border border-border rounded-lg p-4">
            <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Admis</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['admis'] }}</p>
        </div>

        <div class="bg-card border border-border rounded-lg p-4">
            <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Moy. Générale</p>
            <p class="text-2xl font-bold text-primary mt-1">{{ $stats['moyenne_generale'] ? number_format($stats['moyenne_generale'], 2) : '-' }}</p>
        </div>

        <div class="bg-card border border-border rounded-lg p-4">
            <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Meilleure</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['meilleure_moyenne'] ? number_format($stats['meilleure_moyenne'], 2) : '-' }}</p>
        </div>

        <div class="bg-card border border-border rounded-lg p-4">
            <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Plus basse</p>
            <p class="text-2xl font-bold text-destructive mt-1">{{ $stats['moyenne_la_plus_basse'] ? number_format($stats['moyenne_la_plus_basse'], 2) : '-' }}</p>
        </div>

    </div>

    <!-- Répartition -->
    @if($stats['total'] > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 no-print">
        
        <!-- Taux de réussite -->
        <div class="bg-card border border-border rounded-lg p-5">
            <h3 class="text-sm font-semibold text-foreground mb-4">Taux de réussite</h3>
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <span class="text-xs text-muted-foreground">Admis (≥10)</span>
                        <span class="text-xs font-semibold text-green-600">{{ number_format(($stats['admis'] / $stats['total']) * 100, 1) }}%</span>
                    </div>
                    <div class="w-full h-2 bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-green-600 rounded-full" style="width: {{ ($stats['admis'] / $stats['total']) * 100 }}%"></div>
                    </div>
                </div>
                <div class="text-xs text-muted-foreground pt-2 border-t border-border">
                    {{ $stats['admis'] }} admis • {{ $stats['total'] - $stats['admis'] }} ajournés
                </div>
            </div>
        </div>

        <!-- Distribution -->
        <div class="bg-card border border-border rounded-lg p-5">
            <h3 class="text-sm font-semibold text-foreground mb-4">Distribution des moyennes</h3>
            <div class="space-y-2 text-xs">
                @php
                    $excellent = $bilans->filter(fn($b) => $b->moyenne_generale >= 16)->count();
                    $tresBien = $bilans->filter(fn($b) => $b->moyenne_generale >= 14 && $b->moyenne_generale < 16)->count();
                    $bien = $bilans->filter(fn($b) => $b->moyenne_generale >= 12 && $b->moyenne_generale < 14)->count();
                    $passable = $bilans->filter(fn($b) => $b->moyenne_generale >= 10 && $b->moyenne_generale < 12)->count();
                    $insuffisant = $bilans->filter(fn($b) => $b->moyenne_generale < 10)->count();
                @endphp
                <div class="flex justify-between">
                    <span class="text-muted-foreground">Excellent (≥16)</span>
                    <span class="font-semibold text-green-600">{{ $excellent }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-muted-foreground">Très bien (14-16)</span>
                    <span class="font-semibold text-primary">{{ $tresBien }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-muted-foreground">Bien (12-14)</span>
                    <span class="font-semibold text-foreground">{{ $bien }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-muted-foreground">Passable (10-12)</span>
                    <span class="font-semibold text-amber-600">{{ $passable }}</span>
                </div>
                <div class="flex justify-between pt-1 border-t border-border">
                    <span class="text-muted-foreground">Insuffisant (<10)</span>
                    <span class="font-semibold text-destructive">{{ $insuffisant }}</span>
                </div>
            </div>
        </div>

    </div>
    @endif

    <!-- Tableau -->
    <div class="bg-card border border-border rounded-lg overflow-hidden">
        
        @if($bilans->isEmpty())
        <div class="p-12 text-center">
            <svg class="mx-auto h-10 w-10 text-muted-foreground/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="mt-3 text-sm font-semibold text-foreground">Aucun résultat</h3>
            <p class="mt-1 text-xs text-muted-foreground">Aucun bilan trouvé avec les critères sélectionnés.</p>
        </div>

        @else
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead class="bg-muted border-b border-border">
                    <tr>
                        <th class="px-3 py-2.5 text-center font-semibold text-muted-foreground">Rang</th>
                        <th class="px-3 py-2.5 text-left font-semibold text-muted-foreground">Matricule</th>
                        <th class="px-3 py-2.5 text-left font-semibold text-muted-foreground">Nom</th>
                        <th class="px-3 py-2.5 text-left font-semibold text-muted-foreground">Spécialité</th>
                        <th class="px-3 py-2.5 text-center font-semibold text-muted-foreground">S1</th>
                        <th class="px-3 py-2.5 text-center font-semibold text-muted-foreground">S2</th>
                        <th class="px-3 py-2.5 text-center font-semibold text-muted-foreground">Éval</th>
                        <th class="px-3 py-2.5 text-center font-semibold text-muted-foreground">Comp</th>
                        <th class="px-3 py-2.5 text-center font-semibold text-muted-foreground">Moy. Gén.</th>
                        <th class="px-3 py-2.5 text-center font-semibold text-muted-foreground">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach($bilans as $index => $bilan)
                    <tr class="hover:bg-muted/50 transition-colors {{ $index < 3 ? 'bg-amber-500/5' : '' }}">
                        
                        <!-- Rang -->
                        <td class="px-3 py-2.5 text-center font-semibold">
                            @if($index === 0)
                            🥇
                            @elseif($index === 1)
                            🥈
                            @elseif($index === 2)
                            🥉
                            @else
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-muted text-xs font-semibold text-muted-foreground">
                                {{ $index + 1 }}
                            </span>
                            @endif
                        </td>

                        <!-- Matricule -->
                        <td class="px-3 py-2.5 font-medium text-foreground">{{ $bilan->user->matricule }}</td>

                        <!-- Nom -->
                        <td class="px-3 py-2.5">
                            <div class="flex items-center gap-2">
                                @if($bilan->user->profile)
                                <img class="h-6 w-6 rounded-full object-cover no-print" src="{{ Storage::url($bilan->user->profile) }}" alt="{{ $bilan->user->name }}">
                                @endif
                                <span class="text-foreground">{{ $bilan->user->name }}</span>
                            </div>
                        </td>

                        <!-- Spécialité -->
                        <td class="px-3 py-2.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-primary/10 text-primary">
                                {{ $bilan->user->specialite->code }}
                            </span>
                        </td>

                        <!-- S1 -->
                        <td class="px-3 py-2.5 text-center font-medium text-foreground">
                            {{ $bilan->moy_eval_semestre1 ? number_format($bilan->moy_eval_semestre1, 2) : '-' }}
                        </td>

                        <!-- S2 -->
                        <td class="px-3 py-2.5 text-center font-medium text-foreground">
                            {{ $bilan->moy_eval_semestre2 ? number_format($bilan->moy_eval_semestre2, 2) : '-' }}
                        </td>

                        <!-- Éval (30%) -->
                        <td class="px-3 py-2.5 text-center font-medium text-foreground">
                            {{ $bilan->moy_evaluations ? number_format($bilan->moy_evaluations, 2) : '-' }}
                        </td>

                        <!-- Comp (70%) -->
                        <td class="px-3 py-2.5 text-center font-medium text-foreground">
                            {{ $bilan->moy_competences ? number_format($bilan->moy_competences, 2) : '-' }}
                        </td>

                        <!-- Moy. Gén. -->
                        <td class="px-3 py-2.5 text-center font-bold {{ $bilan->moyenne_generale >= 10 ? 'text-green-600' : 'text-destructive' }}">
                            {{ number_format($bilan->moyenne_generale, 2) }}
                        </td>

                        <!-- Statut -->
                        <td class="px-3 py-2.5 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $bilan->isAdmis() ? 'bg-green-500/10 text-green-600' : 'bg-destructive/10 text-destructive' }}">
                                {{ $bilan->isAdmis() ? '✓ Admis' : '✗ Ajourné' }}
                            </span>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="px-4 py-3 bg-muted/50 border-t border-border text-center text-xs text-muted-foreground">
            Généré le {{ now()->format('d/m/Y H:i') }} • Total: {{ $bilans->count() }} étudiant(s) • Admis: {{ $stats['admis'] }} • Taux: {{ number_format(($stats['admis'] / $stats['total']) * 100, 1) }}%
        </div>
        @endif

    </div>

</div>
@endsection

@push('styles')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        
        body {
            background: white;
        }
        
        .bg-card {
            box-shadow: none;
        }
        
        @page {
            size: landscape;
            margin: 0.8cm;
        }
        
        table {
            break-inside: avoid;
        }
    }
</style>
@endpush
