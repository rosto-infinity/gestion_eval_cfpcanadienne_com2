@extends('layouts.app')

@section('title', 'Importation des Utilisateurs')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-foreground tracking-tight">Importation</h1>
                <p class="text-sm text-muted-foreground mt-1">Importez massivement des étudiants via Excel ou CSV</p>
            </div>
            <a href="{{ route('users.index') }}"
                class="inline-flex items-center justify-center px-4 py-2 border border-input rounded-lg text-sm font-medium text-foreground bg-background hover:bg-muted transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>

        <!-- Notifications -->
        @if (session('success'))
            <div
                class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-lg p-4 flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <p class="font-medium text-sm">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div
                class="bg-destructive/10 border border-destructive/20 text-destructive rounded-lg p-4 flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="font-medium text-sm">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Informations et Guide (3 Colonnes) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Colonne 1: Instructions -->
            <div class="bg-card border border-border rounded-xl p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <div class="p-2 bg-primary/10 rounded-lg text-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-foreground">Instructions</h3>
                </div>
                <ul class="space-y-3 text-sm text-muted-foreground">
                    <li class="flex items-start gap-2">
                        <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary shrink-0"></span>
                        <span>Téléchargez le modèle Excel ci-dessous pour le format exact.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary shrink-0"></span>
                        <span>Champs obligatoires : <strong class="text-foreground">Nom</strong> et <strong
                                class="text-foreground">Email</strong>.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary shrink-0"></span>
                        <span>Matricule généré automatiquement si vide.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary shrink-0"></span>
                        <span>Mot de passe par défaut : <strong>Cfpc3231</strong></span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary shrink-0"></span>
                        <span>Statut par défaut : <strong>Actif</strong></span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary shrink-0"></span>
                        <span>Formats : .xlsx, .xls, .csv (max 10MB).</span>
                    </li>
                </ul>
                <div class="mt-6">
                    <a href="{{ route('users.import.template') }}"
                        class="inline-flex items-center text-sm font-medium text-primary hover:text-primary/80 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Télécharger le modèle
                    </a>
                </div>
            </div>

            <!-- Colonne 2: Niveaux -->
            <div class="bg-card border border-border rounded-xl p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <div class="p-2 bg-secondary rounded-lg text-secondary-foreground">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-foreground">Niveaux</h3>
                </div>
                <div class="grid grid-cols-2 gap-2 text-sm text-muted-foreground">
                    <div class="flex items-center gap-2">
                        <span class="w-1 h-1 rounded-full bg-muted-foreground"></span> 3ème
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1 h-1 rounded-full bg-muted-foreground"></span> BEPC
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1 h-1 rounded-full bg-muted-foreground"></span> Première
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1 h-1 rounded-full bg-muted-foreground"></span> Probatoire
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1 h-1 rounded-full bg-muted-foreground"></span> Terminale
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1 h-1 rounded-full bg-muted-foreground"></span> Baccalauréat
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1 h-1 rounded-full bg-muted-foreground"></span> Licence
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1 h-1 rounded-full bg-muted-foreground"></span> CE
                    </div>
                </div>
            </div>

            <!-- Colonne 3: Spécialités -->
            <div class="bg-card border border-border rounded-xl p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <div class="p-2 bg-secondary rounded-lg text-secondary-foreground">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-foreground">Spécialités</h3>
                </div>
                <ul class="space-y-2 text-xs text-muted-foreground uppercase tracking-wide">
                    <li>SECRETARIAT BUREAUTIQUE</li>
                    <li>COMPTABILITE INFORMATISEE ET GESTION</li>
                    <li>WEBMESTRE</li>
                    <li>SECRETARIAT DE DIRECTION</li>
                    <li>SECRETARIAT COMPTABLE</li>
                    <li>MAINTENANCE INFORMATIQUE</li>
                    <li>DEVELOPPEMENT D'APPLICATION</li>
                    <li>GRAPHISME DE PRODUCTION</li>
                    <li>MAINTENANCE DES RESEAUX INFORMATIQUES</li>
                </ul>
            </div>
        </div>

        <!-- Zone d'Import (Minimaliste) -->
        <div class="bg-card border border-border rounded-xl shadow-sm p-6">
            <form action="{{ route('users.import.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div
                    class="flex items-center gap-4 p-4 border border-dashed border-primary/30 rounded-lg bg-primary/5 hover:bg-primary/10 transition-colors">
                    <div class="flex-1 min-w-0">
                        <label class="block mb-1 text-sm font-medium text-foreground">Sélectionner un fichier</label>
                        <div class="flex items-center gap-3">
                            <label for="file"
                                class="cursor-pointer px-3 py-1.5 text-xs font-medium text-primary bg-primary/10 rounded-md hover:bg-primary/20 transition-colors shrink-0">
                                Choisir Excel/CSV
                                <input type="file" name="file" id="file" accept=".xlsx,.xls,.csv"
                                    class="hidden" required>
                            </label>
                            <span id="file-name" class="text-xs text-muted-foreground truncate">Aucun fichier
                                choisi</span>
                            <button type="button" onclick="clearFile()" id="clear-btn"
                                class="hidden text-destructive hover:text-destructive/80 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <button type="submit"
                        class="px-5 py-2.5 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg text-sm font-bold transition-all shadow-sm flex items-center gap-2 shrink-0">
                        <span>Importer</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>

                @error('file')
                    <p class="text-xs text-destructive text-center mt-2">{{ $message }}</p>
                @enderror
            </form>
        </div>

        <!-- Rapport d'importation -->
        @if (session('import_report'))
            <div
                class="bg-card border border-border rounded-xl shadow-sm overflow-hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
                <div class="px-6 py-4 border-b border-border bg-muted/30 flex items-center justify-between">
                    <h2 class="font-bold text-foreground">Résultat de l'importation</h2>
                    <span class="text-sm text-muted-foreground">{{ now()->format('d/m/Y H:i') }}</span>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div class="p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400 mb-1">
                                {{ session('import_report')['success_count'] }}
                            </div>
                            <div class="text-xs font-medium text-green-700 dark:text-green-300 uppercase tracking-wide">
                                Succès</div>
                        </div>

                        <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-center">
                            <div class="text-2xl font-bold text-destructive mb-1">
                                {{ session('import_report')['failure_count'] }}
                            </div>
                            <div class="text-xs font-medium text-destructive uppercase tracking-wide">
                                Erreurs</div>
                        </div>

                        <div class="p-4 rounded-xl bg-yellow-500/10 border border-yellow-500/20 text-center">
                            <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400 mb-1">
                                {{ session('import_report')['skipped_count'] }}
                            </div>
                            <div class="text-xs font-medium text-yellow-700 dark:text-yellow-300 uppercase tracking-wide">
                                Ignorées</div>
                        </div>

                        <div class="p-4 rounded-xl bg-blue-500/10 border border-blue-500/20 text-center">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-1">
                                {{ session('import_report')['total_processed'] }}
                            </div>
                            <div class="text-xs font-medium text-blue-700 dark:text-blue-300 uppercase tracking-wide">
                                Total
                            </div>
                        </div>
                    </div>

                    @if (session('import_errors') && count(session('import_errors')) > 0)
                        <div class="border border-border rounded-lg overflow-hidden">
                            <div class="bg-muted/30 px-4 py-2 border-b border-border font-medium text-sm text-foreground">
                                Détails des erreurs
                            </div>
                            <div class="max-h-60 overflow-y-auto divide-y divide-border bg-background">
                                @foreach (session('import_errors') as $error)
                                    <div class="p-4 hover:bg-muted/20 transition-colors">
                                        <div class="flex items-start gap-3">
                                            <span
                                                class="shrink-0 inline-flex items-center justify-center w-6 h-6 rounded-full bg-destructive/10 text-destructive text-xs font-bold">
                                                {{ $error['row'] ?? '!' }}
                                            </span>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-foreground">
                                                    {{ $error['error'] ?? ($error['errors'][0] ?? 'Erreur inconnue') }}
                                                </p>
                                                @if (isset($error['data']))
                                                    <div
                                                        class="mt-1 text-xs font-mono text-muted-foreground bg-muted p-1.5 rounded truncate">
                                                        {{ json_encode($error['data'], JSON_UNESCAPED_UNICODE) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <script>
        document.getElementById('file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const fileName = document.getElementById('file-name');
            const clearBtn = document.getElementById('clear-btn');

            if (file) {
                fileName.textContent = file.name;
                fileName.classList.remove('text-muted-foreground');
                fileName.classList.add('text-foreground', 'font-medium');
                clearBtn.classList.remove('hidden');
            } else {
                clearFile();
            }
        });

        function clearFile(e) {
            if (e) e.preventDefault();
            document.getElementById('file').value = '';
            const fileName = document.getElementById('file-name');
            const clearBtn = document.getElementById('clear-btn');

            fileName.textContent = 'Aucun fichier choisi';
            fileName.classList.add('text-muted-foreground');
            fileName.classList.remove('text-foreground', 'font-medium');
            clearBtn.classList.add('hidden');
        }
    </script>
@endsection
