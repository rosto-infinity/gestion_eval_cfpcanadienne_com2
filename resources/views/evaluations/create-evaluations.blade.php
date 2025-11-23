@extends('layouts.app')

@section('title', 'Nouvelle Évaluation')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

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
        <h1 class="text-3xl font-bold text-foreground">📝 Nouvelle Évaluation</h1>
        <p class="mt-2 text-sm text-muted-foreground">
            Créer une nouvelle évaluation pour un étudiant
        </p>
    </div>

    <!-- Layout 2 colonnes -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Colonne 1 : Formulaire Principal (2/3) -->
        <div class="lg:col-span-2">
            <div class="bg-card border border-border rounded-lg shadow-sm overflow-hidden">
                <form action="{{ route('evaluations.store') }}" method="POST" id="evaluationForm" class="space-y-6 p-6 sm:p-8">
                    @csrf

                    <!-- Section 1 : Sélection Étudiant & Module -->
                    <div class="space-y-6 pb-6 border-b border-border">
                        <h2 class="text-lg font-semibold text-foreground flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.5 1.5H5.75A2.25 2.25 0 003.5 3.75v12.5A2.25 2.25 0 005.75 18.5h8.5a2.25 2.25 0 002.25-2.25V6.5m-10-5v5m5-5v5m-8 0h16"/>
                            </svg>
                            Informations Générales
                        </h2>

                        <!-- Sélection de l'étudiant -->
                        <div>
                            <label for="user_id" class="block text-sm font-semibold text-foreground mb-2">
                                <span class="text-destructive">*</span> Étudiant
                            </label>
                            <select name="user_id" id="user_id" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('user_id') border-destructive ring-2 ring-destructive/20 @enderror" 
                                    required onchange="updateUserInfo()">
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
                                <p class="mt-2 text-sm text-destructive flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Sélection du module -->
                        <div>
                            <label for="module_id" class="block text-sm font-semibold text-foreground mb-2">
                                <span class="text-destructive">*</span> Module
                            </label>
                            <select name="module_id" id="module_id" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('module_id') border-destructive ring-2 ring-destructive/20 @enderror" 
                                    required onchange="updateModuleInfo()">
                                <option value="">-- Sélectionner un module --</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}" 
                                            data-code="{{ $module->code }}"
                                            data-semestre="{{ $module->ordre }}"
                                            data-credit="{{ $module->coefficient }}"
                                            {{ old('module_id') == $module->id ? 'selected' : '' }}>
                                        {{ $module->code }} - {{ $module->intitule }}
                                    </option>
                                @endforeach
                            </select>
                            @error('module_id')
                                <p class="mt-2 text-sm text-destructive flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Section 2 : Paramètres d'Évaluation -->
                    <div class="space-y-6 pb-6 border-b border-border">
                        <h2 class="text-lg font-semibold text-foreground flex items-center gap-2">
                            <svg class="w-5 h-5 text-accent" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2 4 4 0 00-4 4v10a4 4 0 004 4h12a4 4 0 004-4V5a4 4 0 00-4-4 1 1 0 000 2 2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V5z" clip-rule="evenodd"/>
                            </svg>
                            Paramètres
                        </h2>

                        <!-- Semestre -->
                        <div>
                            <label class="block text-sm font-semibold text-foreground mb-3">
                                <span class="text-destructive">*</span> Semestre
                            </label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="semestre" value="1" 
                                           class="w-4 h-4 rounded border-border text-primary focus:ring-2 focus:ring-primary/50 cursor-pointer" 
                                           {{ old('semestre', 1) == 1 ? 'checked' : '' }} required>
                                    <span class="text-sm font-medium text-foreground group-hover:text-primary transition-colors">Semestre 1</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="semestre" value="2" 
                                           class="w-4 h-4 rounded border-border text-primary focus:ring-2 focus:ring-primary/50 cursor-pointer" 
                                           {{ old('semestre') == 2 ? 'checked' : '' }} required>
                                    <span class="text-sm font-medium text-foreground group-hover:text-primary transition-colors">Semestre 2</span>
                                </label>
                            </div>
                            @error('semestre')
                                <p class="mt-2 text-sm text-destructive flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Année Académique -->
                        <div>
                            <label for="annee_academique_id" class="block text-sm font-semibold text-foreground mb-2">
                                <span class="text-destructive">*</span> Année Académique
                            </label>
                            <select name="annee_academique_id" id="annee_academique_id" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('annee_academique_id') border-destructive ring-2 ring-destructive/20 @enderror" 
                                    required>
                                <option value="">-- Sélectionner une année --</option>
                                @foreach($annees as $annee)
                                    <option value="{{ $annee->id }}" {{ old('annee_academique_id') == $annee->id ? 'selected' : '' }}>
                                        {{ $annee->libelle }} {{ $annee->is_active ? '(Active)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('annee_academique_id')
                                <p class="mt-2 text-sm text-destructive flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Section 3 : Évaluation -->
                    <div class="space-y-6">
                        <h2 class="text-lg font-semibold text-foreground flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Note & Appréciation
                        </h2>

                        <!-- Note -->
                        <div>
                            <label for="note" class="block text-sm font-semibold text-foreground mb-2">
                                <span class="text-destructive">*</span> Note (0-20)
                            </label>
                            <div class="relative">
                                <input type="number" name="note" id="note" min="0" max="20" step="0.01" 
                                       class="w-full px-4 py-3 rounded-lg border border-border bg-background text-foreground text-lg font-semibold focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('note') border-destructive ring-2 ring-destructive/20 @enderror" 
                                       placeholder="0.00" value="{{ old('note') }}" required onchange="updateNoteAppreciation()" oninput="updateNoteAppreciation()">
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
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex items-center justify-between pt-6 border-t border-border gap-4">
                        <a href="{{ route('evaluations.index') }}" 
                           class="px-6 py-2.5 text-foreground bg-muted hover:bg-muted/80 rounded-lg font-medium transition-all duration-200">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Créer l'évaluation
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Colonne 2 : Panneaux d'Information (1/3) -->
        <div class="lg:col-span-1 space-y-6">

            <!-- Informations de l'étudiant -->
            <div class="bg-primary/5 border border-primary/20 rounded-lg p-5 hidden" id="userInfo">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                    </svg>
                    <h3 class="text-sm font-bold text-foreground uppercase tracking-wide">Étudiant</h3>
                </div>
                <div class="space-y-3">
                    <div class="bg-white dark:bg-background/50 rounded p-3">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1">Spécialité</p>
                        <p class="text-sm font-semibold text-foreground" id="specialiteDisplay">-</p>
                    </div>
                    <div class="bg-white dark:bg-background/50 rounded p-3">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1">Année Académique</p>
                        <p class="text-sm font-semibold text-foreground" id="anneeDisplay">-</p>
                    </div>
                    <div class="bg-white dark:bg-background/50 rounded p-3">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1">Statut</p>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                            <span class="w-2 h-2 rounded-full bg-green-600"></span>
                            Actif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Informations du module -->
            <div class="bg-accent/5 border border-accent/20 rounded-lg p-5 hidden" id="moduleInfo">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-accent" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.669 0-3.218.51-4.5 1.385A7.968 7.968 0 009 4.804z"/>
                    </svg>
                    <h3 class="text-sm font-bold text-foreground uppercase tracking-wide">Module</h3>
                </div>
                <div class="space-y-3">
                    <div class="bg-white dark:bg-background/50 rounded p-3">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1">Code</p>
                        <p class="text-sm font-semibold text-foreground font-mono" id="codeDisplay">-</p>
                    </div>
                    <div class="bg-white dark:bg-background/50 rounded p-3">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1">Semestre</p>
                        <p class="text-sm font-semibold text-foreground" id="semestreDisplay">-</p>
                    </div>
                    <div class="bg-white dark:bg-background/50 rounded p-3">
                        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-1">Crédits</p>
                        <p class="text-sm font-semibold text-foreground" id="creditDisplay">-</p>
                    </div>
                </div>
            </div>

            <!-- Appréciation en temps réel -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-950/20 dark:to-emerald-950/20 border border-green-200 dark:border-green-800 rounded-lg p-5">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <h3 class="text-sm font-bold text-green-900 dark:text-green-100 uppercase tracking-wide">Appréciation</h3>
                </div>
                <div class="bg-white dark:bg-background/50 rounded-lg p-4 text-center">
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2" id="appreciationText">
                        Entrez une note
                    </p>
                    <div id="appreciationBadge" class="flex justify-center">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">
                            -
                        </span>
                    </div>
                </div>
            </div>

            <!-- Aide compacte -->
            <div class="bg-blue-50 dark:bg-blue-950/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="text-xs font-bold text-blue-900 dark:text-blue-100 uppercase tracking-wide mb-2">💡 Aide</h3>
                        <ul class="text-xs text-blue-800 dark:text-blue-200 space-y-1">
                            <li class="flex items-start gap-1.5">
                                <span class="font-bold">•</span>
                                <span>Note entre 0 et 20</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="font-bold">•</span>
                                <span>Appréciation auto</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="font-bold">•</span>
                                <span>Pas de doublons</span>
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
    /* Select styling */
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23666' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
        padding-right: 2.5rem;
        appearance: none;
    }

    @media (prefers-color-scheme: dark) {
        select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23aaa' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        }
    }

    /* Input number styling */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

    /* Radio button styling */
    input[type="radio"] {
        cursor: pointer;
    }

    input[type="radio"]:checked {
        @apply ring-2 ring-offset-2 ring-primary;
    }

    /* Smooth transitions */
    * {
        @apply transition-colors duration-200;
    }

    /* Gradient text */
    .gradient-text {
        @apply bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent;
    }
</style>
@endpush

@push('scripts')
<script>
function updateUserInfo() {
    const select = document.getElementById('user_id');
    const option = select.options[select.selectedIndex];
    const userInfo = document.getElementById('userInfo');
    
    if (select.value) {
        document.getElementById('specialiteDisplay').textContent = option.dataset.specialite || '-';
        document.getElementById('anneeDisplay').textContent = option.dataset.annee || '-';
        userInfo.classList.remove('hidden');
    } else {
        userInfo.classList.add('hidden');
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
        moduleInfo.classList.remove('hidden');
        
        // Mettre à jour le semestre automatiquement
        const semestreValue = option.dataset.semestre;
        if (semestreValue) {
            document.querySelector(`input[name="semestre"][value="${semestreValue}"]`).checked = true;
        }
    } else {
        moduleInfo.classList.add('hidden');
    }
}

function updateNoteAppreciation() {
    const note = parseFloat(document.getElementById('note').value) || 0;
    const appreciationText = document.getElementById('appreciationText');
    const appreciationBadge = document.getElementById('appreciationBadge');
    
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
    
    appreciationText.textContent = appreciation;
    appreciationBadge.innerHTML = `<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold ${badgeClass}">${emoji} ${appreciation}</span>`;
}

document.addEventListener('DOMContentLoaded', function() {
    updateUserInfo();
    updateModuleInfo();
    updateNoteAppreciation();
});
</script>
@endpush
