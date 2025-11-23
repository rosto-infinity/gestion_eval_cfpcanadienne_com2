@extends('layouts.app')

@section('title', isset($annee) ? 'Modifier l\'Année Académique' : 'Créer une Année Académique')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- En-tête -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-3">
            <a href="{{ route('annees.index') }}" 
               class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-primary/10 hover:bg-primary/20 transition-colors duration-200">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-foreground">
                    {{ isset($annee) ? '✏️ Modifier l\'Année Académique' : '📅 Créer une Année Académique' }}
                </h1>
                <p class="mt-1 text-sm text-muted-foreground">
                    {{ isset($annee) ? 'Mettre à jour les informations de l\'année académique' : 'Ajouter une nouvelle période scolaire' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
        <form action="{{ isset($annee) ? route('annees.update', $annee) : route('annees.store') }}" 
              method="POST" 
              class="p-6 space-y-6">
            @csrf
            @if(isset($annee))
                @method('PUT')
            @endif

            <!-- Libellé -->
            <div>
                <label for="libelle" class="block text-sm font-semibold text-foreground mb-2">
                    Libellé 
                    <span class="text-destructive font-bold">*</span>
                </label>
                <input type="text" 
                       name="libelle" 
                       id="libelle" 
                       value="{{ old('libelle', isset($annee) ? $annee->libelle : '') }}" 
                       required
                       placeholder="Ex: 2025-2026"
                       class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('libelle') border-destructive ring-2 ring-destructive/50 @enderror">
                @error('libelle')
                    <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
                <p class="mt-2 text-xs text-muted-foreground flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    Format recommandé: YYYY-YYYY (ex: 2025-2026)
                </p>
            </div>

            <!-- Dates -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Date de début -->
                <div>
                    <label for="date_debut" class="block text-sm font-semibold text-foreground mb-2">
                        Date de début 
                        <span class="text-destructive font-bold">*</span>
                    </label>
                    <input type="date" 
                           name="date_debut" 
                           id="date_debut" 
                           value="{{ old('date_debut', isset($annee) ? $annee->date_debut->format('Y-m-d') : '') }}" 
                           required
                           class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('date_debut') border-destructive ring-2 ring-destructive/50 @enderror">
                    @error('date_debut')
                        <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Date de fin -->
                <div>
                    <label for="date_fin" class="block text-sm font-semibold text-foreground mb-2">
                        Date de fin 
                        <span class="text-destructive font-bold">*</span>
                    </label>
                    <input type="date" 
                           name="date_fin" 
                           id="date_fin" 
                           value="{{ old('date_fin', isset($annee) ? $annee->date_fin->format('Y-m-d') : '') }}" 
                           required
                           class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('date_fin') border-destructive ring-2 ring-destructive/50 @enderror">
                    @error('date_fin')
                        <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Statut actif -->
            <div class="p-4 bg-primary/5 border border-primary/20 rounded-lg">
                <div class="flex items-start gap-3">
                    <div class="flex items-center h-6 mt-0.5">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            id="is_active" 
                            value="1"
                            {{ old('is_active', isset($annee) ? $annee->is_active : false) ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-border bg-background text-primary focus:ring-2 focus:ring-primary/50 cursor-pointer transition-all">
                    </div>
                    <div class="flex-1">
                        <label for="is_active" class="font-semibold text-foreground cursor-pointer">
                            Définir comme année active
                        </label>
                        <p class="text-sm text-muted-foreground mt-1">
                            Si cochée, cette année sera l'année en cours. L'ancienne année active sera automatiquement désactivée.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Information -->
            <div class="p-4 bg-accent/5 border-l-4 border-accent rounded-lg">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 mt-0.5">
                        <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-accent/20">
                            <svg class="h-5 w-5 text-accent" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-foreground">💡 À propos de l'année active</h3>
                        <ul class="mt-3 space-y-2 text-sm text-muted-foreground">
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-accent flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Une seule année peut être active à la fois</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-accent flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>L'année active est utilisée par défaut dans les formulaires</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-accent flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Les nouveaux étudiants sont automatiquement associés à l'année active</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Boutons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-border">
                <a href="{{ route('annees.index') }}" 
                   class="px-6 py-2.5 bg-muted hover:bg-muted/80 text-muted-foreground rounded-lg font-semibold transition-all duration-200">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-semibold transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ isset($annee) ? 'Mettre à jour' : 'Créer l\'Année' }}
                </button>
            </div>
        </form>
    </div>

    <!-- Aide supplémentaire -->
    <div class="mt-8 p-4 bg-muted/30 border border-border rounded-lg">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-muted-foreground flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div class="text-sm text-muted-foreground">
                <p class="font-semibold text-foreground mb-2">📝 Conseils de remplissage :</p>
                <ul class="space-y-1 list-disc list-inside">
                    <li>Utilisez le format YYYY-YYYY pour le libellé (ex: 2025-2026)</li>
                    <li>La date de début doit être antérieure à la date de fin</li>
                    <li>Les dates doivent être valides et cohérentes</li>
                    <li>Vérifiez bien les informations avant de valider</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateDebut = document.getElementById('date_debut');
    const dateFin = document.getElementById('date_fin');
    const libelle = document.getElementById('libelle');
    
    // Validation des dates
    dateDebut.addEventListener('change', function() {
        if (this.value) {
            dateFin.min = this.value;
            
            // Auto-fill libelle si vide
            if (!libelle.value) {
                const year = new Date(this.value).getFullYear();
                libelle.value = `${year}-${year + 1}`;
            }
        }
    });
    
    dateFin.addEventListener('change', function() {
        if (this.value && dateDebut.value) {
            if (new Date(this.value) <= new Date(dateDebut.value)) {
                // Afficher une erreur
                this.classList.add('border-destructive', 'ring-2', 'ring-destructive/50');
                
                // Créer un message d'erreur
                let errorMsg = this.parentElement.querySelector('.error-message');
                if (!errorMsg) {
                    errorMsg = document.createElement('p');
                    errorMsg.className = 'error-message mt-2 text-sm text-destructive font-medium flex items-center gap-1';
                    errorMsg.innerHTML = `
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        La date de fin doit être postérieure à la date de début
                    `;
                    this.parentElement.appendChild(errorMsg);
                }
            } else {
                this.classList.remove('border-destructive', 'ring-2', 'ring-destructive/50');
                const errorMsg = this.parentElement.querySelector('.error-message');
                if (errorMsg) errorMsg.remove();
            }
        }
    });
    
    // Validation du formulaire
    document.querySelector('form').addEventListener('submit', function(e) {
        if (dateFin.value && dateDebut.value) {
            if (new Date(dateFin.value) <= new Date(dateDebut.value)) {
                e.preventDefault();
                alert('La date de fin doit être postérieure à la date de début');
                dateFin.focus();
            }
        }
    });
});
</script>
@endpush

@push('styles')
<style>
    input[type="date"]::-webkit-calendar-picker-indicator {
        cursor: pointer;
        opacity: 0.6;
    }
    
    input[type="date"]::-webkit-calendar-picker-indicator:hover {
        opacity: 1;
    }
    
    input[type="checkbox"]:checked {
        background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
        background-position: center;
        background-repeat: no-repeat;
        background-size: 100% 100%;
    }
</style>
@endpush
