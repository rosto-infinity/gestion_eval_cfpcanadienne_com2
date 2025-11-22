@extends('layouts.app')

@section('title', 'Modifier l\'Évaluation')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- En-tête -->
    <div class="mb-6">
        <a href="{{ route('evaluations.index') }}" class="text-indigo-600 hover:text-indigo-900 inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Retour aux évaluations
        </a>
    </div>

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Modifier l'Évaluation</h1>
        <p class="mt-2 text-sm text-gray-700">Mettre à jour la note de l'étudiant</p>
    </div>

    <!-- Formulaire -->
    <div class="bg-white rounded-lg shadow">
        <form action="{{ route('evaluations.update', $evaluation) }}" method="POST" class="space-y-6 p-6">
            @csrf
            @method('PUT')

            <!-- Informations de l'étudiant (lecture seule) -->
            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                <h3 class="text-sm font-semibold text-blue-900 mb-4">📋 Informations de l'Évaluation</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide">Étudiant</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $evaluation->user->getFullName() }}</p>
                        <p class="text-xs text-gray-500">{{ $evaluation->user->matricule }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide">Spécialité</p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $evaluation->user->specialite?->intitule ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide">Module</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $evaluation->module->intitule }}</p>
                        <p class="text-xs text-gray-500">{{ $evaluation->module->code }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide">Semestre</p>
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $evaluation->semestre == 1 ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                            Semestre {{ $evaluation->semestre }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide">Année Académique</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $evaluation->anneeAcademique->libelle }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide">Crédits</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $evaluation->module->credit }}</p>
                    </div>
                </div>
            </div>

            <!-- Note actuelle -->
            <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                <h3 class="text-sm font-semibold text-purple-900 mb-3">📊 Note Actuelle</h3>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide">Note</p>
                        <p class="text-3xl font-bold {{ $evaluation->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format($evaluation->note, 2) }}/20
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide">Appréciation</p>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                            @if($evaluation->note >= 16) bg-green-100 text-green-800
                            @elseif($evaluation->note >= 14) bg-green-100 text-green-800
                            @elseif($evaluation->note >= 12) bg-yellow-100 text-yellow-800
                            @elseif($evaluation->note >= 10) bg-orange-100 text-orange-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $evaluation->getAppreciation() }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Nouvelle note -->
            <div>
                <label for="note" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="text-red-500">*</span> Nouvelle Note (0-20)
                </label>
                <div class="relative">
                    <input type="number" name="note" id="note" min="0" max="20" step="0.01" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('note') border-red-500 @enderror" 
                           placeholder="Entrer la nouvelle note" value="{{ old('note', $evaluation->note) }}" required onchange="updateNoteAppreciation()">
                    <span class="absolute right-3 top-3 text-gray-500">/20</span>
                </div>
                @error('note')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nouvelle appréciation -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nouvelle Appréciation</label>
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-sm text-gray-600" id="appreciationText">Appréciation</p>
                    <div class="mt-2" id="appreciationBadge"></div>
                </div>
            </div>

            <!-- Comparaison avant/après -->
            <div class="bg-amber-50 rounded-lg p-4 border border-amber-200">
                <h3 class="text-sm font-semibold text-amber-900 mb-3">🔄 Comparaison</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide mb-2">Avant</p>
                        <div class="p-3 bg-white rounded border border-gray-200">
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($evaluation->note, 2) }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $evaluation->getAppreciation() }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide mb-2">Après</p>
                        <div class="p-3 bg-white rounded border border-gray-200">
                            <p class="text-2xl font-bold text-indigo-600" id="newNoteDisplay">{{ number_format($evaluation->note, 2) }}</p>
                            <p class="text-xs text-gray-500 mt-1" id="newAppreciationDisplay">{{ $evaluation->getAppreciation() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historique -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">📅 Historique</h3>
                <div class="space-y-2 text-sm text-gray-600">
                    <p>✓ Créée le: {{ $evaluation->created_at->format('d/m/Y à H:i') }}</p>
                    <p>✏️ Dernière modification: {{ $evaluation->updated_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('evaluations.index') }}" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                    Annuler
                </a>
                <div class="space-x-3">
                    <a href="{{ route('evaluations.show', $evaluation) }}" class="px-4 py-2 text-indigo-600 bg-indigo-50 rounded-md hover:bg-indigo-100">
                        Voir les détails
                    </a>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Enregistrer les modifications
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Aide -->
    <div class="mt-6 bg-blue-50 rounded-lg p-4 border border-blue-200">
        <h3 class="text-sm font-semibold text-blue-900 mb-2">💡 Aide</h3>
        <ul class="text-sm text-blue-800 space-y-1">
            <li>• Vous pouvez uniquement modifier la note</li>
            <li>• Les autres informations sont verrouillées</li>
            <li>• L'appréciation s'affiche automatiquement selon la nouvelle note</li>
            <li>• Comparez les valeurs avant et après pour vérifier vos modifications</li>
        </ul>
    </div>
</div>

@endsection

@push('scripts')
<script>
function updateNoteAppreciation() {
    const note = parseFloat(document.getElementById('note').value) || 0;
    const appreciationText = document.getElementById('appreciationText');
    const appreciationBadge = document.getElementById('appreciationBadge');
    const newNoteDisplay = document.getElementById('newNoteDisplay');
    const newAppreciationDisplay = document.getElementById('newAppreciationDisplay');
    
    let appreciation = '';
    let badgeClass = '';
    
    if (note >= 16) {
        appreciation = 'Très Bien';
        badgeClass = 'bg-green-100 text-green-800';
    } else if (note >= 14) {
        appreciation = 'Bien';
        badgeClass = 'bg-green-100 text-green-800';
    } else if (note >= 12) {
        appreciation = 'Assez Bien';
        badgeClass = 'bg-yellow-100 text-yellow-800';
    } else if (note >= 10) {
        appreciation = 'Passable';
        badgeClass = 'bg-orange-100 text-orange-800';
    } else if (note > 0) {
        appreciation = 'Insuffisant';
        badgeClass = 'bg-red-100 text-red-800';
    } else {
        appreciation = 'Aucune note';
        badgeClass = 'bg-gray-100 text-gray-800';
    }
    
    appreciationText.textContent = appreciation;
    appreciationBadge.innerHTML = `<span class="px-3 py-1 text-xs font-semibold rounded-full ${badgeClass}">${appreciation}</span>`;
    
    // Mise à jour de la comparaison
    newNoteDisplay.textContent = note.toFixed(2);
    newAppreciationDisplay.textContent = appreciation;
    
    // Changement de couleur selon la note
    if (note >= 10) {
        newNoteDisplay.className = 'text-2xl font-bold text-green-600';
    } else {
        newNoteDisplay.className = 'text-2xl font-bold text-red-600';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    updateNoteAppreciation();
});
</script>
@endpush
