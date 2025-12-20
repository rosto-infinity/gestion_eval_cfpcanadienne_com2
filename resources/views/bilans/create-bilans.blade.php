@extends('layouts.app')

@section('title', 'Créer un bilan de compétences')

@section('content')
<div class="mb-6">
    <a href="{{ route('bilans.index') }}" class="text-blue-600 hover:text-blue-900 inline-flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour à la liste
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="text-xl font-semibold text-gray-800">Nouveau bilan de compétences</h2>
    </div>
    <div class="card-body">
        @if($user && $user->bilanCompetence)
        <div class="alert alert-error mb-6">
            <div class="flex items-start">
                <svg class="h-5 w-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="font-medium">Un bilan existe déjà</p>
                    <p class="text-sm mt-1">Cet étudiant possède déjà un bilan de compétences pour l'année en cours.</p>
                    <a href="{{ route('bilans.edit', $user->bilanCompetence) }}" class="text-sm underline font-medium mt-2 inline-block">
                        Modifier le bilan existant →
                    </a>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('bilans.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Sélection de l'étudiant -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Sélectionner un étudiant <span class="text-red-500">*</span>
                    </label>
                    <select name="user_id" 
                            id="user_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('user_id') border-red-500 @enderror"
                            required
                            onchange="loadStudentInfo(this.value)">
                        <option value="">-- Choisir un étudiant --</option>
                        @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ old('user_id', $user?->id) == $u->id ? 'selected' : '' }}
                                data-matricule="{{ $u->matricule }}"
                                data-name="{{ $u->name }}">    
                                {{-- data-specialite="{{ $u->specialite->intitule }}" --}}
                                {{-- data-annee="{{ $u->anneeAcademique->libelle }}"> --}}
                            {{-- {{ $u->matricule }} - {{ $u->name }} ({{ $u->specialite->code }}) --}}
                            {{ $u->matricule }} - {{ $u->name }} 
                        </option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Seuls les étudiants sans bilan de compétences sont affichés
                    </p>
                </div>

                <!-- Informations de l'étudiant sélectionné -->
                <div id="student-info" class="hidden p-4 bg-blue-50 border-l-4 border-blue-400 rounded">
                    <div class="flex items-start">
                        <svg class="h-6 w-6 text-blue-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-blue-800">Informations de l'étudiant</h3>
                            <div class="mt-2 text-sm text-blue-700 grid grid-cols-2 gap-3">
                                <div>
                                    <span class="font-medium">Matricule:</span> <span id="info-matricule">-</span>
                                </div>
                                <div>
                                    <span class="font-medium">Nom:</span> <span id="info-name">-</span>
                                </div>
                                <div>
                                    <span class="font-medium">Spécialité:</span> <span id="info-specialite">-</span>
                                </div>
                                <div>
                                    <span class="font-medium">Année:</span> <span id="info-annee">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Moyenne des compétences -->
                <div>
                    <label for="moy_competences" class="block text-sm font-medium text-gray-700 mb-2">
                        Moyenne du bilan des compétences (70%) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="moy_competences" 
                           id="moy_competences" 
                           min="0" 
                           max="20" 
                           step="0.01" 
                           value="{{ old('moy_competences') }}"
                           placeholder="0.00"
                           class="mt-1 block w-full text-2xl font-bold rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('moy_competences') border-red-500 @enderror"
                           required>
                    @error('moy_competences')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Cette note représente 70% de la moyenne générale finale
                    </p>
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
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('observations') border-red-500 @enderror">{{ old('observations') }}</textarea>
                    @error('observations')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Maximum 1000 caractères</p>
                </div>

                <!-- Aperçu du calcul -->
                <div id="calculation-preview" class="hidden p-6 bg-gradient-to-r from-purple-50 to-blue-50 rounded-lg border-2 border-purple-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Aperçu du calcul</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div class="text-center p-3 bg-white rounded-lg shadow">
                            <p class="text-xs text-gray-600 mb-1">Moy. Évaluations (30%)</p>
                            <p class="text-2xl font-bold text-blue-600" id="preview-eval">-</p>
                        </div>
                        <div class="text-center p-3 bg-white rounded-lg shadow">
                            <p class="text-xs text-gray-600 mb-1">Moy. Compétences (70%)</p>
                            <p class="text-2xl font-bold text-purple-600" id="preview-comp">-</p>
                        </div>
                        <div class="text-center p-3 bg-white rounded-lg shadow">
                            <p class="text-xs text-gray-600 mb-1">MOYENNE GÉNÉRALE</p>
                            <p class="text-3xl font-bold" id="preview-general">-</p>
                        </div>
                    </div>

                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-2">Mention estimée</p>
                        <span class="badge text-base px-4 py-2" id="preview-mention">-</span>
                    </div>

                    <div class="mt-4 p-3 bg-yellow-50 rounded text-sm text-gray-700">
                        <p class="font-medium mb-1">ℹ️ Note importante :</p>
                        <p>La moyenne des évaluations sera calculée automatiquement à partir des notes déjà saisies pour cet étudiant.</p>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('bilans.index') }}" class="btn btn-secondary">
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Créer le bilan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function loadStudentInfo(userId) {
    const studentInfo = document.getElementById('student-info');
    const select = document.getElementById('user_id');
    const option = select.options[select.selectedIndex];
    
    if (userId) {
        document.getElementById('info-matricule').textContent = option.dataset.matricule;
        document.getElementById('info-name').textContent = option.dataset.name;
        document.getElementById('info-specialite').textContent = option.dataset.specialite;
        document.getElementById('info-annee').textContent = option.dataset.annee;
        studentInfo.classList.remove('hidden');
    } else {
        studentInfo.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const moyCompetencesInput = document.getElementById('moy_competences');
    const calculationPreview = document.getElementById('calculation-preview');
    
    // -Charger les infos si un étudiant est déjà sélectionné
    const userSelect = document.getElementById('user_id');
    if (userSelect.value) {
        loadStudentInfo(userSelect.value);
    }
    
    function getMention(note) {
        if (note >= 16) return { text: 'Très Bien', color: 'badge-success' };
        if (note >= 14) return { text: 'Bien', color: 'badge-success' };
        if (note >= 12) return { text: 'Assez Bien', color: 'badge-info' };
        if (note >= 10) return { text: 'Passable', color: 'badge-warning' };
        return { text: 'Ajourné', color: 'badge-danger' };
    }
    
    moyCompetencesInput.addEventListener('input', function() {
        const moyComp = parseFloat(this.value);
        
        if (!isNaN(moyComp) && moyComp >= 0 && moyComp <= 20) {
            calculationPreview.classList.remove('hidden');
            
            // Pour l'aperçu, on utilise une moyenne d'éval estimée de 12/20
            const moyEvalEstimated = 12.00;
            const moyEval30 = moyEvalEstimated * 0.30;
            const moyComp70 = moyComp * 0.70;
            const moyGenerale = moyEval30 + moyComp70;
            
            document.getElementById('preview-eval').textContent = moyEvalEstimated.toFixed(2);
            document.getElementById('preview-comp').textContent = moyComp.toFixed(2);
            document.getElementById('preview-general').textContent = moyGenerale.toFixed(2);
            
            const mention = getMention(moyGenerale);
            const mentionBadge = document.getElementById('preview-mention');
            mentionBadge.textContent = mention.text;
            mentionBadge.className = `badge text-base px-4 py-2 ${mention.color}`;
            
            const generalDisplay = document.getElementById('preview-general');
            generalDisplay.className = `text-3xl font-bold ${moyGenerale >= 10 ? 'text-green-600' : 'text-red-600'}`;
        } else {
            calculationPreview.classList.add('hidden');
        }
    });
});
</script>
@endpush