@extends('layouts.app')

@section('title', 'Saisie par Spécialité')

@section('content')
    <div class="mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Breadcrumb -->
        <div class="mb-8">
            <a href="{{ route('evaluations.index') }}"
                class="inline-flex items-center gap-2 text-primary hover:text-primary/80 font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour aux évaluations
            </a>
        </div>

        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-foreground">📊 Saisie des Notes par Spécialité</h1>
            <p class="mt-2 text-sm text-muted-foreground">
                Évaluer plusieurs étudiants d'une même spécialité pour un module donné
            </p>
        </div>

        <!-- Formulaire de filtres -->
        <div class="bg-card border border-border rounded-lg shadow-sm p-6 mb-6">
            <form method="GET" action="{{ route('saisir-par-specialite') }}" id="filterForm" class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <!-- Spécialité -->
                    <div>
                        <label for="specialite_id" class="block text-sm font-semibold text-foreground mb-2">
                            <span class="text-destructive">*</span> Spécialité
                        </label>
                        <select name="specialite_id" id="specialite_id"
                            class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50"
                            required onchange="loadModules()">
                            <option value="">-- Sélectionner --</option>
                            @foreach ($specialites as $spec)
                                <option value="{{ $spec->id }}" 
                                    {{ request('specialite_id') == $spec->id ? 'selected' : '' }}>
                                    {{ $spec->code }} - {{ $spec->intitule }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Semestre -->
                    <div>
                        <label for="semestre" class="block text-sm font-semibold text-foreground mb-2">
                            <span class="text-destructive">*</span> Semestre
                        </label>
                        <select name="semestre" id="semestre"
                            class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50"
                            required onchange="loadModules()">
                            <option value="1" {{ $semestre == 1 ? 'selected' : '' }}>Semestre 1</option>
                            <option value="2" {{ $semestre == 2 ? 'selected' : '' }}>Semestre 2</option>
                        </select>
                    </div>

                    <!-- Module -->
                    <div>
                        <label for="module_id" class="block text-sm font-semibold text-foreground mb-2">
                            <span class="text-destructive">*</span> Module
                        </label>
                        <div id="moduleLoading" class="hidden">
                            <div class="w-full px-4 py-2.5 rounded-lg border border-border bg-muted flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-sm">Chargement...</span>
                            </div>
                        </div>
                        <select name="module_id" id="module_id"
                            class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50"
                            required {{ !$specialite ? 'disabled' : '' }}>
                            <option value="">{{ $specialite ? '-- Sélectionner --' : '-- Sélectionner d\'abord une spécialité --' }}</option>
                            @foreach ($modules as $mod)
                                <option value="{{ $mod->id }}" 
                                    data-code="{{ $mod->code }}"
                                    data-coefficient="{{ $mod->coefficient }}"
                                    {{ request('module_id') == $mod->id ? 'selected' : '' }}>
                                    {{ $mod->code }} - {{ $mod->intitule }} (Coef. {{ $mod->coefficient }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bouton Charger -->
                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-medium transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Charger les étudiants
                        </button>
                    </div>

                </div>
            </form>
        </div>

        <!-- Informations du module -->
        @if($module)
        <div class="bg-primary/5 border border-primary/20 rounded-lg p-5 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-foreground">{{ $module->code }} - {{ $module->intitule }}</h3>
                    <p class="text-sm text-muted-foreground mt-1">
                        Spécialité: {{ $specialite->intitule }} | Semestre {{ $semestre }} | Coefficient: {{ $module->coefficient }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-muted-foreground">Année académique</p>
                    <p class="text-lg font-bold text-primary">{{ $anneeActive->libelle }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Formulaire de saisie des notes -->
        @if($students->isNotEmpty())
        <div class="bg-card border border-border rounded-lg shadow-sm overflow-hidden">
            <form action="{{ route('store-par-specialite') }}" method="POST" id="notesForm">
                @csrf
                
                <input type="hidden" name="specialite_id" value="{{ $specialite->id }}">
                <input type="hidden" name="module_id" value="{{ $module->id }}">
                <input type="hidden" name="semestre" value="{{ $semestre }}">
                <input type="hidden" name="annee_academique_id" value="{{ $anneeActive->id }}">

                <!-- En-tête du tableau -->
                <div class="bg-muted px-6 py-4 border-b border-border">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-bold text-foreground">Liste des étudiants</h2>
                            <p class="text-sm text-muted-foreground mt-1">{{ $students->count() }} étudiant(s) trouvé(s)</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="fillAllNotes(10)" 
                                class="px-3 py-1.5 text-xs font-medium bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200 transition-colors">
                                Tous à 10
                            </button>
                            <button type="button" onclick="clearAllNotes()" 
                                class="px-3 py-1.5 text-xs font-medium bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition-colors">
                                Effacer tout
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tableau des notes -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-muted/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-muted-foreground uppercase tracking-wider">
                                    #
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-muted-foreground uppercase tracking-wider">
                                    Matricule
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-muted-foreground uppercase tracking-wider">
                                    Nom & Prénom
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-muted-foreground uppercase tracking-wider w-48">
                                    Note (/20)
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-muted-foreground uppercase tracking-wider">
                                    Statut
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach ($students as $index => $student)
                            <tr class="hover:bg-muted/30 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-muted-foreground">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 text-sm font-mono font-semibold text-foreground">
                                    {{ $student->user->matricule }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-foreground">
                                    {{ $student->user->getFullName() }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="relative">
                                        <input type="number" 
                                            name="notes[{{ $student->user->id }}]" 
                                            id="note_{{ $student->user->id }}"
                                            min="0" 
                                            max="20" 
                                            step="0.01"
                                            value="{{ $student->note }}"
                                            class="w-full px-4 py-2 rounded-lg border border-border bg-background text-foreground font-semibold focus:outline-none focus:ring-2 focus:ring-primary/50 note-input"
                                            placeholder="0.00"
                                            onchange="updateRowAppreciation({{ $student->user->id }})"
                                            required>
                                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-muted-foreground text-sm">/20</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span id="appreciation_{{ $student->user->id }}" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold">
                                        @if($student->has_evaluation)
                                            @if($student->note >= 10)
                                                <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full">✓ Admis</span>
                                            @else
                                                <span class="bg-red-100 text-red-700 px-2.5 py-1 rounded-full">✗ Échec</span>
                                            @endif
                                        @else
                                            <span class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full">○ Nouveau</span>
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Statistiques en temps réel -->
                <div class="bg-muted/30 px-6 py-4 border-t border-border">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-background rounded-lg p-4">
                            <p class="text-xs font-semibold text-muted-foreground uppercase">Total</p>
                            <p class="text-2xl font-bold text-foreground" id="stat_total">{{ $students->count() }}</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <p class="text-xs font-semibold text-green-600 uppercase">Admis (≥10)</p>
                            <p class="text-2xl font-bold text-green-700" id="stat_admis">0</p>
                        </div>
                        <div class="bg-red-50 rounded-lg p-4">
                            <p class="text-xs font-semibold text-red-600 uppercase">Échecs (<10)</p>
                            <p class="text-2xl font-bold text-red-700" id="stat_echecs">0</p>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-4">
                            <p class="text-xs font-semibold text-blue-600 uppercase">Moyenne</p>
                            <p class="text-2xl font-bold text-blue-700" id="stat_moyenne">0.00</p>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="px-6 py-4 bg-muted/50 border-t border-border flex items-center justify-between gap-4">
                    <a href="{{ route('evaluations.index') }}"
                        class="px-6 py-2.5 text-foreground bg-background hover:bg-muted rounded-lg font-medium transition-all border border-border">
                        Annuler
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-medium transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Enregistrer les notes
                    </button>
                </div>
            </form>
        </div>
        @elseif($specialite && $module)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
            <svg class="w-12 h-12 text-yellow-600 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <h3 class="text-lg font-bold text-yellow-900 mb-2">Aucun étudiant trouvé</h3>
            <p class="text-sm text-yellow-800">Aucun étudiant inscrit dans cette spécialité pour l'année en cours.</p>
        </div>
        @endif

    </div>
@endsection

@push('scripts')
<script>
// Charger les modules par AJAX
function loadModules() {
    const specialiteId = document.getElementById('specialite_id').value;
    const semestre = document.getElementById('semestre').value;
    const moduleSelect = document.getElementById('module_id');
    const moduleLoading = document.getElementById('moduleLoading');

    if (!specialiteId || !semestre) {
        moduleSelect.innerHTML = '<option value="">-- Sélectionner d\'abord une spécialité --</option>';
        moduleSelect.disabled = true;
        return;
    }

    // Afficher le loading
    moduleSelect.classList.add('hidden');
    moduleLoading.classList.remove('hidden');

    fetch(`/api/evaluations/modules/${specialiteId}/${semestre}`)
        .then(response => response.json())
        .then(data => {
            moduleSelect.innerHTML = '<option value="">-- Sélectionner un module --</option>';
            
            if (data.success && data.modules.length > 0) {
                data.modules.forEach(module => {
                    const option = document.createElement('option');
                    option.value = module.id;
                    option.textContent = `${module.code} - ${module.intitule} (Coef. ${module.coefficient})`;
                    option.dataset.code = module.code;
                    option.dataset.coefficient = module.coefficient;
                    moduleSelect.appendChild(option);
                });
                moduleSelect.disabled = false;
            } else {
                moduleSelect.innerHTML = '<option value="">Aucun module disponible</option>';
                moduleSelect.disabled = true;
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            moduleSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        })
        .finally(() => {
            moduleSelect.classList.remove('hidden');
            moduleLoading.classList.add('hidden');
        });
}

// Remplir toutes les notes
function fillAllNotes(value) {
    document.querySelectorAll('.note-input').forEach(input => {
        input.value = value;
        updateRowAppreciation(input.id.replace('note_', ''));
    });
    updateGlobalStats();
}

// Effacer toutes les notes
function clearAllNotes() {
    if (confirm('Êtes-vous sûr de vouloir effacer toutes les notes ?')) {
        document.querySelectorAll('.note-input').forEach(input => {
            input.value = '';
            updateRowAppreciation(input.id.replace('note_', ''));
        });
        updateGlobalStats();
    }
}

// Mettre à jour l'appréciation d'une ligne
function updateRowAppreciation(userId) {
    const noteInput = document.getElementById(`note_${userId}`);
    const appreciationSpan = document.getElementById(`appreciation_${userId}`);
    const note = parseFloat(noteInput.value) || 0;

    let html = '';
    if (note >= 10) {
        html = '<span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full">✓ Admis</span>';
    } else if (note > 0) {
        html = '<span class="bg-red-100 text-red-700 px-2.5 py-1 rounded-full">✗ Échec</span>';
    } else {
        html = '<span class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full">○ Vide</span>';
    }

    appreciationSpan.innerHTML = html;
    updateGlobalStats();
}

// Mettre à jour les statistiques globales
function updateGlobalStats() {
    const inputs = document.querySelectorAll('.note-input');
    const notes = Array.from(inputs).map(input => parseFloat(input.value) || 0).filter(n => n > 0);
    
    const total = inputs.length;
    const admis = notes.filter(n => n >= 10).length;
    const echecs = notes.filter(n => n < 10).length;
    const moyenne = notes.length > 0 ? (notes.reduce((a, b) => a + b, 0) / notes.length).toFixed(2) : '0.00';

    document.getElementById('stat_total').textContent = total;
    document.getElementById('stat_admis').textContent = admis;
    document.getElementById('stat_echecs').textContent = echecs;
    document.getElementById('stat_moyenne').textContent = moyenne;
}

// Initialiser les stats au chargement
document.addEventListener('DOMContentLoaded', function() {
    // Calculer les stats initiales
    updateGlobalStats();

    // Ajouter les listeners sur tous les inputs
    document.querySelectorAll('.note-input').forEach(input => {
        input.addEventListener('input', function() {
            updateRowAppreciation(this.id.replace('note_', ''));
        });
    });
});
</script>
@endpush

@push('styles')
<style>
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>
@endpush