@extends('layouts.app')

@section('title', 'Modifier l\'Évaluation')

@section('content')
<div class="mx-auto px-4 sm:px-6 lg:px-8 py-8">


    <!-- Breadcrumb -->
    <div class="mb-8">
        <a href="{{ route('evaluations.index') }}" 
           class="inline-flex items-center gap-2 text-primary hover:text-primary/80 font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Retour aux évaluations
        </a>
    </div>

    <!-- En-tête -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-foreground">✏️ Modifier l'Évaluation</h1>
                <p class="mt-2 text-sm text-muted-foreground">
                    Mettre à jour la note de l'étudiant
                </p>
            </div>
            <div class="hidden sm:flex items-center gap-2 px-4 py-2 bg-primary/10 rounded-lg border border-primary/20">
                <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-medium text-primary">ID: {{ $evaluation->id }}</span>
            </div>
        </div>
    </div>

    <!-- Layout 2 colonnes -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Colonne 1 : Formulaire (2/3) -->
        <div class="lg:col-span-2">
            <div class="bg-card border border-border rounded-xl shadow-sm overflow-hidden">
                <form action="{{ route('evaluations.update', $evaluation) }}" method="POST" id="editForm" class="space-y-6 p-6 sm:p-8">
                    @csrf
                    @method('PUT')

                    <!-- Section 1 : Informations Étudiant & Module -->
                    <div class="space-y-6 pb-6 border-b border-border">
                        <h2 class="text-lg font-semibold text-foreground flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                            </svg>
                            Informations de l'Évaluation
                        </h2>

                        <!-- Grille d'infos en lecture seule -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Étudiant -->
                            <div class="bg-muted/30 rounded-lg p-4 border border-border/50">
                                <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Étudiant</p>
                                <p class="text-sm font-semibold text-foreground">{{ $evaluation->user->getFullName() }}</p>
                                <p class="text-xs text-muted-foreground mt-1">{{ $evaluation->user->matricule }}</p>
                            </div>

                            <!-- Spécialité -->
                            <div class="bg-muted/30 rounded-lg p-4 border border-border/50">
                                <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Spécialité</p>
                                <p class="text-sm font-semibold text-foreground">
                                    {{ $evaluation->user->specialite?->intitule ?? '-' }}
                                </p>
                            </div>

                            <!-- Module -->
                            <div class="bg-muted/30 rounded-lg p-4 border border-border/50">
                                <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Module</p>
                                <p class="text-sm font-semibold text-foreground">{{ $evaluation->module->intitule }}</p>
                                <p class="text-xs text-muted-foreground mt-1">{{ $evaluation->module->code }}</p>
                            </div>

                            <!-- Semestre -->
                            <div class="bg-muted/30 rounded-lg p-4 border border-border/50">
                                <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Semestre</p>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold {{ $evaluation->semestre == 1 ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                    <span class="w-2 h-2 rounded-full {{ $evaluation->semestre == 1 ? 'bg-green-600' : 'bg-blue-600' }}"></span>
                                    S{{ $evaluation->semestre }}
                                </span>
                            </div>

                            <!-- Année Académique -->
                            <div class="bg-muted/30 rounded-lg p-4 border border-border/50">
                                <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Année Académique</p>
                                <p class="text-sm font-semibold text-foreground">{{ $evaluation->anneeAcademique->libelle }}</p>
                            </div>

                            <!-- Crédits -->
                            <div class="bg-muted/30 rounded-lg p-4 border border-border/50">
                                <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Crédits</p>
                                <p class="text-sm font-semibold text-foreground">{{ $evaluation->module->coefficient ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2 : Modification de la Note -->
                    <div class="space-y-6">
                        <h2 class="text-lg font-semibold text-foreground flex items-center gap-2">
                            <svg class="w-5 h-5 text-accent" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Nouvelle Note
                        </h2>

                        <!-- Input Note -->
                        <div>
                            <label for="note" class="block text-sm font-semibold text-foreground mb-2">
                                <span class="text-destructive">*</span> Note (0-20)
                            </label>
                            <div class="relative">
                                <input type="number" name="note" id="note" min="0" max="20" step="0.01" 
                                       class="w-full px-4 py-3 rounded-lg border border-border bg-background text-foreground text-lg font-semibold focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('note') border-destructive ring-2 ring-destructive/20 @enderror" 
                                       placeholder="0.00" value="{{ old('note', $evaluation->note) }}" required onchange="updateNoteAppreciation()" oninput="updateNoteAppreciation()">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-muted-foreground font-bold text-lg">/20</span>
                            </div>
                            @error('note')
                                <p class="mt-2 text-sm text-destructive flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Note Slider (optionnel) -->
                        <div class="pt-2">
                            <input type="range" id="noteSlider" min="0" max="20" step="0.1" 
                                   value="{{ old('note', $evaluation->note) }}"
                                   class="w-full h-2 bg-border rounded-lg appearance-none cursor-pointer accent-primary"
                                   onchange="document.getElementById('note').value = this.value; updateNoteAppreciation()"
                                   oninput="document.getElementById('note').value = this.value; updateNoteAppreciation()">
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex items-center justify-between pt-6 border-t border-border gap-4">
                        <a href="{{ route('evaluations.index') }}" 
                           class="px-6 py-2.5 text-foreground bg-muted hover:bg-muted/80 rounded-lg font-medium transition-all duration-200">
                            Annuler
                        </a>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('evaluations.show', $evaluation) }}" 
                               class="px-6 py-2.5 text-primary bg-primary/10 hover:bg-primary/20 rounded-lg font-medium transition-all duration-200 border border-primary/20">
                                Voir détails
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Colonne 2 : Panneaux Informatifs (1/3) -->
        <div class="lg:col-span-1 space-y-6">

            <!-- Note Actuelle -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100/50 dark:from-purple-950/20 dark:to-purple-900/10 border border-purple-200 dark:border-purple-800 rounded-xl p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <h3 class="text-sm font-bold text-purple-900 dark:text-purple-100 uppercase tracking-wide">Note Actuelle</h3>
                </div>
                <div class="space-y-3">
                    <div class="bg-white dark:bg-background/50 rounded-lg p-4 text-center">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1">Score</p>
                        <p class="text-3xl font-bold {{ $evaluation->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format($evaluation->note, 2) }}
                        </p>
                        <p class="text-xs text-muted-foreground mt-2">/20</p>
                    </div>
                    <div class="bg-white dark:bg-background/50 rounded-lg p-4 text-center">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Appréciation</p>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold 
                            @if($evaluation->note >= 16) bg-green-100 text-green-700
                            @elseif($evaluation->note >= 14) bg-green-100 text-green-700
                            @elseif($evaluation->note >= 12) bg-yellow-100 text-yellow-700
                            @elseif($evaluation->note >= 10) bg-orange-100 text-orange-700
                            @else bg-red-100 text-red-700
                            @endif">
                            {{ $evaluation->getAppreciation() }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Nouvelle Note (Aperçu) -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50/50 dark:from-green-950/20 dark:to-emerald-900/10 border border-green-200 dark:border-green-800 rounded-xl p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <h3 class="text-sm font-bold text-green-900 dark:text-green-100 uppercase tracking-wide">Aperçu</h3>
                </div>
                <div class="space-y-3">
                    <div class="bg-white dark:bg-background/50 rounded-lg p-4 text-center">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1">Nouvelle Note</p>
                        <p class="text-3xl font-bold text-primary" id="newNoteDisplay">
                            {{ number_format($evaluation->note, 2) }}
                        </p>
                        <p class="text-xs text-muted-foreground mt-2">/20</p>
                    </div>
                    <div class="bg-white dark:bg-background/50 rounded-lg p-4 text-center">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Appréciation</p>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700" id="newAppreciationBadge">
                            {{ $evaluation->getAppreciation() }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Comparaison Avant/Après -->
            <div class="bg-card border border-border rounded-xl p-5">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-accent" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                    <h3 class="text-sm font-bold text-foreground uppercase tracking-wide">Comparaison</h3>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center justify-between p-3 bg-muted/30 rounded-lg">
                        <span class="text-muted-foreground">Avant</span>
                        <span class="font-bold text-foreground">{{ number_format($evaluation->note, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-center py-2">
                        <svg class="w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-primary/10 rounded-lg border border-primary/20">
                        <span class="text-primary font-medium">Après</span>
                        <span class="font-bold text-primary" id="comparisonNewNote">{{ number_format($evaluation->note, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Historique -->
            <div class="bg-card border border-border rounded-xl p-5">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-muted-foreground" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h12a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    <h3 class="text-sm font-bold text-foreground uppercase tracking-wide">Historique</h3>
                </div>
                <div class="space-y-2 text-xs text-muted-foreground">
                    <div class="flex items-start gap-2 p-2 bg-muted/30 rounded">
                        <span class="text-primary font-bold">+</span>
                        <div>
                            <p class="font-medium text-foreground">Créée</p>
                            <p>{{ $evaluation->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2 p-2 bg-muted/30 rounded">
                        <span class="text-accent font-bold">✏️</span>
                        <div>
                            <p class="font-medium text-foreground">Modifiée</p>
                            <p>{{ $evaluation->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aide -->
            <div class="bg-blue-50 dark:bg-blue-950/20 border border-blue-200 dark:border-blue-800 rounded-xl p-5">
                <div class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="text-xs font-bold text-blue-900 dark:text-blue-100 uppercase tracking-wide mb-2">💡 Aide</h3>
                        <ul class="text-xs text-blue-800 dark:text-blue-200 space-y-1.5">
                            <li class="flex items-start gap-1.5">
                                <span class="font-bold">•</span>
                                <span>Modifiez la note (0-20)</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="font-bold">•</span>
                                <span>Appréciation auto</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="font-bold">•</span>
                                <span>Utilisez le slider</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="font-bold">•</span>
                                <span>Vérifiez l'aperçu</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection

@push('styles')
<style>
    /* Input number styling */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

    /* Range slider styling */
    input[type="range"] {
        -webkit-appearance: none;
        appearance: none;
    }

    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: hsl(var(--primary));
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        transition: all 0.2s;
    }

    input[type="range"]::-webkit-slider-thumb:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    input[type="range"]::-moz-range-thumb {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: hsl(var(--primary));
        cursor: pointer;
        border: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        transition: all 0.2s;
    }

    input[type="range"]::-moz-range-thumb:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    /* Smooth transitions */
    * {
        @apply transition-colors duration-200;
    }
</style>
@endpush

@push('scripts')
<script>
function updateNoteAppreciation() {
    const note = parseFloat(document.getElementById('note').value) || 0;
    const newNoteDisplay = document.getElementById('newNoteDisplay');
    const newAppreciationBadge = document.getElementById('newAppreciationBadge');
    const comparisonNewNote = document.getElementById('comparisonNewNote');
    const noteSlider = document.getElementById('noteSlider');
    
    let appreciation = '';
    let badgeClass = '';
    let emoji = '';
    
    if (note >= 16) {
        appreciation = 'Très Bien';
        badgeClass = 'bg-green-100 text-green-700';
        emoji = '🌟';
    } else if (note >= 14) {
        appreciation = 'Bien';
        badgeClass = 'bg-green-100 text-green-700';
        emoji = '✅';
    } else if (note >= 12) {
        appreciation = 'Assez Bien';
        badgeClass = 'bg-yellow-100 text-yellow-700';
        emoji = '👍';
    } else if (note >= 10) {
        appreciation = 'Passable';
        badgeClass = 'bg-orange-100 text-orange-700';
        emoji = '⚠️';
    } else if (note > 0) {
        appreciation = 'Insuffisant';
        badgeClass = 'bg-red-100 text-red-700';
        emoji = '❌';
    } else {
        appreciation = 'Aucune note';
        badgeClass = 'bg-gray-100 text-gray-700';
        emoji = '📝';
    }
    
    // Mise à jour de l'affichage
    newNoteDisplay.textContent = note.toFixed(2);
    newNoteDisplay.className = `text-3xl font-bold ${note >= 10 ? 'text-green-600' : 'text-red-600'}`;
    
    newAppreciationBadge.className = `inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold ${badgeClass}`;
    newAppreciationBadge.innerHTML = `${emoji} ${appreciation}`;
    
    comparisonNewNote.textContent = note.toFixed(2);
    
    // Synchroniser le slider
    noteSlider.value = note;
}

document.addEventListener('DOMContentLoaded', function() {
    updateNoteAppreciation();
});
</script>
@endpush
