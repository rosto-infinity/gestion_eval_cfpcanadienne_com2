@extends('layouts.app')

@section('title', 'Nouvelle Évaluation')

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
        <h1 class="text-3xl font-bold text-gray-900">Nouvelle Évaluation</h1>
        <p class="mt-2 text-sm text-gray-700">Créer une nouvelle évaluation pour un étudiant</p>
    </div>

    <!-- Formulaire -->
    <div class="bg-white rounded-lg shadow">
        <form action="{{ route('evaluations.store') }}" method="POST" class="space-y-6 p-6">
            @csrf

            <!-- Sélection de l'étudiant -->
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="text-red-500">*</span> Étudiant
                </label>
                <select name="user_id" id="user_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('user_id') border-red-500 @enderror" required onchange="updateUserInfo()">
                    <option value="">-- Sélectionner un étudiant --</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" 
                            data-specialite="{{ $user->specialite?->intitule }}"
                            data-annee="{{ $user->anneeAcademique?->libelle }}"
                            data-annee-id="{{ $user->annee_academique_id }}"
                            {{ old('user_id') == $user->id || $user?->id == request('user_id') ? 'selected' : '' }}>
                        {{ $user->matricule }} - {{ $user->getFullName() }}
                    </option>
                    @endforeach
                </select>
                @error('user_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Informations de l'étudiant -->
            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200" id="userInfo" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide">Spécialité</p>
                        <p class="text-sm font-semibold text-gray-900" id="specialiteDisplay">-</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide">Année Académique</p>
                        <p class="text-sm font-semibold text-gray-900" id="anneeDisplay">-</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide">Statut</p>
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Actif</span>
                    </div>
                </div>
            </div>

            <!-- Sélection du module -->
            <div>
                <label for="module_id" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="text-red-500">*</span> Module
                </label>
                <select name="module_id" id="module_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('module_id') border-red-500 @enderror" required onchange="updateModuleInfo()">
                    <option value="">-- Sélectionner un module --</option>
                    @foreach($modules as $module)
                    <option value="{{ $module->id }}" 
                            data-code="{{ $module->code }}"
                            data-semestre="{{ $module->ordre }}"
                            data-credit="{{ $module->coefficient}}"
                            {{ old('module_id') == $module->id ? 'selected' : '' }}>
                        {{ $module->code }} - {{ $module->intitule }}
                    </option>
                    @endforeach
                </select>
                @error('module_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Informations du module -->
            <div class="bg-purple-50 rounded-lg p-4 border border-purple-200" id="moduleInfo" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide">Code</p>
                        <p class="text-sm font-semibold text-gray-900" id="codeDisplay">-</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide">Semestre</p>
                        <p class="text-sm font-semibold text-gray-900" id="semestreDisplay">-</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide">Crédits</p>
                        <p class="text-sm font-semibold text-gray-900" id="creditDisplay">-</p>
                    </div>
                </div>
            </div>

            <!-- Semestre -->
            <div>
                <label for="semestre" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="text-red-500">*</span> Semestre
                </label>
                <div class="flex space-x-4">
                    <label class="flex items-center">
                        <input type="radio" name="semestre" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ old('semestre', 1) == 1 ? 'checked' : '' }} required>
                        <span class="ml-2 text-sm text-gray-700">Semestre 1</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="semestre" value="2" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ old('semestre') == 2 ? 'checked' : '' }} required>
                        <span class="ml-2 text-sm text-gray-700">Semestre 2</span>
                    </label>
                </div>
                @error('semestre')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Année Académique -->
            <div>
                <label for="annee_academique_id" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="text-red-500">*</span> Année Académique
                </label>
                <select name="annee_academique_id" id="annee_academique_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('annee_academique_id') border-red-500 @enderror" required>
                    <option value="">-- Sélectionner une année --</option>
                    @foreach($annees as $annee)
                    <option value="{{ $annee->id }}" {{ old('annee_academique_id') == $annee->id ? 'selected' : '' }}>
                        {{ $annee->libelle }} {{ $annee->is_active ? '(Active)' : '' }}
                    </option>
                    @endforeach
                </select>
                @error('annee_academique_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Note -->
            <div>
                <label for="note" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="text-red-500">*</span> Note (0-20)
                </label>
                <div class="relative">
                    <input type="number" name="note" id="note" min="0" max="20" step="0.01" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('note') border-red-500 @enderror" 
                           placeholder="Entrer la note" value="{{ old('note') }}" required onchange="updateNoteAppreciation()">
                    <span class="absolute right-3 top-3 text-gray-500">/20</span>
                </div>
                @error('note')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Appréciation -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Appréciation</label>
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-sm text-gray-600" id="appreciationText">Entrez une note pour voir l'appréciation</p>
                    <div class="mt-2" id="appreciationBadge"></div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('evaluations.index') }}" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Créer l'évaluation
                </button>
            </div>
        </form>
    </div>

    <!-- Aide -->
    <div class="mt-6 bg-blue-50 rounded-lg p-4 border border-blue-200">
        <h3 class="text-sm font-semibold text-blue-900 mb-2">💡 Aide</h3>
        <ul class="text-sm text-blue-800 space-y-1">
            <li>• Tous les champs marqués avec <span class="text-red-500">*</span> sont obligatoires</li>
            <li>• La note doit être entre 0 et 20</li>
            <li>• L'appréciation s'affiche automatiquement selon la note</li>
            <li>• Vous ne pouvez pas créer deux évaluations identiques pour le même étudiant</li>
        </ul>
    </div>
</div>

@endsection

@push('scripts')
<script>
function updateUserInfo() {
    const select = document.getElementById('user_id');
    const option = select.options[select.selectedIndex];
    const userInfo = document.getElementById('userInfo');
    
    if (select.value) {
        document.getElementById('specialiteDisplay').textContent = option.dataset.specialite || '-';
        document.getElementById('anneeDisplay').textContent = option.dataset.annee || '-';
        userInfo.style.display = 'block';
    } else {
        userInfo.style.display = 'none';
    }
}

function updateModuleInfo() {
    const select = document.getElementById('module_id');
    const option = select.options[select.selectedIndex];
    const moduleInfo = document.getElementById('moduleInfo');
    
    if (select.value) {
        document.getElementById('codeDisplay').textContent = option.dataset.code || '-';
        document.getElementById('semestreDisplay').textContent = 'S' + (option.dataset.semestre || '-');
        document.getElementById('creditDisplay').textContent = option.dataset.credit || '-';
        moduleInfo.style.display = 'block';
        
        // Mettre à jour le semestre automatiquement
        document.querySelector(`input[name="semestre"][value="${option.dataset.semestre}"]`).checked = true;
    } else {
        moduleInfo.style.display = 'none';
    }
}

function updateNoteAppreciation() {
    const note = parseFloat(document.getElementById('note').value) || 0;
    const appreciationText = document.getElementById('appreciationText');
    const appreciationBadge = document.getElementById('appreciationBadge');
    
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
}

document.addEventListener('DOMContentLoaded', function() {
    updateUserInfo();
    updateModuleInfo();
    updateNoteAppreciation();
});
</script>
@endpush
