<x-app-layout title="Gestion des Arrêtés & Visas">
    <div class="mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('attestations.par-specialite') }}"
                    class="text-xs text-muted-foreground hover:text-foreground inline-flex items-center gap-1 mb-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour aux attestations
                </a>
                <h1 class="text-2xl font-bold text-foreground tracking-tight flex items-center gap-2">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Paramétrage des Arrêtés Ministériels & Visas
                </h1>
                <p class="text-sm text-muted-foreground mt-1">
                    Gérez l'arrêté principal affiché sur les documents et l'historique des arrêtés d'agrément (MINEFOP)
                </p>
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

        <!-- 1. ARRÊTÉ PRINCIPAL EN VIGUEUR -->
        <div class="bg-card rounded-xl shadow-sm border border-border p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-border pb-3">
                <div>
                    <h2 class="text-base font-bold text-foreground">Arrêté Ministériel Principal en Vigueur</h2>
                    <p class="text-xs text-muted-foreground mt-0.5">
                        Ce texte s'affiche en rouge directement sous l'en-tête de l'attestation et sur les relevés de notes.
                    </p>
                </div>
                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300">
                    Bandeau Supérieur
                </span>
            </div>

            @if($principal)
                <form method="POST" action="{{ route('settings.arretes.update', $principal->id) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <div class="md:col-span-4">
                            <label class="block text-xs font-semibold text-foreground mb-1">Numéro d'Arrêté :</label>
                            <input type="text" name="numero" value="{{ $principal->numero }}"
                                class="w-full py-2 px-3 border border-input rounded-lg bg-background text-foreground text-sm focus:ring-2 focus:ring-red-500">
                        </div>

                        <div class="md:col-span-8">
                            <label class="block text-xs font-semibold text-foreground mb-1">Texte intégral affiché :</label>
                            <input type="text" name="texte" value="{{ $principal->texte }}"
                                class="w-full py-2 px-3 border border-input rounded-lg bg-background text-foreground text-sm focus:ring-2 focus:ring-red-500 font-medium" required>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit"
                            class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold text-sm rounded-lg shadow-sm transition-all">
                            Enregistrer l'Arrêté Principal
                        </button>
                    </div>
                </form>
            @else
                <form method="POST" action="{{ route('settings.arretes.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="type" value="principal">

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <div class="md:col-span-4">
                            <label class="block text-xs font-semibold text-foreground mb-1">Numéro d'Arrêté :</label>
                            <input type="text" name="numero" placeholder="Ex: 000355/ MINEFOP/..."
                                class="w-full py-2 px-3 border border-input rounded-lg bg-background text-foreground text-sm focus:ring-2 focus:ring-red-500">
                        </div>

                        <div class="md:col-span-8">
                            <label class="block text-xs font-semibold text-foreground mb-1">Texte officiel :</label>
                            <input type="text" name="texte" placeholder="Ex: Créé et agréé, renouvelé par Arrêté ministériel N° ..."
                                class="w-full py-2 px-3 border border-input rounded-lg bg-background text-foreground text-sm focus:ring-2 focus:ring-red-500 font-medium" required>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit"
                            class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold text-sm rounded-lg shadow-sm transition-all">
                            Créer l'Arrêté Principal
                        </button>
                    </div>
                </form>
            @endif
        </div>

        <!-- 2. LISTE DES VISAS ADMINISTRATIFS ("Vu l'Arrêté...") -->
        <div class="bg-card rounded-xl shadow-sm border border-border p-6 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-border pb-4">
                <div>
                    <h2 class="text-base font-bold text-foreground">Historique des Agréments & Visas ("Vu l'Arrêté...")</h2>
                    <p class="text-xs text-muted-foreground mt-0.5">
                        Liste ordonnée des arrêtés ministériels cités dans le corps de l'attestation.
                    </p>
                </div>
            </div>

            <!-- TABLEAU DES VISAS EXISTANTS -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-muted/40 text-xs uppercase font-semibold text-muted-foreground border-b border-border">
                        <tr>
                            <th class="p-3 w-16 text-center">Ordre</th>
                            <th class="p-3">Texte du Visa Administratif</th>
                            <th class="p-3 w-32">Date</th>
                            <th class="p-3 w-28 text-center">Statut</th>
                            <th class="p-3 w-32 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($visas as $visa)
                            <tr class="hover:bg-muted/20 transition-colors">
                                <td class="p-3 text-center font-bold text-muted-foreground">
                                    {{ $visa->ordre }}
                                </td>

                                <td class="p-3">
                                    <form id="form-visa-{{ $visa->id }}" method="POST" action="{{ route('settings.arretes.update', $visa->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <textarea name="texte" rows="2"
                                            class="w-full text-xs p-2 border border-input rounded bg-background text-foreground focus:ring-1 focus:ring-red-500 font-medium">{{ $visa->texte }}</textarea>
                                    </form>
                                </td>

                                <td class="p-3 text-xs text-muted-foreground">
                                    {{ $visa->date_arrete ? $visa->date_arrete->format('d/m/Y') : 'N/A' }}
                                </td>

                                <td class="p-3 text-center">
                                    <a href="{{ route('settings.arretes.toggle', $visa->id) }}"
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold cursor-pointer transition-colors {{ $visa->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' }}"
                                        title="Cliquer pour changer">
                                        {{ $visa->is_active ? 'Actif' : 'Inactif' }}
                                    </a>
                                </td>

                                <td class="p-3 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="submit" form="form-visa-{{ $visa->id }}"
                                            class="p-1.5 text-blue-600 hover:text-blue-700 hover:bg-blue-50 dark:hover:bg-blue-950/40 rounded transition-colors"
                                            title="Enregistrer les modifications">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>

                                        <form method="POST" action="{{ route('settings.arretes.destroy', $visa->id) }}" onsubmit="return confirm('Supprimer ce visa définitivement ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-950/40 rounded transition-colors"
                                                title="Supprimer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-muted-foreground italic">
                                    Aucun visa enregistré.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- FORMULAIRE D'AJOUT D'UN NOUVEAU VISA -->
            <div class="bg-muted/30 p-5 rounded-xl border border-border">
                <h3 class="text-sm font-bold text-foreground mb-3 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Ajouter un nouvel Arrêté / Visa
                </h3>

                <form method="POST" action="{{ route('settings.arretes.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="type" value="visa">

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                        <div class="md:col-span-3">
                            <label class="block text-xs font-semibold text-foreground mb-1">Numéro d'Arrêté :</label>
                            <input type="text" name="numero" placeholder="Ex: 000355/MINEFOP/..."
                                class="w-full text-xs py-2 px-3 border border-input rounded-lg bg-background text-foreground">
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-xs font-semibold text-foreground mb-1">Date de signature :</label>
                            <input type="date" name="date_arrete"
                                class="w-full text-xs py-2 px-3 border border-input rounded-lg bg-background text-foreground">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-foreground mb-1">Ordre d'affichage :</label>
                            <input type="number" name="ordre" value="{{ ($visas->max('ordre') ?? 0) + 1 }}"
                                class="w-full text-xs py-2 px-3 border border-input rounded-lg bg-background text-foreground">
                        </div>

                        <div class="md:col-span-4 flex items-end">
                            <label class="flex items-center gap-2 text-xs font-semibold text-foreground cursor-pointer pb-2.5">
                                <input type="checkbox" name="is_active" value="1" checked
                                    class="rounded border-input text-red-600 focus:ring-red-500">
                                <span>Actif (Inclus par défaut)</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-foreground mb-1">Texte intégral du visa ("Vu l'Arrêté...") :</label>
                        <textarea name="texte" rows="2" placeholder="Vu l'Arrêté n° ... du ... portant ..." required
                            class="w-full text-xs p-2.5 border border-input rounded-lg bg-background text-foreground focus:ring-1 focus:ring-red-500"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-5 py-2 bg-foreground text-background hover:bg-foreground/90 font-semibold text-xs rounded-lg shadow-sm transition-all">
                            Ajouter ce Visa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

