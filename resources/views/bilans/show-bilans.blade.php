@extends('layouts.app')

@section('title', 'Détails du Bilan de Compétences')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Retour -->
    <a href="{{ route('bilans.index') }}" class="inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-foreground mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour à la liste
    </a>

    <!-- En-tête du bilan -->
    <div class="bg-card border border-border rounded-lg p-6 mb-6">
        <div class="flex items-start justify-between gap-6">
            
            <!-- Profil étudiant -->
            <div class="flex items-start gap-4 flex-1">
                
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    @if($bilan->user->profile)
                    <img class="h-16 w-16 rounded-full object-cover border border-border" 
                         src="{{ Storage::url($bilan->user->profile) }}" 
                         alt="{{ $bilan->user->name }}">
                    @else
                    <div class="h-16 w-16 rounded-full bg-primary/10 flex items-center justify-center text-sm font-semibold text-primary border border-border">
                        {{ $bilan->user->initials() }}
                    </div>
                    @endif
                </div>

                <!-- Infos -->
                <div class="flex-1">
                    <h1 class="text-xl font-bold text-foreground">{{ $bilan->user->name }}</h1>
                    <p class="text-xs text-muted-foreground mt-1">{{ $bilan->user->email }}</p>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                        <div>
                            <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Matricule</p>
                            <p class="text-sm font-medium text-foreground mt-1">{{ $bilan->user->matricule ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Spécialité</p>
                            <p class="text-sm font-medium text-foreground mt-1">
                                {{ $bilan->user->specialite->intitule ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Année</p>
                            <p class="text-sm font-medium text-foreground mt-1">{{ $bilan->anneeAcademique->libelle }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Statut</p>
                            <p class="text-sm font-medium mt-1">
                                @if($bilan->moyenne_generale >= 10)
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-500/10 text-green-600">✓ Admis</span>
                                @else
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-destructive/10 text-destructive">✗ Ajourné</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col gap-2">
                <a href="{{ route('bilans.edit', $bilan) }}" class="px-3 py-2 text-xs font-medium text-primary-foreground bg-primary hover:bg-primary/90 rounded transition-colors inline-flex items-center justify-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('bilans.pdf', $bilan) }}" class="px-3 py-2 text-xs font-medium text-muted-foreground bg-muted hover:bg-muted/80 rounded transition-colors inline-flex items-center justify-center gap-1" target="_blank">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    PDF
                </a>
            </div>

        </div>
    </div>

    <!-- Résultats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        
        <!-- Moy. Compétences -->
        <div class="bg-card border border-border rounded-lg p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Moy. Compétences (70%)</p>
                    <p class="text-2xl font-bold text-primary mt-2">{{ number_format($bilan->moy_competences, 2) }}/20</p>
                </div>
                <div class="p-2 bg-primary/10 rounded">
                    <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Moy. Générale -->
        <div class="bg-card border border-border rounded-lg p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Moyenne Générale</p>
                    <p class="text-2xl font-bold {{ $bilan->moyenne_generale >= 10 ? 'text-green-600' : 'text-destructive' }} mt-2">
                        {{ number_format($bilan->moyenne_generale, 2) }}/20
                    </p>
                </div>
                <div class="p-2 {{ $bilan->moyenne_generale >= 10 ? 'bg-green-500/10' : 'bg-destructive/10' }} rounded">
                    <svg class="w-5 h-5 {{ $bilan->moyenne_generale >= 10 ? 'text-green-600' : 'text-destructive' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Évaluations -->
        <div class="bg-card border border-border rounded-lg p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Moy. Évaluations (30%)</p>
                    <p class="text-2xl font-bold text-foreground mt-2">
                        {{ number_format((($evaluationsSemestre1->avg('note') ?? 0) + ($evaluationsSemestre2->avg('note') ?? 0)) / 2, 2) }}/20
                    </p>
                </div>
                <div class="p-2 bg-muted rounded">
                    <svg class="w-5 h-5 text-muted-foreground" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2H3a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V6a1 1 0 00-1-1h-3a1 1 0 000-2 2 2 0 00-2-2H4zm9 4a1 1 0 100 2 1 1 0 000-2zm-3 2a1 1 0 11-2 0 1 1 0 012 0zm-4 1a2 2 0 11-4 0 2 2 0 014 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    <!-- Détail du calcul -->
    <div class="bg-card border border-border rounded-lg p-5 mb-6">
        <h3 class="text-sm font-semibold text-foreground uppercase tracking-wide mb-4">Détail du calcul</h3>
        
        <div class="space-y-3">
            
            <!-- S1 -->
            <div class="flex items-center justify-between p-3 bg-muted/50 rounded">
                <span class="text-sm text-foreground">Moyenne S1</span>
                <span class="text-sm font-semibold text-foreground">{{ number_format($evaluationsSemestre1->avg('note') ?? 0, 2) }}/20</span>
            </div>

            <!-- S2 -->
            <div class="flex items-center justify-between p-3 bg-muted/50 rounded">
                <span class="text-sm text-foreground">Moyenne S2</span>
                <span class="text-sm font-semibold text-foreground">{{ number_format($evaluationsSemestre2->avg('note') ?? 0, 2) }}/20</span>
            </div>

            <!-- Séparateur -->
            <div class="border-t border-border my-2"></div>

            <!-- Contribution Évaluations -->
            <div class="flex items-center justify-between p-3 bg-primary/5 rounded">
                <span class="text-sm text-foreground">Évaluations (30%)</span>
                <span class="text-sm font-semibold text-primary">
                    {{ number_format(((($evaluationsSemestre1->avg('note') ?? 0) + ($evaluationsSemestre2->avg('note') ?? 0)) / 2) * 0.30, 2) }}/20
                </span>
            </div>

            <!-- Contribution Compétences -->
            <div class="flex items-center justify-between p-3 bg-primary/5 rounded">
                <span class="text-sm text-foreground">Compétences (70%)</span>
                <span class="text-sm font-semibold text-primary">
                    {{ number_format($bilan->moy_competences * 0.70, 2) }}/20
                </span>
            </div>

            <!-- Résultat final -->
            <div class="flex items-center justify-between p-3 bg-foreground/5 rounded border border-foreground/10 mt-3">
                <span class="text-sm font-semibold text-foreground uppercase">Total</span>
                <span class="text-lg font-bold {{ $bilan->moyenne_generale >= 10 ? 'text-green-600' : 'text-destructive' }}">
                    {{ number_format($bilan->moyenne_generale, 2) }}/20
                </span>
            </div>

        </div>
    </div>

    <!-- Évaluations -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        
        <!-- Semestre 1 -->
        <div class="bg-card border border-border rounded-lg overflow-hidden">
            <div class="px-5 py-4 border-b border-border bg-muted/50">
                <h3 class="text-sm font-semibold text-foreground">Évaluations S1</h3>
            </div>
            
            @if($evaluationsSemestre1->isEmpty())
            <div class="p-6 text-center">
                <p class="text-xs text-muted-foreground">Aucune évaluation</p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-muted/50 border-b border-border">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-muted-foreground text-xs">Matière</th>
                            <th class="px-4 py-2 text-center font-semibold text-muted-foreground text-xs">Note</th>
                            <th class="px-4 py-2 text-center font-semibold text-muted-foreground text-xs">Résultat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach($evaluationsSemestre1 as $eval)
                        <tr class="hover:bg-muted/30 transition-colors">
                            <td class="px-4 py-2 text-sm text-foreground">{{ $eval->matiere->intitule ?? 'N/A' }}</td>
                            <td class="px-4 py-2 text-center">
                                <span class="text-sm font-semibold {{ $eval->note >= 10 ? 'text-green-600' : 'text-destructive' }}">
                                    {{ number_format($eval->note, 2) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <span class="text-xs font-medium {{ $eval->note >= 10 ? 'text-green-600' : 'text-destructive' }}">
                                    {{ $eval->note >= 10 ? '✓' : '✗' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-muted/50 border-t border-border">
                        <tr>
                            <td class="px-4 py-2 text-sm font-semibold text-foreground">Moyenne</td>
                            <td class="px-4 py-2 text-center">
                                <span class="text-sm font-bold text-primary">
                                    {{ number_format($evaluationsSemestre1->avg('note'), 2) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <span class="text-xs font-medium {{ $evaluationsSemestre1->avg('note') >= 10 ? 'text-green-600' : 'text-destructive' }}">
                                    {{ $evaluationsSemestre1->avg('note') >= 10 ? '✓' : '✗' }}
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endif
        </div>

        <!-- Semestre 2 -->
        <div class="bg-card border border-border rounded-lg overflow-hidden">
            <div class="px-5 py-4 border-b border-border bg-muted/50">
                <h3 class="text-sm font-semibold text-foreground">Évaluations S2</h3>
            </div>
            
            @if($evaluationsSemestre2->isEmpty())
            <div class="p-6 text-center">
                <p class="text-xs text-muted-foreground">Aucune évaluation</p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-muted/50 border-b border-border">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-muted-foreground text-xs">Matière</th>
                            <th class="px-4 py-2 text-center font-semibold text-muted-foreground text-xs">Note</th>
                            <th class="px-4 py-2 text-center font-semibold text-muted-foreground text-xs">Résultat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach($evaluationsSemestre2 as $eval)
                        <tr class="hover:bg-muted/30 transition-colors">
                            <td class="px-4 py-2 text-sm text-foreground">{{ $eval->matiere->intitule ?? 'N/A' }}</td>
                            <td class="px-4 py-2 text-center">
                                <span class="text-sm font-semibold {{ $eval->note >= 10 ? 'text-green-600' : 'text-destructive' }}">
                                    {{ number_format($eval->note, 2) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <span class="text-xs font-medium {{ $eval->note >= 10 ? 'text-green-600' : 'text-destructive' }}">
                                    {{ $eval->note >= 10 ? '✓' : '✗' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-muted/50 border-t border-border">
                        <tr>
                            <td class="px-4 py-2 text-sm font-semibold text-foreground">Moyenne</td>
                            <td class="px-4 py-2 text-center">
                                <span class="text-sm font-bold text-primary">
                                    {{ number_format($evaluationsSemestre2->avg('note'), 2) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <span class="text-xs font-medium {{ $evaluationsSemestre2->avg('note') >= 10 ? 'text-green-600' : 'text-destructive' }}">
                                    {{ $evaluationsSemestre2->avg('note') >= 10 ? '✓' : '✗' }}
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endif
        </div>

    </div>

    <!-- Observations -->
    @if($bilan->observations)
    <div class="bg-card border border-border rounded-lg p-5 mb-6">
        <h3 class="text-sm font-semibold text-foreground uppercase tracking-wide mb-3">Observations</h3>
        <div class="p-3 bg-amber-500/10 border border-amber-500/20 rounded text-sm text-foreground whitespace-pre-wrap">
            {{ $bilan->observations }}
        </div>
    </div>
    @endif

    <!-- Infos supplémentaires -->
    <div class="bg-card border border-border rounded-lg p-5 mb-6">
        <h3 class="text-sm font-semibold text-foreground uppercase tracking-wide mb-4">Informations</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Créé le</p>
                <p class="text-sm font-medium text-foreground mt-1">{{ $bilan->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Modifié le</p>
                <p class="text-sm font-medium text-foreground mt-1">{{ $bilan->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Actions finales -->
    <div class="flex items-center justify-between gap-3">
        <a href="{{ route('bilans.index') }}" class="px-4 py-2 text-sm font-medium text-muted-foreground bg-muted hover:bg-muted/80 rounded transition-colors inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Retour
        </a>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('bilans.edit', $bilan) }}" class="px-4 py-2 text-sm font-medium text-primary-foreground bg-primary hover:bg-primary/90 rounded transition-colors inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Modifier
            </a>
            
            <form action="{{ route('bilans.destroy', $bilan) }}" method="POST" class="inline" 
                  onsubmit="return confirm('Supprimer ce bilan ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-sm font-medium text-destructive-foreground bg-destructive hover:bg-destructive/90 rounded transition-colors inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Supprimer
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
