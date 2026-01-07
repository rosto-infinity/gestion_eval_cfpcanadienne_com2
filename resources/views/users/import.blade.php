@extends('layouts.app')

@section('title', 'Importation des Utilisateurs')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-foreground">Importation des Utilisateurs</h1>
                <p class="text-muted-foreground mt-2">Importez des utilisateurs en masse depuis un fichier Excel</p>
            </div>
            <a href="{{ route('users.index') }}" 
               class="px-4 py-2 bg-secondary hover:bg-secondary/80 text-secondary-foreground rounded-lg font-medium transition-all">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour
            </a>
        </div>
    </div>

    <!-- Carte principale -->
    <div class="bg-card border border-border rounded-lg shadow-sm">
        <div class="p-6">
            <!-- Instructions -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Instructions d'importation</h3>
                <ul class="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                    <li>• Téléchargez le modèle Excel ci-dessous pour avoir le bon format</li>
                    <li>• Les champs obligatoires : Nom et Email</li>
                    <li>• Le matricule sera généré automatiquement si non fourni</li>
                    <li>• Les doublons (email/matricule) seront rejetés</li>
                    <li>• Format accepté : .xlsx, .xls, .csv (max 10MB)</li>
                    <li>• Le rôle par défaut sera "USER" (colonne non incluse)</li>
                </ul>
            </div>

            <!-- Niveaux disponibles -->
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-green-900 dark:text-green-100 mb-2">Niveaux disponibles</h3>
                <div class="text-sm text-green-800 dark:text-green-200">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                        <div>• 3ème</div>
                        <div>• BEPC</div>
                        <div>• Première</div>
                        <div>• Probatoire</div>
                        <div>• Terminale</div>
                        <div>• Baccalauréat</div>
                        <div>• Licence</div>
                        <div>• CE</div>
                    </div>
                </div>
            </div>

            <!-- Spécialités disponibles -->
            <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">Spécialités disponibles</h3>
                <div class="text-sm text-purple-800 dark:text-purple-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div>• SECRETARIAT BUREAUTIQUE</div>
                        <div>• COMPTABILITE INFORMATISEE ET GESTION</div>
                        <div>• WEBMESTRE</div>
                        <div>• SECRETARIAT DE DIRECTION</div>
                        <div>• SECRETARIAT COMPTABLE</div>
                        <div>• MAINTENANCE INFORMATIQUE</div>
                        <div>• DEVELOPPEMENT D'APPLICATION</div>
                        <div>• GRAPHISME DE PRODUCTION</div>
                        <div>• MAINTENANCE DES RESEAUX INFORMATIQUES</div>
                    </div>
                </div>
            </div>

            <!-- Téléchargement du modèle -->
            <div class="mb-6">
                <form action="{{ route('users.import.template') }}" method="GET" class="inline">
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0-6-6-6-6v6m0 0-6-6-6-6v6"/>
                        </svg>
                        Télécharger le modèle Excel
                    </button>
                </form>
            </div>

            <!-- Formulaire d'importation -->
            <form action="{{ route('users.import.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Upload du fichier -->
                <div>
                    <label for="file" class="block text-sm font-semibold text-foreground mb-2">
                        Fichier d'importation *
                    </label>
                    <div class="relative">
                        <input type="file" 
                               name="file" 
                               id="file" 
                               accept=".xlsx,.xls,.csv"
                               class="w-full px-4 py-3 border border-border rounded-lg bg-background text-foreground file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-primary-foreground hover:file:bg-primary/90 cursor-pointer"
                               required>
                        
                        <!-- Aperçu du fichier -->
                        <div id="file-preview" class="hidden mt-2 p-3 bg-muted/30 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span id="file-name" class="text-sm font-medium"></span>
                                </div>
                                <button type="button" onclick="clearFile()" class="text-red-500 hover:text-red-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @error('file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bouton d'importation -->
                <div class="flex justify-end gap-4">
                    <a href="{{ route('users.index') }}" 
                       class="px-6 py-3 bg-secondary hover:bg-secondary/80 text-secondary-foreground rounded-lg font-medium transition-all">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-medium transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Importer les utilisateurs
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Rapport d'importation (si disponible) -->
    @if(session('import_report'))
        <div class="mt-8 bg-card border border-border rounded-lg shadow-sm">
            <div class="p-6">
                <h2 class="text-xl font-bold text-foreground mb-4">Rapport d'importation</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ session('import_report')['success_count'] }}
                        </div>
                        <div class="text-sm text-green-800 dark:text-green-200">Succès</div>
                    </div>
                    
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                        <div class="text-2xl font-bold text-red-600 dark:text-red-400">
                            {{ session('import_report')['failure_count'] }}
                        </div>
                        <div class="text-sm text-red-800 dark:text-red-200">Erreurs</div>
                    </div>
                    
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                        <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                            {{ session('import_report')['skipped_count'] }}
                        </div>
                        <div class="text-sm text-yellow-800 dark:text-yellow-200">Ignorées</div>
                    </div>
                    
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                            {{ session('import_report')['total_processed'] }}
                        </div>
                        <div class="text-sm text-blue-800 dark:text-blue-200">Total traitées</div>
                    </div>
                </div>

                <!-- Erreurs détaillées -->
                @if(session('import_errors') && count(session('import_errors')) > 0)
                    <div class="space-y-2">
                        <h3 class="font-semibold text-foreground">Erreurs détaillées</h3>
                        <div class="max-h-64 overflow-y-auto border border-border rounded-lg">
                            @foreach(session('import_errors') as $error)
                                <div class="p-3 border-b border-border last:border-b-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="font-medium text-foreground">
                                                Ligne {{ $error['row'] ?? '?' }}
                                            </div>
                                            <div class="text-sm text-red-600 dark:text-red-400">
                                                {{ $error['error'] ?? $error['errors'][0] ?? 'Erreur inconnue' }}
                                            </div>
                                            @if(isset($error['data']))
                                                <div class="text-xs text-muted-foreground mt-1">
                                                    Données : {{ json_encode($error['data'], JSON_UNESCAPED_UNICODE) }}
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
// Aperçu du fichier
document.getElementById('file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    
    if (file) {
        fileName.textContent = file.name;
        preview.classList.remove('hidden');
    } else {
        preview.classList.add('hidden');
    }
});

// Effacer le fichier
function clearFile() {
    document.getElementById('file').value = '';
    document.getElementById('file-preview').classList.add('hidden');
}
</script>
@endsection
