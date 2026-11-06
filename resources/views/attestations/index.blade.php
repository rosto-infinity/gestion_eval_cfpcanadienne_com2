<x-app-layout title="Impression des Attestations">
    <div class="mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6" x-data="{
        selectAll: true,
        toggleAll() {
            let checkboxes = document.querySelectorAll('.student-checkbox');
            checkboxes.forEach(cb => cb.checked = this.selectAll);
            this.updateCount();
        },
        selectedCount: {{ $students->count() }},
        updateCount() {
            this.selectedCount = document.querySelectorAll('.student-checkbox:checked').length;
        },
        applyGlobalDatesToAll() {
            let start = document.getElementById('global_date_debut').value;
            let end = document.getElementById('global_date_fin').value;
            let delivrance = document.getElementById('global_date_delivrance') ? document.getElementById('global_date_delivrance').value : '';
            document.querySelectorAll('.student-date-debut').forEach(el => el.value = start);
            document.querySelectorAll('.student-date-fin').forEach(el => el.value = end);
            if (delivrance) {
                document.querySelectorAll('.student-date-delivrance').forEach(el => el.value = delivrance);
            }
        }
    }">

        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-foreground tracking-tight flex items-center gap-2">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Attestations de Fin de Formation
                </h1>
                <p class="text-sm text-muted-foreground mt-1">
                    Génération et impression des attestations officielles par spécialité avec personnalisation
                </p>
            </div>
            <div class="flex items-center gap-3">
                @if(auth()->user()->role->isAtLeast(\App\Enums\Role::ADMIN))
                    <a href="{{ route('settings.arretes.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-border text-sm font-medium rounded-lg text-foreground bg-card hover:bg-muted shadow-sm transition-all">
                        <svg class="w-4 h-4 mr-2 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Gérer les Arrêtés
                    </a>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-lg bg-green-500/10 border border-green-500/20 text-green-700 dark:text-green-300 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-lg bg-red-500/10 border border-red-500/20 text-red-700 dark:text-red-300 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- SÉLECTION SPÉCIALITÉ ET ANNÉE ACADÉMIQUE -->
        <div class="bg-card rounded-xl shadow-sm border border-border p-5">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-muted-foreground mb-4">
                1. Sélection de la Promotion
            </h2>

            <form method="GET" action="{{ route('attestations.par-specialite') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <!-- Année Académique -->
                <div class="md:col-span-4">
                    <label class="block text-xs font-semibold text-foreground mb-1.5">Année Académique</label>
                    <select name="annee_id" onchange="this.form.submit()"
                        class="w-full py-2.5 px-3 border border-input rounded-lg bg-background text-foreground text-sm focus:ring-2 focus:ring-red-500 transition-colors">
                        @foreach($annees as $annee)
                            <option value="{{ $annee->id }}" {{ $selectedAnnee && $selectedAnnee->id === $annee->id ? 'selected' : '' }}>
                                {{ $annee->libelle }} {{ $annee->is_active ? '(Active)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Spécialité -->
                <div class="md:col-span-6">
                    <label class="block text-xs font-semibold text-foreground mb-1.5">Spécialité</label>
                    <select name="specialite_id" onchange="this.form.submit()"
                        class="w-full py-2.5 px-3 border border-input rounded-lg bg-background text-foreground text-sm focus:ring-2 focus:ring-red-500 transition-colors">
                        <option value="">-- Choisissez une spécialité --</option>
                        @foreach($specialites as $spec)
                            <option value="{{ $spec->id }}" {{ $selectedSpecialite && $selectedSpecialite->id === $spec->id ? 'selected' : '' }}>
                                {{ $spec->code }} - {{ $spec->intitule }} ({{ $spec->users()->count() }} apprenants)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Bouton Filtrer -->
                <div class="md:col-span-2">
                    <button type="submit"
                        class="w-full py-2.5 px-4 bg-muted hover:bg-muted/80 text-foreground text-sm font-medium rounded-lg border border-border transition-colors">
                        Actualiser
                    </button>
                </div>
            </form>
        </div>

        @if($selectedSpecialite)
            <!-- FORMULAIRE PRINCIPAL DE GÉNÉRATION D'ATTESTATIONS -->
            <form method="POST" action="{{ route('attestations.generer-lot-pdf') }}" target="_blank" class="space-y-6">
                @csrf
                <input type="hidden" name="annee_academique_id" value="{{ $selectedAnnee?->id }}">
                <input type="hidden" name="specialite_id" value="{{ $selectedSpecialite->id }}">

                <!-- 2. PARAMÈTRES GLOBAUX DU DOCUMENT -->
                <div class="bg-card rounded-xl shadow-sm border border-border p-5 space-y-4">
                    <div class="flex items-center justify-between border-b border-border pb-3">
                        <h2 class="text-sm font-semibold uppercase tracking-wider text-muted-foreground">
                            2. Paramètres & Arrêtés Ministériels
                        </h2>
                        <span class="text-xs px-2.5 py-1 bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 font-semibold rounded-full">
                            Spécialité : {{ $selectedSpecialite->intitule }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Date de Début globale -->
                        <div>
                            <label class="block text-xs font-semibold text-foreground mb-1">
                                Tranche de Début de formation :
                            </label>
                            <input type="date" id="global_date_debut" name="date_debut" value="{{ $defaultDateDebut }}"
                                @change="applyGlobalDatesToAll()"
                                class="w-full py-2 px-3 border border-input rounded-lg bg-background text-foreground text-sm focus:ring-2 focus:ring-red-500" required>
                        </div>

                        <!-- Date de Fin globale -->
                        <div>
                            <label class="block text-xs font-semibold text-foreground mb-1">
                                Tranche de Fin de formation :
                            </label>
                            <input type="date" id="global_date_fin" name="date_fin" value="{{ $defaultDateFin }}"
                                @change="applyGlobalDatesToAll()"
                                class="w-full py-2 px-3 border border-input rounded-lg bg-background text-foreground text-sm focus:ring-2 focus:ring-red-500" required>
                        </div>

                        <!-- Date de délivrance -->
                        <div>
                            <label class="block text-xs font-semibold text-foreground mb-1">
                                Fait à Bafoussam, le (Signature) :
                            </label>
                            <input type="date" id="global_date_delivrance" name="date_delivrance" value="{{ $defaultDateDelivrance }}"
                                @change="applyGlobalDatesToAll()"
                                class="w-full py-2 px-3 border border-input rounded-lg bg-background text-foreground text-sm focus:ring-2 focus:ring-red-500" required>
                        </div>
                    </div>

                    <!-- Arrêté ministériel principal modifiable -->
                    <div>
                        <label class="block text-xs font-semibold text-foreground mb-1 flex items-center justify-between">
                            <span>Arrêté Ministériel Principal (Sous l'en-tête) :</span>
                            <span class="text-xs text-muted-foreground font-normal">Modifiable pour cette impression</span>
                        </label>
                        <input type="text" name="arrete_principal" value="{{ $defaultArretes['principal'] }}"
                            class="w-full py-2 px-3 border border-input rounded-lg bg-background text-foreground text-sm focus:ring-2 focus:ring-red-500 font-medium" required>
                    </div>

                    <!-- Visas des anciens arrêtés -->
                    <div class="pt-2">
                        <label class="block text-xs font-semibold text-foreground mb-1.5">
                            Visas des Arrêtés antérieurs (Cocher ceux à inclure dans l'attestation) :
                        </label>
                        <div class="space-y-2 bg-muted/40 p-3 rounded-lg border border-border">
                            @forelse($allVisas as $visa)
                                <label class="flex items-start gap-2.5 text-xs text-foreground cursor-pointer">
                                    <input type="checkbox" name="visas_arretes[]" value="{{ $visa->texte }}"
                                        {{ $visa->is_active ? 'checked' : '' }}
                                        class="mt-0.5 rounded border-input text-red-600 focus:ring-red-500">
                                    <span class="leading-relaxed">{{ $visa->texte }}</span>
                                </label>
                            @empty
                                <div class="text-xs text-muted-foreground italic">Aucun visa configuré.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- 3. TABLEAU DES APPRENANTS DE LA SPÉCIALITÉ -->
                <div class="bg-card rounded-xl shadow-sm border border-border overflow-hidden">
                    <div class="p-4 bg-muted/50 border-b border-border flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <label class="flex items-center gap-2 text-xs font-semibold text-foreground cursor-pointer select-none">
                                <input type="checkbox" x-model="selectAll" @change="toggleAll()"
                                    class="rounded border-input text-red-600 focus:ring-red-500 h-4 w-4">
                                <span>Tout cocher / décocher</span>
                            </label>
                            <span class="text-xs px-2 py-0.5 rounded bg-muted text-muted-foreground font-medium">
                                <span x-text="selectedCount"></span> / {{ $students->count() }} sélectionnés
                            </span>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="button" @click="applyGlobalDatesToAll()"
                                class="text-xs text-red-600 hover:text-red-700 dark:text-red-400 font-medium flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Répercuter les dates globales
                            </button>
                        </div>
                    </div>

                    @if($students->isEmpty())
                        <div class="p-8 text-center text-muted-foreground">
                            <svg class="w-12 h-12 mx-auto text-muted-foreground/40 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <p class="font-medium">Aucun apprenant trouvé pour cette spécialité et cette année académique.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-muted/30 text-xs uppercase font-semibold text-muted-foreground border-b border-border">
                                    <tr>
                                        <th class="p-3 w-10 text-center">Sélec.</th>
                                        <th class="p-3">Apprenant</th>
                                        <th class="p-3">Date & Lieu de Naissance</th>
                                        <th class="p-3">Spécialité sur l'Attestation</th>
                                        <th class="p-3">Période & Date de signature</th>
                                        <th class="p-3 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border">
                                    @foreach($students as $student)
                                        @php
                                            $existing = $existingAttestations->get($student->id);
                                            $studentDateDebut = $existing?->date_debut ? $existing->date_debut->format('Y-m-d') : $defaultDateDebut;
                                            $studentDateFin = $existing?->date_fin ? $existing->date_fin->format('Y-m-d') : $defaultDateFin;
                                            $studentDateDelivrance = $existing?->date_delivrance ? $existing->date_delivrance->format('Y-m-d') : $defaultDateDelivrance;
                                            $customSpec = $existing?->specialite_personnalisee;
                                            $sexeLabel = strtoupper($student->sexe ?? '') === 'F' ? 'Née le' : 'Né le';
                                        @endphp
                                        <tr class="hover:bg-muted/20 transition-colors" x-data="{ customSpecialite: {{ !empty($customSpec) ? 'true' : 'false' }} }">
                                            <!-- Checkbox de sélection -->
                                            <td class="p-3 text-center">
                                                <input type="checkbox" name="selected_users[]" value="{{ $student->id }}"
                                                    checked
                                                    @change="updateCount()"
                                                    class="student-checkbox rounded border-input text-red-600 focus:ring-red-500 h-4 w-4">
                                            </td>

                                            <!-- Nom & Matricule -->
                                            <td class="p-3">
                                                <div class="font-bold text-foreground">
                                                    {{ strtoupper($student->name) }}
                                                </div>
                                                <div class="text-xs text-muted-foreground flex items-center gap-2">
                                                    <span>{{ $student->matricule ?? 'Sans matricule' }}</span>
                                                    <span>•</span>
                                                    <span class="inline-flex items-center px-1.5 py-0.2 rounded text-[10px] font-semibold {{ strtoupper($student->sexe ?? '') === 'F' ? 'bg-pink-100 text-pink-700 dark:bg-pink-900/40 dark:text-pink-300' : 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' }}">
                                                        {{ strtoupper($student->sexe ?? 'M') }}
                                                    </span>
                                                </div>
                                            </td>

                                            <!-- Date & Lieu de Naissance -->
                                            <td class="p-3 text-xs">
                                                <div class="font-medium text-foreground">
                                                    {{ $sexeLabel }} {{ $student->date_naissance ? \Carbon\Carbon::parse($student->date_naissance)->format('d/m/Y') : '..........' }}
                                                </div>
                                                <div class="text-muted-foreground">
                                                    à {{ strtoupper($student->lieu_naissance ?? '..........') }}
                                                </div>
                                            </td>

                                            <!-- Spécialité (Officielle ou Personnalisée) -->
                                            <td class="p-3">
                                                <div class="space-y-1.5 min-w-[220px]">
                                                    <div class="flex items-center gap-3 text-xs">
                                                        <label class="inline-flex items-center gap-1 cursor-pointer">
                                                            <input type="radio" :name="'use_custom_' + {{ $student->id }}"
                                                                :checked="!customSpecialite"
                                                                @change="customSpecialite = false; $refs.customInput{{ $student->id }}.value = ''"
                                                                class="text-red-600 focus:ring-red-500 text-xs">
                                                            <span class="text-foreground">Officielle</span>
                                                        </label>
                                                        <label class="inline-flex items-center gap-1 cursor-pointer">
                                                            <input type="radio" :name="'use_custom_' + {{ $student->id }}"
                                                                :checked="customSpecialite"
                                                                @change="customSpecialite = true; $nextTick(() => $refs.customInput{{ $student->id }}.focus())"
                                                                class="text-red-600 focus:ring-red-500 text-xs">
                                                            <span class="text-red-600 font-semibold">Personnalisée</span>
                                                        </label>
                                                    </div>

                                                    <div x-show="!customSpecialite" class="text-xs font-semibold text-red-600 dark:text-red-400">
                                                        {{ $selectedSpecialite->intitule }}
                                                    </div>

                                                    <div x-show="customSpecialite" style="display: none;">
                                                        <input type="text"
                                                            x-ref="customInput{{ $student->id }}"
                                                            name="students[{{ $student->id }}][specialite_personnalisee]"
                                                            value="{{ $customSpec }}"
                                                            placeholder="Ex: Graphisme de production..."
                                                            class="w-full text-xs py-1.5 px-2 border border-red-300 dark:border-red-800 rounded bg-background text-foreground font-semibold focus:ring-1 focus:ring-red-500">
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Tranche de dates individuelle & date de signature -->
                                            <td class="p-3">
                                                <div class="flex items-center gap-1 text-xs min-w-[200px]">
                                                    <input type="date"
                                                        name="students[{{ $student->id }}][date_debut]"
                                                        value="{{ $studentDateDebut }}"
                                                        class="student-date-debut text-xs py-1 px-1.5 border border-input rounded bg-background text-foreground w-28">
                                                    <span class="text-muted-foreground">au</span>
                                                    <input type="date"
                                                        name="students[{{ $student->id }}][date_fin]"
                                                        value="{{ $studentDateFin }}"
                                                        class="student-date-fin text-xs py-1 px-1.5 border border-input rounded bg-background text-foreground w-28">
                                                </div>
                                                <div class="flex items-center gap-1 text-[11px] text-muted-foreground mt-1.5">
                                                    <span>Signée le :</span>
                                                    <input type="date"
                                                        name="students[{{ $student->id }}][date_delivrance]"
                                                        value="{{ $studentDateDelivrance }}"
                                                        class="student-date-delivrance text-xs py-0.5 px-1.5 border border-input rounded bg-background text-foreground w-28">
                                                </div>
                                            </td>

                                            <!-- Action individuelle -->
                                            <td class="p-3 text-center whitespace-nowrap">
                                                <div class="flex items-center justify-center gap-1.5">
                                                    <a href="{{ route('attestations.apercu', $student->id) }}" target="_blank"
                                                        class="p-1.5 text-muted-foreground hover:text-foreground hover:bg-muted rounded transition-colors"
                                                        title="Aperçu à l'écran">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    @if($existing)
                                                        <a href="{{ route('attestations.pdf', $existing->id) }}"
                                                            class="p-1.5 text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-950/30 rounded transition-colors"
                                                            title="Télécharger l'attestation enregistrée">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                            </svg>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- BARRE FIXE D'ACTION D'IMPRESSION -->
                        <div class="p-4 bg-muted/40 border-t border-border flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="text-xs text-muted-foreground">
                                Chaque attestation générée sera au format officiel <strong>A4 Paysage</strong> et habillée avec le fond d'excellence CFP La Canadienne.
                            </div>

                            <div class="flex items-center gap-3">
                                <button type="submit" name="preview" value="1"
                                    class="inline-flex items-center px-4 py-2.5 border border-border text-sm font-medium rounded-lg text-foreground bg-card hover:bg-muted shadow-sm transition-all">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Prévisualiser le PDF
                                </button>

                                <button type="submit" name="preview" value="0"
                                    class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-bold rounded-lg text-white bg-red-600 hover:bg-red-700 shadow-sm transition-all">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                    Imprimer la sélection (<span x-text="selectedCount"></span>)
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </form>
        @else
            <!-- ÉTAT INITIAL SANS SÉLECTION -->
            <div class="bg-card rounded-xl border border-dashed border-border p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-red-500/40 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <h3 class="text-base font-bold text-foreground">Veuillez sélectionner une Spécialité ci-dessus</h3>
                <p class="text-sm text-muted-foreground mt-1 max-w-md mx-auto">
                    Choisissez la spécialité dont vous désirez imprimer les attestations de fin de formation (ex: Graphisme de production).
                </p>
            </div>
        @endif
    </div>
</x-app-layout>
