
@extends('layouts.app')

@section('title', 'Créer un bilan de compétences')

@section('content')
<div class="mb-6">
    <a href="{{ route('bilans.index') }}" class="text-primary hover:text-primary/80 inline-flex items-center font-medium transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour à la liste
    </a>
</div>

<div class="bg-card border border-border rounded-lg shadow-sm overflow-hidden">
    <div class="p-6 border-b border-border bg-muted/30">
        <h2 class="text-xl font-semibold text-foreground">Nouveau bilan de compétences</h2>
        <p class="text-sm text-muted-foreground mt-1">Saisir la moyenne de compétences (70%) pour un étudiant.</p>
    </div>
    
    <div class="p-6">
        @if($user && $user->bilanCompetence)
        <div class="bg-destructive/10 border border-destructive/20 text-destructive rounded-lg p-4 mb-6">
            <div class="flex items-start">
                <svg class="h-5 w-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="font-bold">Un bilan existe déjà</p>
                    <p class="text-sm mt-1 opacity-90">Cet étudiant possède déjà un bilan de compétences pour l'année en cours.</p>
                    <a href="{{ route('bilans.edit', $user->bilanCompetence) }}" class="text-sm underline font-medium mt-2 inline-block hover:text-destructive/80">
                        Modifier le bilan existant →
                    </a>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('bilans.store') }}" method="POST">
            @csrf

            <div class="space-y-8">
                <!-- Sélection de l'étudiant -->
                <div>
                    <label for="user_id" class="block text-sm font-semibold text-foreground mb-2">
                        Sélectionner un étudiant <span class="text-destructive">*</span>
                    </label>
                    <select name="user_id" 
                            id="user_id" 
                            class="w-full rounded-lg border-border bg-background text-foreground px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors shadow-sm"
                            required
                            onchange="loadStudentInfo(this.value)">
                        <option value="">-- Choisir un étudiant --</option>
                        @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ old('user_id', $user?->id) == $u->id ? 'selected' : '' }}
                                data-matricule="{{ $u->matricule }}"
                                data-name="{{ $u->name }}"
                                data-specialite="{{ $u->specialite->intitule ?? 'N/A' }}"
                                data-annee="{{ $u->anneeAcademique->libelle ?? 'N/A' }}">    
                            {{ $u->matricule }} - {{ $u->name }} 
                        </option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <p class="mt-2 text-sm text-destructive">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-muted-foreground">
                        Seuls les étudiants sans bilan de compétences sont affichés.
                    </p>
                </div>

                <!-- Informations de l'étudiant sélectionné -->
                <div id="student-info" class="hidden p-4 bg-primary/5 border-l-4 border-primary rounded-md">
                    <div class="flex items-start">
                        <div class="bg-primary/10 p-2 rounded-full mr-3 mt-0.5">
                            <svg class="h-5 w-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-foreground">Informations de l'étudiant</h3>
                            <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-4 text-sm">
                                <div>
                                    <span class="text-muted-foreground">Matricule:</span> 
                                    <span id="info-matricule" class="text-foreground font-medium">-</span>
                                </div>
                                <div>
                                    <span class="text-muted-foreground">Nom:</span> 
                                    <span id="info-name" class="text-foreground font-medium">-</span>
                                </div>
                                <div>
                                    <span class="text-muted-foreground">Spécialité:</span> 
                                    <span id="info-specialite" class="text-foreground">-</span>
                                </div>
                                <div>
                                    <span class="text-muted-foreground">Année:</span> 
                                    <span id="info-annee" class="text-foreground">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Moyenne des compétences -->
                <div class="bg-muted/30 p-6 rounded-lg border border-border">
                    <label for="moy_competences" class="block text-sm font-bold text-foreground mb-3 flex justify-between">
                        <span>Moyenne du bilan des compétences (70%)</span>
                        <span class="text-destructive">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" 
                            name="moy_competences" 
                            id="moy_competences" 
                            min="0" 
                            max="20" 
                            step="0.01" 
                            value="{{ old('moy_competences') }}"
                            placeholder="0.00"
                            class="block w-full text-4xl font-bold text-center rounded-lg border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary shadow-inner py-4 placeholder-muted-foreground/20"
                            required>
                        <div class="absolute top-1/2 -translate-y-1/2 right-4 pointer-events-none text-2xl text-muted-foreground font-bold">/20</div>
                    </div>
                    @error('moy_competences')
                    <p class="mt-2 text-sm text-destructive text-center">{{ $message }}</p>
                    @enderror
                    <p class="mt-3 text-xs text-center text-muted-foreground">
                        Cette note représente 70% de la moyenne générale finale.
                    </p>
                </div>

                <!-- Observations -->
                <div>
                    <label for="observations" class="block text-sm font-semibold text-foreground mb-2">
                        Observations
                    </label>
                    <textarea name="observations" 
                            id="observations" 
                            rows="4" 
                            placeholder="Remarques, commentaires, recommandations..."
                            class="w-full rounded-lg border-border bg-background text-foreground px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors placeholder-muted-foreground/50 resize-none">{{ old('observations') }}</textarea>
                    @error('observations')
                    <p class="mt-2 text-sm text-destructive">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-muted-foreground">Maximum 1000 caractères</p>
                </div>

                <!-- Aperçu du calcul -->
                <div id="calculation-preview" class="hidden p-6 bg-gradient-to-br from-primary/5 to-secondary border border-border rounded-xl shadow-lg">
                    <h3 class="text-lg font-bold text-foreground mb-6 flex items-center gap-2">
                        <span>📊</span> Aperçu du calcul
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-card border border-border rounded-lg p-4 text-center shadow-sm">
                            <p class="text-xs text-muted-foreground mb-2">Moy. Évaluations (30%)</p>
                            <p class="text-2xl font-bold text-foreground" id="preview-eval">-</p>
                        </div>
                        <div class="bg-card border border-border rounded-lg p-4 text-center shadow-sm">
                            <p class="text-xs text-muted-foreground mb-2">Moy. Compétences (70%)</p>
                            <p class="text-2xl font-bold text-primary" id="preview-comp">-</p>
                        </div>
                        <div class="bg-card border border-primary/30 rounded-lg p-4 text-center shadow-sm bg-primary/5">
                            <p class="text-xs font-bold text-primary mb-2">MOYENNE GÉNÉRALE</p>
                            <p class="text-3xl font-bold text-foreground" id="preview-general">-</p>
                        </div>
                    </div>

                    <div class="text-center mb-6">
                        <p class="text-xs text-muted-foreground mb-2 uppercase tracking-widest">Mention estimée</p>
                        <span class="inline-block text-sm font-bold px-6 py-2 rounded-full border border-border" id="preview-mention">-</span>
                    </div>

                    <div class="bg-background/50 border border-border rounded-md p-3 text-xs text-muted-foreground">
                        <p class="font-medium text-foreground mb-1">ℹ️ Note importante :</p>
                        <p>La moyenne des évaluations sera calculée automatiquement à partir des notes déjà saisies pour cet étudiant (S1 + S2)/2.</p>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="mt-8 flex items-center justify-end gap-4 border-t border-border pt-6">
                <a href="{{ route('bilans.index') }}" class="px-6 py-2.5 rounded-lg border border-border text-foreground hover:bg-muted font-medium transition-colors">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-primary text-primary-foreground hover:bg-primary/90 font-bold shadow-lg shadow-primary/20 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Créer le bilan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection


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
    
    // Charger les infos si un étudiant est déjà sélectionné
    const userSelect = document.getElementById('user_id');
    if (userSelect.value) {
        loadStudentInfo(userSelect.value);
    }
    
    function getMention(note) {
        // On retourne des classes Tailwind adaptées au thème sombre/rouge
        if (note >= 16) return { text: 'Très Bien', classes: 'bg-primary/20 text-primary border-primary/20' };
        if (note >= 14) return { text: 'Bien', classes: 'bg-primary/20 text-primary border-primary/20' };
        if (note >= 12) return { text: 'Assez Bien', classes: 'bg-blue-500/20 text-blue-400 border-blue-500/20' };
        if (note >= 10) return { text: 'Passable', classes: 'bg-yellow-500/20 text-yellow-400 border-yellow-500/20' };
        return { text: 'Ajourné', classes: 'bg-destructive/20 text-destructive border-destructive/20' };
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
            // Suppression des anciennes classes et ajout des nouvelles
            mentionBadge.className = `inline-block text-sm font-bold px-6 py-2 rounded-full border ${mention.classes}`;
            
            const generalDisplay = document.getElementById('preview-general');
            generalDisplay.className = `text-3xl font-bold ${moyGenerale >= 10 ? 'text-primary' : 'text-destructive'}`;
        } else {
            calculationPreview.classList.add('hidden');
        }
    });
});
</script>
