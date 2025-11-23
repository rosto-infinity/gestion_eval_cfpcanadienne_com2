@extends('layouts.app')

@section('title', 'Modifier le bilan de compétences')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Retour -->
    <a href="{{ route('bilans.show', $bilan) }}" class="inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-foreground mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour aux détails
    </a>

    <!-- Layout 2 colonnes -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Colonne Gauche (Formulaire) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Infos étudiant -->
            <div class="bg-card border border-border rounded-lg p-5">
                <div class="flex items-start gap-4">
                    <div class="p-2 bg-primary/10 rounded">
                        <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-foreground">Informations de l'étudiant</h3>
                        <div class="grid grid-cols-2 gap-4 mt-3 text-xs">
                            <div>
                                <p class="text-muted-foreground">Matricule</p>
                                <p class="font-medium text-foreground mt-0.5">{{ $bilan->user->matricule }}</p>
                            </div>
                            <div>
                                <p class="text-muted-foreground">Nom</p>
                                <p class="font-medium text-foreground mt-0.5">{{ $bilan->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-muted-foreground">Spécialité</p>
                                <p class="font-medium text-foreground mt-0.5">{{ $bilan->user->specialite->intitule }}</p>
                            </div>
                            <div>
                                <p class="text-muted-foreground">Année</p>
                                <p class="font-medium text-foreground mt-0.5">{{ $bilan->anneeAcademique->libelle }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire -->
            <div class="bg-card border border-border rounded-lg overflow-hidden">
                
                <!-- Header -->
                <div class="px-6 py-4 border-b border-border bg-muted/50">
                    <h2 class="text-lg font-semibold text-foreground">Modifier le bilan</h2>
                </div>

                <!-- Body -->
                <div class="p-6">

                    <form action="{{ route('bilans.update', $bilan) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Champ Compétences -->
                        <div>
                            <label for="moy_competences" class="block text-sm font-semibold text-foreground mb-2">
                                Nouvelle moyenne des compétences (70%) <span class="text-destructive">*</span>
                            </label>
                            <input type="number" 
                                   name="moy_competences" 
                                   id="moy_competences" 
                                   min="0" 
                                   max="20" 
                                   step="0.01" 
                                   value="{{ old('moy_competences', $bilan->moy_competences) }}"
                                   class="w-full px-4 py-3 text-lg font-semibold border border-border rounded-lg bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors @error('moy_competences') border-destructive @enderror"
                                   required>
                            @error('moy_competences')
                            <p class="mt-1.5 text-xs text-destructive">{{ $message }}</p>
                            @enderror
                            <p class="mt-1.5 text-xs text-muted-foreground">
                                Cette note représente 70% de la moyenne générale finale
                            </p>
                        </div>

                        <!-- Observations -->
                        <div>
                            <label for="observations" class="block text-sm font-semibold text-foreground mb-2">
                                Observations
                            </label>
                            <textarea name="observations" 
                                      id="observations" 
                                      rows="5" 
                                      placeholder="Remarques, commentaires, recommandations..."
                                      class="w-full px-4 py-3 border border-border rounded-lg bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors resize-none @error('observations') border-destructive @enderror">{{ old('observations', $bilan->observations) }}</textarea>
                            @error('observations')
                            <p class="mt-1.5 text-xs text-destructive">{{ $message }}</p>
                            @enderror
                            <p class="mt-1.5 text-xs text-muted-foreground">Maximum 1000 caractères</p>
                        </div>

                        <!-- Avertissement -->
                        <div class="p-4 bg-amber-500/10 border border-amber-500/20 rounded-lg flex gap-3">
                            <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-amber-600">Attention</p>
                                <p class="text-xs text-amber-600/80 mt-0.5">
                                    La modification recalculera automatiquement la moyenne générale de l'étudiant.
                                </p>
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="flex items-center justify-between pt-4 border-t border-border">
                            <a href="{{ route('bilans.show', $bilan) }}" class="px-4 py-2 text-sm font-medium text-muted-foreground bg-muted hover:bg-muted/80 rounded transition-colors">
                                Annuler
                            </a>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-primary-foreground bg-primary hover:bg-primary/90 rounded transition-colors inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Mettre à jour
                            </button>
                        </div>
                    </form>

                </div>

            </div>

        </div>

        <!-- Colonne Droite (Aperçu) -->
        <div class="lg:col-span-1">

            <!-- Résumé des moyennes -->
            <div class="bg-card border border-border rounded-lg p-5 mb-6 sticky top-6">
                <h3 class="text-sm font-semibold text-foreground mb-4">Résumé des moyennes</h3>
                
                <div class="space-y-3">
                    
                    <!-- Évaluations -->
                    <div class="p-3 bg-muted/50 rounded-lg border border-border">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Moy. Éval. (30%)</p>
                        <p class="text-2xl font-bold text-primary mt-1.5">
                            {{ $bilan->moy_evaluations ? number_format($bilan->moy_evaluations, 2) : '-' }}
                        </p>
                        <p class="text-xs text-muted-foreground mt-1">Automatique</p>
                    </div>

                    <!-- Compétences -->
                    <div class="p-3 bg-muted/50 rounded-lg border border-border">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Moy. Comp. (70%)</p>
                        <p class="text-2xl font-bold text-foreground mt-1.5">
                            {{ $bilan->moy_competences ? number_format($bilan->moy_competences, 2) : '-' }}
                        </p>
                        <p class="text-xs text-muted-foreground mt-1">À modifier</p>
                    </div>

                    <!-- Générale -->
                    <div class="p-3 {{ $bilan->isAdmis() ? 'bg-green-500/10' : 'bg-destructive/10' }} rounded-lg border {{ $bilan->isAdmis() ? 'border-green-500/20' : 'border-destructive/20' }}">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Moy. Générale</p>
                        <p class="text-3xl font-bold {{ $bilan->isAdmis() ? 'text-green-600' : 'text-destructive' }} mt-1.5">
                            {{ $bilan->moyenne_generale ? number_format($bilan->moyenne_generale, 2) : '-' }}
                        </p>
                        <p class="text-xs text-muted-foreground mt-1">{{ $bilan->getMention() }}</p>
                    </div>

                </div>
            </div>

            <!-- Aperçu du calcul -->
            <div class="bg-card border border-border rounded-lg p-5 sticky top-80">
                <h3 class="text-sm font-semibold text-foreground mb-4">Aperçu du calcul</h3>
                
                <!-- Valeurs actuelles -->
                <div class="mb-4">
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2.5">Actuelles</p>
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center p-2 bg-muted/50 rounded border border-border">
                            <span class="text-xs text-muted-foreground">Compétences</span>
                            <span class="font-semibold text-foreground text-sm">{{ number_format($bilan->moy_competences, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-muted/50 rounded border border-border">
                            <span class="text-xs text-muted-foreground">Générale</span>
                            <span class="font-semibold {{ $bilan->isAdmis() ? 'text-green-600' : 'text-destructive' }} text-sm">
                                {{ number_format($bilan->moyenne_generale, 2) }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-muted/50 rounded border border-border">
                            <span class="text-xs text-muted-foreground">Mention</span>
                            <span class="font-semibold text-foreground text-xs">{{ $bilan->getMention() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Flèche -->
                <div class="text-center mb-4">
                    <svg class="w-5 h-5 text-muted-foreground mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </div>

                <!-- Nouvelles valeurs -->
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2.5">Nouvelles</p>
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center p-2 bg-background rounded border border-border">
                            <span class="text-xs text-muted-foreground">Compétences</span>
                            <span class="font-semibold text-foreground text-sm" id="new-comp">{{ number_format($bilan->moy_competences, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-background rounded border border-border">
                            <span class="text-xs text-muted-foreground">Générale</span>
                            <span class="font-semibold text-sm" id="new-general">{{ number_format($bilan->moyenne_generale, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-background rounded border border-border">
                            <span class="text-xs text-muted-foreground">Mention</span>
                            <span class="font-semibold text-foreground text-xs" id="new-mention">{{ $bilan->getMention() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Différence -->
                <div class="mt-4 pt-4 border-t border-border text-center">
                    <p class="text-xs text-muted-foreground mb-1.5">Impact</p>
                    <p class="text-xl font-bold" id="difference-text">-</p>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const moyCompetencesInput = document.getElementById('moy_competences');
    const newCompDisplay = document.getElementById('new-comp');
    const newGeneralDisplay = document.getElementById('new-general');
    const newMentionDisplay = document.getElementById('new-mention');
    const differenceText = document.getElementById('difference-text');
    
    const oldMoyComp = {{ $bilan->moy_competences }};
    const oldMoyGeneral = {{ $bilan->moyenne_generale }};
    const moyEval = {{ $bilan->moy_evaluations ?? 0 }};
    
    function getMention(note) {
        if (note >= 16) return 'Très Bien';
        if (note >= 14) return 'Bien';
        if (note >= 12) return 'Assez Bien';
        if (note >= 10) return 'Passable';
        return 'Ajourné';
    }
    
    function getColor(note) {
        return note >= 10 ? 'text-green-600' : 'text-destructive';
    }
    
    moyCompetencesInput.addEventListener('input', function() {
        const newMoyComp = parseFloat(this.value);
        
        if (!isNaN(newMoyComp) && newMoyComp >= 0 && newMoyComp <= 20) {
            const newMoyGeneral = (moyEval * 0.30) + (newMoyComp * 0.70);
            const difference = newMoyGeneral - oldMoyGeneral;
            const diffFormatted = difference > 0 ? `+${difference.toFixed(2)}` : difference.toFixed(2);
            const diffColor = difference > 0 ? 'text-green-600' : (difference < 0 ? 'text-destructive' : 'text-muted-foreground');
            
            newCompDisplay.textContent = newMoyComp.toFixed(2);
            newGeneralDisplay.textContent = newMoyGeneral.toFixed(2);
            newGeneralDisplay.className = `font-semibold ${getColor(newMoyGeneral)} text-sm`;
            newMentionDisplay.textContent = getMention(newMoyGeneral);
            
            differenceText.textContent = `${diffFormatted} points`;
            differenceText.className = `text-xl font-bold ${diffColor}`;
        }
    });
    
    // Déclencher l'événement au chargement
    moyCompetencesInput.dispatchEvent(new Event('input'));
});
</script>
@endpush
