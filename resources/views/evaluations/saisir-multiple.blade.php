@extends('layouts.app')

@section('title', 'Saisie Multiple des Évaluations')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- En-tête -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-foreground">Saisie Multiple des Évaluations</h1>
        <p class="mt-1 text-xs text-muted-foreground">Saisir les notes d'un semestre pour un étudiant</p>
    </div>

    <!-- Filtres -->
    <div class="bg-card border border-border rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('evaluations.saisir-multiple') }}" class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-foreground mb-1.5">Étudiant <span class="text-destructive">*</span></label>
                <select name="user_id" required 
                        class="w-full px-3 py-2 rounded-md border border-border bg-background text-sm focus:outline-none focus:ring-1 focus:ring-primary"
                        onchange="this.form.submit()">
                    <option value="">Choisir un étudiant...</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->matricule }} - {{ $user->getFullName() }} ({{ $user->specialite?->intitule ?? 'N/A' }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-foreground mb-1.5">Semestre <span class="text-destructive">*</span></label>
                <select name="semestre" required 
                        class="w-full px-3 py-2 rounded-md border border-border bg-background text-sm focus:outline-none focus:ring-1 focus:ring-primary"
                        onchange="this.form.submit()">
                    <option value="1" {{ $semestre == 1 ? 'selected' : '' }}>Semestre 1</option>
                    <option value="2" {{ $semestre == 2 ? 'selected' : '' }}>Semestre 2</option>
                </select>
            </div>
        </form>
    </div>

    @if($user && $modules->isNotEmpty())

        <!-- Infos Étudiant -->
        <div class="bg-primary/5 border border-primary/20 rounded-lg p-4 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-foreground">{{ $user->getFullName() }}</h2>
                    <p class="text-xs text-muted-foreground mt-0.5">
                        {{ $user->matricule }} • {{ $user->specialite?->intitule ?? 'N/A' }}
                    </p>
                </div>
                <div class="text-right">
                    <span class="inline-block px-3 py-1 bg-primary text-primary-foreground rounded text-xs font-bold">
                        S{{ $semestre }}
                    </span>
                    <p class="text-xs text-muted-foreground mt-1">{{ $user->anneeAcademique?->libelle ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Formulaire -->
        <form action="{{ route('evaluations.store-multiple') }}" method="POST" class="bg-card border border-border rounded-lg overflow-hidden">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <input type="hidden" name="semestre" value="{{ $semestre }}">

            <!-- Header -->
            <div class="p-4 border-b border-border bg-muted/20">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-foreground text-sm">Modules - Semestre {{ $semestre }}</h3>
                        <p class="text-xs text-muted-foreground mt-0.5">{{ $modules->count() }} module(s) de {{ $user->specialite?->intitule ?? 'cette spécialité' }}</p>
                    </div>
                    @if($evaluations->isNotEmpty())
                        <span class="text-xs font-bold text-green-600">✓ {{ $evaluations->count() }}/{{ $modules->count() }}</span>
                    @endif
                </div>
            </div>

            <!-- Modules List -->
            <div class="divide-y divide-border">
                @foreach($modules as $module)
                    @php
                        $evaluation = $evaluations->get($module->id);
                        $isSaisie = $evaluation !== null;
                    @endphp
                    <div class="p-4 flex items-center gap-3 {{ $isSaisie ? 'bg-green-50 dark:bg-green-950/10' : 'hover:bg-muted/30' }}">
                        
                        <!-- Numéro -->
                        <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $isSaisie ? 'bg-green-100 dark:bg-green-900/30' : 'bg-muted' }} flex items-center justify-center">
                            @if($isSaisie)
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            @else
                                <span class="text-xs font-bold text-muted-foreground">{{ $loop->iteration }}</span>
                            @endif
                        </div>

                        <!-- Infos -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold px-2 py-0.5 rounded {{ $semestre == 1 ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $module->code }}
                                </span>
                                @if($isSaisie)
                                    <span class="text-xs font-bold text-green-600">✓ Saisi</span>
                                @endif
                            </div>
                            <p class="text-sm font-medium text-foreground truncate">{{ $module->intitule }}</p>
                            <p class="text-xs text-muted-foreground">Coef: {{ number_format($module->coefficient, 2) }}</p>
                        </div>

                        <!-- Input -->
                        <div class="flex-shrink-0 w-32">
                            <input type="hidden" name="evaluations[{{ $loop->index }}][module_id]" value="{{ $module->id }}">
                            <div class="relative">
                                <input 
                                    type="number" 
                                    name="evaluations[{{ $loop->index }}][note]" 
                                    value="{{ old('evaluations.'.$loop->index.'.note', $evaluation?->note) }}"
                                    min="0" max="20" step="0.01" required
                                    class="w-full px-3 py-2 border rounded-md text-center text-sm font-bold bg-background focus:outline-none focus:ring-1 focus:ring-primary @error('evaluations.'.$loop->index.'.note') border-destructive @enderror"
                                    placeholder="0.00"
                                    onchange="validateNote(this)"
                                    oninput="validateNote(this)">
                                <span class="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-muted-foreground">/20</span>
                            </div>
                            @error('evaluations.'.$loop->index.'.note')
                                <p class="mt-0.5 text-xs text-destructive">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Footer -->
            <div class="p-4 border-t border-border bg-muted/20 flex items-center justify-between gap-3">
                <div class="text-xs text-muted-foreground">
                    @if($evaluations->isNotEmpty())
                        <span class="font-semibold text-green-600">{{ $evaluations->count() }} note(s) saisie(s)</span>
                    @else
                        <span>Aucune note saisie</span>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('evaluations.index') }}" 
                       class="px-4 py-2 text-sm font-medium text-foreground bg-muted hover:bg-muted/80 rounded-md transition-colors">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-primary-foreground bg-primary hover:bg-primary/90 rounded-md transition-colors">
                        Enregistrer les notes
                    </button>
                </div>
            </div>
        </form>

        <!-- Stats -->
        @if($evaluations->isNotEmpty())
        <div class="mt-6 grid grid-cols-3 gap-3">
            <div class="bg-card border border-border rounded-lg p-3">
                <p class="text-xs text-muted-foreground mb-1">Progression</p>
                <p class="text-lg font-bold text-foreground">{{ $evaluations->count() }}/{{ $modules->count() }}</p>
                <div class="mt-2 w-full h-1.5 bg-muted rounded-full overflow-hidden">
                    <div class="h-full bg-primary rounded-full" 
                         style="width: {{ ($evaluations->count() / $modules->count()) * 100 }}%"></div>
                </div>
            </div>
            <div class="bg-card border border-border rounded-lg p-3">
                <p class="text-xs text-muted-foreground mb-1">Moyenne</p>
                <p class="text-lg font-bold {{ $evaluations->avg('note') >= 10 ? 'text-green-600' : 'text-orange-600' }}">
                    {{ number_format($evaluations->avg('note'), 2) }}
                </p>
            </div>
            <div class="bg-card border border-border rounded-lg p-3">
                <p class="text-xs text-muted-foreground mb-1">Meilleure</p>
                <p class="text-lg font-bold text-foreground">{{ number_format($evaluations->max('note'), 2) }}</p>
            </div>
        </div>
        @endif

    @elseif($user && $modules->isEmpty())

        <div class="bg-yellow-50 dark:bg-yellow-950/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6 text-center">
            <svg class="w-12 h-12 mx-auto text-yellow-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <h3 class="text-lg font-bold text-yellow-900 dark:text-yellow-100 mb-1">Aucun module disponible</h3>
            <p class="text-sm text-yellow-800 dark:text-yellow-200">
                Aucun module trouvé pour <strong>{{ $user->specialite?->intitule ?? 'cette spécialité' }}</strong> au semestre {{ $semestre }}.
            </p>
            <p class="text-xs text-yellow-700 dark:text-yellow-300 mt-2">
                Veuillez d'abord créer les modules pour cette spécialité.
            </p>
        </div>

    @else

        <div class="bg-card border border-border rounded-lg p-8 text-center">
            <svg class="w-16 h-16 mx-auto text-muted-foreground mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-sm text-muted-foreground mb-4">Sélectionnez un étudiant et un semestre pour commencer</p>
            <p class="text-xs text-muted-foreground">Les modules seront automatiquement filtrés par la spécialité de l'étudiant</p>
        </div>

    @endif

</div>

@endsection

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

@push('scripts')
<script>
function validateNote(input) {
    if (input.value < 0) input.value = 0;
    if (input.value > 20) input.value = 20;
    if (input.value) input.value = parseFloat(input.value).toFixed(2);
}

document.addEventListener('DOMContentLoaded', function() {
    const noteInputs = document.querySelectorAll('input[type="number"][name*="note"]');
    noteInputs.forEach(input => {
        input.addEventListener('blur', () => validateNote(input));
    });
});
</script>
@endpush