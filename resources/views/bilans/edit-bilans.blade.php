@extends('layouts.app')

@section('title', 'Modifier le bilan de compétences')

@section('content')
<div class="mb-6">
    <a href="{{ route('bilans.show', $bilan) }}" class="text-blue-600 hover:text-blue-900 inline-flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour aux détails
    </a>
</div>

<!-- Informations de l'étudiant -->
<div class="card mb-6">
    <div class="card-body bg-blue-50">
        <div class="flex items-start">
            <svg class="h-6 w-6 text-blue-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-blue-800">Informations de l'étudiant</h3>
                <div class="mt-2 text-sm text-blue-700 grid grid-cols-2 gap-4">
                    <div>
                        <span class="font-medium">Matricule:</span> {{ $bilan->user->matricule }}
                    </div>
                    <div>
                        <span class="font-medium">Nom:</span> {{ $bilan->user->name }}
                    </div>
                    <div>
                        <span class="font-medium">Spécialité:</span> {{ $bilan->user->specialite->intitule }}
                    </div>
                    <div>
                        <span class="font-medium">Année:</span> {{ $bilan->anneeAcademique->libelle }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="text-xl font-semibold text-gray-800">Modifier le bilan de compétences</h2>
    </div>
    <div class="card-body">
        <!-- Résumé des moyennes actuelles -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="p-4 bg-blue-50 rounded-lg">
                <p class="text-xs text-gray-600 mb-1">Moy. Évaluations (30%)</p>
                <p class="text-2xl font-bold text-blue-600">
                    {{ $bilan->moy_evaluations ? number_format($bilan->moy_evaluations, 2) : '-' }}
                </p>
                <p class="text-xs text-gray-500 mt-1">Calculée automatiquement</p>
            </div>

            <div class="p-4 bg-purple-50 rounded-lg">
                <p class="text-xs text-gray-600 mb-1">Moy. Compétences (70%)</p>
                <p class="text-2xl font-bold text-purple-600">
                    {{ $bilan->moy_competences ? number_format($bilan->moy_competences, 2) : '-' }}
                </p>
                <p class="text-xs text-gray-500 mt-1">À modifier ci-dessous</p>
            </div>

            <div class="p-4 {{ $bilan->isAdmis() ? 'bg-green-50' : 'bg-red-50' }} rounded-lg">
                <p class="text-xs text-gray-600 mb-1">Moyenne Générale</p>
                <p class="text-3xl font-bold {{ $bilan->isAdmis() ? 'text-green-600' : 'text-red-600' }}">
                    {{ $bilan->moyenne_generale ? number_format($bilan->moyenne_generale, 2) : '-' }}
                </p>
                <p class="text-xs text-gray-500 mt-1">{{ $bilan->getMention() }}</p>
            </div>
        </div>

        <form action="{{ route('bilans.update', $bilan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Nouvelle moyenne des compétences -->
                <div>
                    <label for="moy_competences" class="block text-sm font-medium text-gray-700 mb-2">
                        Nouvelle moyenne du bilan des compétences (70%) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="moy_competences" 
                           id="moy_competences" 
                           min="0" 
                           max="20" 
                           step="0.01" 
                           value="{{ old('moy_competences', $bilan->moy_competences) }}"
                           class="mt-1 block w-full text-2xl font-bold rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('moy_competences') border-red-500 @enderror"
                           required>
                    @error('moy_competences')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Cette note représente 70% de la moyenne générale finale
                    </p>
                </div>

                <!-- Aperçu du nouveau calcul -->
                <div id="calculation-preview" class="p-6 bg-gradient-to-r from-purple-50 to-blue-50 rounded-lg border-2 border-purple-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Aperçu du nouveau calcul</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-600 mb-3">Valeurs actuelles</p>
                            <div class="space-y-2">
                                <div class="flex justify-between p-2 bg-white rounded">
                                    <span class="text-sm text-gray-600">Moy. Compétences:</span>
                                    <span class="font-bold text-purple-600">{{ number_format($bilan->moy_competences, 2) }}</span>
                                </div>
                                <div class="flex justify-between p-2 bg-white rounded">
                                    <span class="text-sm text-gray-600">Moy. Générale:</span>
                                    <span class="font-bold {{ $bilan->isAdmis() ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($bilan->moyenne_generale, 2) }}
                                    </span>
                                </div>
                                <div class="flex justify-between p-2 bg-white rounded">
                                    <span class="text-sm text-gray-600">Mention:</span>
                                    <span class="font-bold text-gray-900">{{ $bilan->getMention() }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-3">Nouvelles valeurs</p>
                            <div class="space-y-2">
                                <div class="flex justify-between p-2 bg-white rounded">
                                    <span class="text-sm text-gray-600">Moy. Compétences:</span>
                                    <span class="font-bold text-purple-600" id="new-comp">{{ number_format($bilan->moy_competences, 2) }}</span>
                                </div>
                                <div class="flex justify-between p-2 bg-white rounded">
                                    <span class="text-sm text-gray-600">Moy. Générale:</span>
                                    <span class="font-bold" id="new-general">{{ number_format($bilan->moyenne_generale, 2) }}</span>
                                </div>
                                <div class="flex justify-between p-2 bg-white rounded">
                                    <span class="text-sm text-gray-600">Mention:</span>
                                    <span class="font-bold text-gray-900" id="new-mention">{{ $bilan->getMention() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600 mb-2">Impact de la modification</p>
                        <p class="text-2xl font-bold" id="difference-text">-</p>
                    </div>
                </div>

                <!-- Observations -->
                <div>
                    <label for="observations" class="block text-sm font-medium text-gray-700 mb-2">
                        Observations
                    </label>
                    <textarea name="observations" 
                              id="observations" 
                              rows="4" 
                              placeholder="Remarques, commentaires, recommandations..."
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('observations') border-red-500 @enderror">{{ old('observations', $bilan->observations) }}</textarea>
                    @error('observations')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Maximum 1000 caractères</p>
                </div>

                <!-- Avertissement -->
                <div class="p-4 bg-yellow-50 border-l-4 border-yellow-400">
                    <div class="flex">
                        <svg class="h-5 w-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-yellow-800">Attention</p>
                            <p class="text-sm text-yellow-700 mt-1">
                                La modification de la moyenne des compétences recalculera automatiquement la moyenne générale de l'étudiant.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('bilans.show', $bilan) }}" class="btn btn-secondary">
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Mettre à jour le bilan
                </button>
            </div>
        </form>
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
        return note >= 10 ? 'text-green-600' : 'text-red-600';
    }
    
    moyCompetencesInput.addEventListener('input', function() {
        const newMoyComp = parseFloat(this.value);
        
        if (!isNaN(newMoyComp) && newMoyComp >= 0 && newMoyComp <= 20) {
            const newMoyGeneral = (moyEval * 0.30) + (newMoyComp * 0.70);
            const difference = newMoyGeneral - oldMoyGeneral;
            const diffFormatted = difference > 0 ? `+${difference.toFixed(2)}` : difference.toFixed(2);
            const diffColor = difference > 0 ? 'text-green-600' : (difference < 0 ? 'text-red-600' : 'text-gray-600');
            
            newCompDisplay.textContent = newMoyComp.toFixed(2);
            newGeneralDisplay.textContent = newMoyGeneral.toFixed(2);
            newGeneralDisplay.className = `font-bold ${getColor(newMoyGeneral)}`;
            newMentionDisplay.textContent = getMention(newMoyGeneral);
            
            differenceText.textContent = `${diffFormatted} points`;
            differenceText.className = `text-2xl font-bold ${diffColor}`;
        }
    });
    
    // Déclencher l'événement au chargement
    moyCompetencesInput.dispatchEvent(new Event('input'));
});
</script>
@endpush