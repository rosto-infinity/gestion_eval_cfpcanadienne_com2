@extends('layouts.app')

@section('title', 'Saisie Multiple des Évaluations')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- En-tête -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-foreground">Saisie Multiple des Évaluations</h1>
            <p class="mt-1 text-xs text-muted-foreground">Saisir les notes d'un semestre pour un étudiant</p>
        </div>

        <!-- Messages Flash -->
        @if (session('success'))
            <div
                class="mb-6 p-4 bg-green-50 dark:bg-green-950/20 border border-green-200 dark:border-green-800 rounded-lg flex items-start gap-3">
                <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <h4 class="font-semibold text-green-900 dark:text-green-100">Succès</h4>
                    <p class="text-sm text-green-800 dark:text-green-200 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div
                class="mb-6 p-4 bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-800 rounded-lg flex items-start gap-3">
                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <h4 class="font-semibold text-red-900 dark:text-red-100">Erreur</h4>
                    <p class="text-sm text-red-800 dark:text-red-200 mt-0.5">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Filtres -->
        <div class="bg-card border border-border rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('evaluations.saisir-multiple') }}"
                class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-foreground mb-1.5">Étudiant <span
                            class="text-destructive">*</span></label>
                    <select name="user_id" required
                        class="w-full px-3 py-2 rounded-md border border-border bg-background text-sm focus:outline-none focus:ring-1 focus:ring-primary"
                        onchange="this.form.submit()">
                        <option value="">Choisir un étudiant...</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->matricule }} - {{ $user->getFullName() }}
                                ({{ $user->specialite?->intitule ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-foreground mb-1.5">Semestre <span
                            class="text-destructive">*</span></label>
                    <select name="semestre" required
                        class="w-full px-3 py-2 rounded-md border border-border bg-background text-sm focus:outline-none focus:ring-1 focus:ring-primary"
                        onchange="this.form.submit()">
                        <option value="1" {{ $semestre == 1 ? 'selected' : '' }}>Semestre 1</option>
                        <option value="2" {{ $semestre == 2 ? 'selected' : '' }}>Semestre 2</option>
                    </select>
                </div>
            </form>
        </div>

        @if ($selectedUser && $modules->isNotEmpty())

            <!-- Infos Étudiant -->
            <div class="bg-primary/5 border border-primary/20 rounded-lg p-4 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-bold text-foreground">{{ $selectedUser->getFullName() }}</h2>
                        <p class="text-xs text-muted-foreground mt-0.5">
                            {{ $selectedUser->matricule }} • {{ $selectedUser->specialite?->intitule ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-3 py-1 bg-primary text-primary-foreground rounded text-xs font-bold">
                            S{{ $semestre }}
                        </span>
                        <p class="text-xs text-muted-foreground mt-1">{{ $selectedUser->anneeAcademique?->libelle ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Formulaire -->
            <form action="{{ route('evaluations.store-multiple') }}" method="POST"
                class="bg-card border border-border rounded-lg overflow-hidden" id="evaluationsForm">
                @csrf
                <input type="hidden" name="user_id" value="{{ $selectedUser->id }}">
                <input type="hidden" name="semestre" value="{{ $semestre }}">

                <!-- -Afficher les erreurs de validation -->
                @if ($errors->any())
                    <div class="p-4 bg-red-50 dark:bg-red-950/20 border-b border-red-200 dark:border-red-800">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="flex-1">
                                <h4 class="font-semibold text-red-900 dark:text-red-100 mb-2">Erreurs de validation</h4>
                                <ul class="text-sm text-red-800 dark:text-red-200 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="flex items-center gap-2">
                                            <span class="inline-block w-1.5 h-1.5 bg-red-600 rounded-full"></span>
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($selectedUser && $modules->isNotEmpty())
<!-- ✅ --Section Debug - Ajoutez ceci après les infos étudiant -->
<div class="mt-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3 text-xs">
    <p><strong class="text-blue-800 dark:text-blue-200">🔍 Informations de débogage :</strong></p>
    <p>• Spécialité étudiant : <span class="font-bold">{{ $selectedUser->specialite_id }} ({{ $selectedUser->specialite?->intitule ?? 'N/A' }})</span></p>
    <p>• Modules chargés : <span class="font-bold">{{ $modules->count() }}</span></p>
    <p>• Modules par spécialité : <span class="font-bold">{{ $modules->where('specialite_id', $selectedUser->specialite_id)->count() }}/{{ $modules->count() }}</span></p>
    @if($modules->where('specialite_id', '!=', $selectedUser->specialite_id)->isNotEmpty())
        <p class="text-red-600 dark:text-red-400 mt-1">
            ⚠️ <strong>Attention :</strong> {{ $modules->where('specialite_id', '!=', $selectedUser->specialite_id)->count() }} module(s) n'appartiennent pas à cette spécialité !
        </p>
        <ul class="mt-1 ml-4 text-red-700 dark:text-red-300">
            @foreach($modules->where('specialite_id', '!=', $selectedUser->specialite_id) as $invalidModule)
                <li>• {{ $invalidModule->code }}: {{ $invalidModule->intitule }} (Spécialité: {{ $invalidModule->specialite_id }})</li>
            @endforeach
        </ul>
    @endif
</div>
@endif

                <!-- Header -->
                <div class="p-4 border-b border-border bg-muted/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-foreground text-sm">Modules - Semestre {{ $semestre }}</h3>
                            <p class="text-xs text-muted-foreground mt-0.5">{{ $modules->count() }} module(s) de
                                {{ $selectedUser->specialite?->intitule ?? 'cette spécialité' }}</p>
                        </div>
                        @if ($evaluations->isNotEmpty())
                            <span class="text-xs font-bold text-green-600">✓
                                {{ $evaluations->count() }}/{{ $modules->count() }}</span>
                        @endif
                    </div>
                </div>

                <!-- Modules List -->
                <div class="divide-y divide-border max-h-[600px] overflow-y-auto">
                    @foreach ($modules as $module)
                        @php
                            $evaluation = $evaluations->get($module->id);
                            $isSaisie = $evaluation !== null;
                            $oldValue = old('evaluations.' . $loop->index . '.note', $evaluation?->note);
                        @endphp
                        <div
                            class="p-4 flex items-center gap-3 transition-colors {{ $isSaisie ? 'bg-green-50 dark:bg-green-950/10' : 'hover:bg-muted/30' }}">

                            <!-- Numéro -->
                            <div
                                class="flex-shrink-0 w-8 h-8 rounded-full {{ $isSaisie ? 'bg-green-100 dark:bg-green-900/30' : 'bg-muted' }} flex items-center justify-center">
                                @if ($isSaisie)
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <span class="text-xs font-bold text-muted-foreground">{{ $loop->iteration }}</span>
                                @endif
                            </div>

                            <!-- Infos -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span
                                        class="text-xs font-bold px-2 py-0.5 rounded {{ $semestre == 1 ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $module->code }}
                                    </span>
                                    @if ($isSaisie)
                                        <span class="text-xs font-bold text-green-600">✓ Saisi</span>
                                    @endif
                                    @error('evaluations.' . $loop->index . '.note')
                                        <span class="text-xs font-bold text-red-600">✗ Erreur</span>
                                    @enderror
                                </div>
                                <p class="text-sm font-medium text-foreground truncate">{{ $module->intitule }}</p>
                                <p class="text-xs text-muted-foreground">Coef: {{ number_format($module->coefficient, 2) }}
                                </p>
                            </div>

                            <!-- Input -->
                            <div class="flex-shrink-0 w-32">
                                <input type="hidden" name="evaluations[{{ $loop->index }}][module_id]"
                                    value="{{ $module->id }}">
                                <div class="relative">
                                    <input type="number" name="evaluations[{{ $loop->index }}][note]"
                                        value="{{ $oldValue ?? '' }}" min="0" max="20" step="0.01"
                                        class="w-full px-3 py-2 border rounded-md text-center text-sm font-bold bg-background focus:outline-none focus:ring-1 focus:ring-primary transition-colors module-note-input @error('evaluations.' . $loop->index . '.note') border-destructive ring-1 ring-destructive/50 @else border-border @enderror"
                                        placeholder="0" onchange="validateNote(this)" oninput="validateNote(this)"
                                        data-module-id="{{ $module->id }}" data-loop-index="{{ $loop->index }}">
                                    <span
                                        class="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-muted-foreground pointer-events-none">/20</span>
                                </div>
                                @error('evaluations.' . $loop->index . '.note')
                                    <p class="mt-1 text-xs text-destructive font-medium flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- Footer -->
                <div class="p-4 border-t border-border bg-muted/20 flex items-center justify-between gap-3 flex-wrap">
                    <div class="text-xs text-muted-foreground">
                        <span id="noteCount">0</span> / <span id="totalModules">{{ $modules->count() }}</span>
                        <span class="text-muted-foreground ml-2">note(s) saisie(s)</span>
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
            @if ($evaluations->isNotEmpty())
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="bg-card border border-border rounded-lg p-3">
                        <p class="text-xs text-muted-foreground mb-1">Progression</p>
                        <p class="text-lg font-bold text-foreground">{{ $evaluations->count() }}/{{ $modules->count() }}
                        </p>
                        <div class="mt-2 w-full h-1.5 bg-muted rounded-full overflow-hidden">
                            <div class="h-full bg-primary rounded-full"
                                style="width: {{ ($evaluations->count() / $modules->count()) * 100 }}%"></div>
                        </div>
                    </div>
                    <div class="bg-card border border-border rounded-lg p-3">
                        <p class="text-xs text-muted-foreground mb-1">Moyenne</p>
                        <p
                            class="text-lg font-bold {{ $evaluations->avg('note') >= 10 ? 'text-green-600' : 'text-orange-600' }}">
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
            <div
                class="bg-yellow-50 dark:bg-yellow-950/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6 text-center">
                <svg class="w-12 h-12 mx-auto text-yellow-600 mb-3" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="text-lg font-bold text-yellow-900 dark:text-yellow-100 mb-1">Aucun module disponible</h3>
                <p class="text-sm text-yellow-800 dark:text-yellow-200">
                    Aucun module trouvé pour <strong>{{ $user->specialite?->intitule ?? 'cette spécialité' }}</strong> au
                    semestre {{ $semestre }}.
                </p>
                <p class="text-xs text-yellow-700 dark:text-yellow-300 mt-2">
                    Veuillez d'abord créer les modules pour cette spécialité.
                </p>
            </div>
        @else
            <div class="bg-card border border-border rounded-lg p-8 text-center">
                <svg class="w-16 h-16 mx-auto text-muted-foreground mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-sm text-muted-foreground mb-4">Sélectionnez un étudiant et un semestre pour commencer</p>
                <p class="text-xs text-muted-foreground">Les modules seront automatiquement filtrés par la spécialité de
                    l'étudiant</p>
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
        /**
         * ✅ Valide et formate la note
         */
        function validateNote(input) {
            let value = input.value.trim();

            // ✅ Accepter virgule et point
            value = value.replace(',', '.');

            // ✅ Vérifier si c'est vide
            if (value === '') {
                input.value = '';
                input.classList.remove('border-destructive', 'ring-1', 'ring-destructive/50');
                input.classList.add('border-border');
                updateNoteCount();
                return;
            }

            // ✅ Convertir en nombre
            let note = parseFloat(value);

            // ✅ Vérifier si c'est un nombre valide
            if (isNaN(note)) {
                input.value = '';
                input.classList.add('border-destructive', 'ring-1', 'ring-destructive/50');
                input.classList.remove('border-border');
                console.warn('❌ Valeur invalide:', value);
                updateNoteCount();
                return;
            }

            // ✅ Limiter entre 0 et 20
            let hasError = false;
            if (note < 0) {
                note = 0;
                hasError = true;
            } else if (note > 20) {
                note = 20;
                hasError = true;
            }

            // ✅ Limiter à 2 décimales
            note = Math.round(note * 100) / 100;

            // ✅ Afficher la valeur formatée
            input.value = note;

            // ✅ Appliquer le style
            if (hasError) {
                input.classList.add('border-destructive', 'ring-1', 'ring-destructive/50');
                input.classList.remove('border-border');
            } else {
                input.classList.remove('border-destructive', 'ring-1', 'ring-destructive/50');
                input.classList.add('border-border');
            }

            console.log(`✅ Note validée: ${note}`);
            updateNoteCount();
        }

        /**
         * ✅ Met à jour le compteur de notes
         */
        function updateNoteCount() {
            const inputs = document.querySelectorAll('.module-note-input');
            const noteCount = document.getElementById('noteCount');

            let filledCount = 0;
            inputs.forEach(input => {
                if (input.value.trim() !== '') {
                    filledCount++;
                }
            });

            noteCount.textContent = filledCount;
        }

        /**
         * ✅ Initialiser les écouteurs
         */
        document.addEventListener('DOMContentLoaded', function() {
            const noteInputs = document.querySelectorAll('.module-note-input');
            const form = document.getElementById('evaluationsForm');

            noteInputs.forEach(input => {
                // ✅ Valider en temps réel
                input.addEventListener('input', () => validateNote(input));
                input.addEventListener('blur', () => validateNote(input));

                // ✅ Valider au chargement
                validateNote(input);
            });

            console.log(`✅ ${noteInputs.length} champ(s) note initialisé(s)`);
            updateNoteCount();
        });
    </script>
@endpush
