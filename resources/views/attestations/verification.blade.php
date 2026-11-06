<!DOCTYPE html>
<html lang="fr" class="h-full bg-slate-50 dark:bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification Officielle - Attestation de Fin de Formation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex flex-col justify-between text-slate-800 dark:text-slate-100">
    <div class="max-w-2xl mx-auto px-4 py-8 sm:py-12 w-full">
        <!-- Logo / Entête -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-500/10 border-2 border-emerald-500 text-emerald-600 dark:text-emerald-400 mb-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h1 class="text-xl sm:text-2xl font-black uppercase tracking-tight text-slate-900 dark:text-white">
                Authenticité Certifiée
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Centre de Formation Professionnelle la Canadienne (CFPC)
            </p>
        </div>

        <!-- Carte de vérification -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
            <!-- Bandeau statut -->
            <div class="bg-emerald-600 px-6 py-3 text-white flex items-center justify-between text-xs font-semibold">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    DOCUMENT OFFICIEL VÉRIFIÉ & CERTIFIÉ
                </span>
                <span class="font-mono">{{ $attestation->numero_attestation }}</span>
            </div>

            <!-- Détails du document -->
            <div class="p-6 sm:p-8 space-y-6">
                <!-- Apprenant -->
                <div class="border-b border-slate-100 dark:border-slate-700 pb-4">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Titulaire de l'Attestation</span>
                    <div class="text-xl font-black text-slate-900 dark:text-white mt-1">
                        {{ strtoupper($attestation->user->name) }}
                    </div>
                    <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        {{ $attestation->prefixe_naissance }} {{ $attestation->user->date_naissance ? \Carbon\Carbon::parse($attestation->user->date_naissance)->format('d/m/Y') : '..........' }}
                        à {{ strtoupper($attestation->user->lieu_naissance ?? '..........') }}
                    </div>
                    @if($attestation->user->matricule)
                        <div class="text-xs font-mono text-slate-600 dark:text-slate-300 mt-1">
                            Matricule : {{ $attestation->user->matricule }}
                        </div>
                    @endif
                </div>

                <!-- Spécialité & Dates -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Spécialité Validée</span>
                        <div class="text-sm font-bold text-red-600 dark:text-red-400 mt-1">
                            {{ $attestation->specialite_libelle }}
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Période de Formation</span>
                        <div class="text-sm font-medium text-slate-800 dark:text-slate-200 mt-1">
                            Du {{ $attestation->date_debut->format('d/m/Y') }} au {{ $attestation->date_fin->format('d/m/Y') }}
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Session Académique</span>
                        <div class="text-sm font-medium text-slate-800 dark:text-slate-200 mt-1">
                            {{ $attestation->anneeAcademique?->libelle ?? 'N/A' }}
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Délivrée le</span>
                        <div class="text-sm font-medium text-slate-800 dark:text-slate-200 mt-1">
                            {{ $attestation->date_delivrance->format('d/m/Y') }} à {{ $attestation->lieu_delivrance }}
                        </div>
                    </div>
                </div>

                <!-- Référence ministérielle -->
                <div class="bg-slate-50 dark:bg-slate-900/50 p-4 rounded-xl text-xs space-y-1.5 border border-slate-100 dark:border-slate-700/60">
                    <span class="font-bold text-slate-700 dark:text-slate-300 block">Cadre Légal & Agréments MINEFOP :</span>
                    <p class="text-slate-600 dark:text-slate-400 italic">
                        {{ $attestation->arrete_principal }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Pied de page -->
        <div class="text-center mt-8 text-xs text-slate-400">
            Centre de Formation Professionnelle la Canadienne • B.P. 837 Bafoussam • Cameroun
        </div>
    </div>
</body>
</html>

