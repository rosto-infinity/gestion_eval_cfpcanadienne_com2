@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight " style="color: var(--foreground)">
            {{ __('Mon Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Grille 2 Colonnes -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- COLONNE 1: Informations Personnelles & Sécurité -->
                <div class="space-y-6">
                    
                    <!-- Modification Informations Personnelles -->
                    <div class="p-6 rounded-lg shadow-md" style="background-color: var(--card); border: 1px solid var(--border)">
                        <div class="flex items-center mb-6 pb-6" style="border-bottom: 1px solid var(--border)">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: var(--secondary)">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--foreground)">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold ml-3" style="color: var(--foreground)">
                                Informations Personnelles
                            </h3>
                        </div>

                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <!-- Mise à jour du Mot de Passe -->
                    <div class="p-6 rounded-lg shadow-md" style="background-color: var(--card); border: 1px solid var(--border)">
                        <div class="flex items-center mb-6 pb-6" style="border-bottom: 1px solid var(--border)">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: var(--secondary)">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--foreground)">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold ml-3" style="color: var(--foreground)">
                                Sécurité du Compte
                            </h3>
                        </div>

                        @include('profile.partials.update-password-form')
                    </div>

                    <!-- Suppression du Compte -->
                    @if(auth()->user()->role->isAtLeast(\App\Enums\Role::SUPERADMIN))
                    <div class="p-6 rounded-lg shadow-md" style="background-color: var(--card); border: 1px solid var(--destructive)">
                        <div class="flex items-center mb-6 pb-6" style="border-bottom: 1px solid var(--destructive)">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: var(--destructive)">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--destructive-foreground)">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold ml-3" style="color: var(--destructive)">
                                Zone Dangereuse
                            </h3>
                            
                        </div>
                        @include('profile.partials.delete-user-form')
                    </div>
                    @endif
                </div>

                <!-- COLONNE 2: Informations du Profil -->
                <div class="space-y-6">
                    <!-- Carte Profil -->
                    <div class="p-6 rounded-lg shadow-md" style="background-color: var(--card); border: 1px solid var(--border)">
                        <!-- En-tête avec Avatar -->
                        <div class="flex items-center mb-6 pb-6" style="border-bottom: 1px solid var(--border)">
                            <!-- Avatar avec image de profil -->
                            @if(auth()->user()->profile)
                                <img src="{{ Storage::url(auth()->user()->profile) }}" 
                                     alt="Photo de profil" 
                                     class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-lg">
                            @else
                                <div class="w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold" style="background-color: var(--primary); color: var(--primary-foreground)">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold" style="color: var(--foreground)">
                                    {{ auth()->user()->name }}
                                </h3>
                                <p class="text-sm" style="color: var(--muted-foreground)">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>
                        </div>

                        <!-- Informations Utilisateur -->
                        <div class="space-y-4">
                            @if(auth()->user()->matricule)
                                <div class="flex justify-between items-center py-2" style="border-bottom: 1px solid var(--border)">
                                    <span class="text-sm font-medium" style="color: var(--muted-foreground)">Matricule :</span>
                                    <span class="text-sm font-semibold" style="color: var(--foreground)">{{ auth()->user()->matricule }}</span>
                                </div>
                            @endif

                            @if(auth()->user()->sexe)
                                <div class="flex justify-between items-center py-2" style="border-bottom: 1px solid var(--border)">
                                    <span class="text-sm font-medium" style="color: var(--muted-foreground)">Sexe :</span>
                                    <span class="text-sm" style="color: var(--foreground)">
                                        @if(auth()->user()->sexe === 'M')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: var(--secondary); color: var(--secondary-foreground)">
                                                👨 Masculin
                                            </span>
                                        @elseif(auth()->user()->sexe === 'F')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: var(--secondary); color: var(--secondary-foreground)">
                                                👩 Féminin
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: var(--muted); color: var(--muted-foreground)">
                                                Autre
                                            </span>
                                        @endif
                                    </span>
                                </div>
                            @endif

                            @if(auth()->user()->specialite_id && auth()->user()->specialite)
                                <div class="flex justify-between items-center py-2" style="border-bottom: 1px solid var(--border)">
                                    <span class="text-sm font-medium" style="color: var(--muted-foreground)">Spécialité :</span>
                                    <span class="text-sm font-semibold" style="color: var(--foreground)">{{ auth()->user()->specialite->intitule }}</span>
                                </div>
                            @else
                                <div class="flex justify-between items-center py-2" style="border-bottom: 1px solid var(--border)">
                                    <span class="text-sm font-medium" style="color: var(--muted-foreground)">Spécialité :</span>
                                    <span class="text-sm" style="color: var(--muted-foreground)">Non définie</span>
                                </div>
                            @endif

                            @if(auth()->user()->annee_academique_id && auth()->user()->anneeAcademique)
                                <div class="flex justify-between items-center py-2" style="border-bottom: 1px solid var(--border)">
                                    <span class="text-sm font-medium" style="color: var(--muted-foreground)">Année Académique :</span>
                                    <span class="text-sm font-semibold" style="color: var(--foreground)">{{ auth()->user()->anneeAcademique->libelle }}</span>
                                </div>
                            @else
                                <div class="flex justify-between items-center py-2" style="border-bottom: 1px solid var(--border)">
                                    <span class="text-sm font-medium" style="color: var(--muted-foreground)">Année Académique :</span>
                                    <span class="text-sm" style="color: var(--muted-foreground)">Non définie</span>
                                </div>
                            @endif

                            @if(auth()->user()->niveau)
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-sm font-medium" style="color: var(--muted-foreground)">Niveau :</span>
                                    <span class="text-sm font-semibold" style="color: var(--foreground)">{{ auth()->user()->niveau }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Mise à jour Photo de Profil -->
                    <div class="p-6 rounded-lg shadow-md" style="background-color: var(--card); border: 1px solid var(--border)">
                        <div class="flex items-center mb-6 pb-6" style="border-bottom: 1px solid var(--border)">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: var(--secondary)">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--foreground)">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold ml-3" style="color: var(--foreground)">
                                Photo de Profil
                            </h3>
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <!-- Photo actuelle -->
                            @if(auth()->user()->profile)
                                <div class="flex items-center gap-4 p-3 rounded-lg" style="background-color: var(--muted); border: 1px solid var(--border)">
                                    <img src="{{ Storage::url(auth()->user()->profile) }}" alt="Photo actuelle" 
                                         class="h-12 w-12 object-cover rounded-full border-2 border-white shadow">
                                    <div>
                                        <p class="text-sm font-medium" style="color: var(--foreground)">Photo actuelle</p>
                                        <a href="{{ Storage::url(auth()->user()->profile) }}" target="_blank" 
                                           class="text-xs" style="color: var(--primary)">Voir en grand</a>
                                    </div>
                                </div>
                            @endif

                            <!-- Zone d'upload -->
                            <label for="profile" class="cursor-pointer block">
                                <div id="upload-zone"
                                    class="border-2 border-dashed rounded-xl p-6 text-center transition-all duration-300 relative group"
                                    style="border-color: var(--border); color: var(--muted-foreground)"
                                    onmouseover="this.style.borderColor='var(--primary)'"
                                    onmouseout="this.style.borderColor='var(--border)'">
                                    
                                    <!-- Image de prévisualisation -->
                                    <div id="image-preview-container" class="mb-4">
                                        <div id="placeholder-icon" class="mx-auto">
                                            <svg class="h-16 w-16 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--muted-foreground)">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                            </svg>
                                        </div>
                                        <img id="preview-image" class="hidden mx-auto h-24 w-24 object-cover rounded-full border-4 border-white shadow-lg" alt="Aperçu">
                                    </div>
                                    
                                    <p class="text-sm transition-colors">
                                        <span class="font-semibold">Cliquez pour changer</span> ou glissez-déposez
                                    </p>
                                    <p class="text-xs mt-2" style="color: var(--muted-foreground)">
                                        Formats: PNG, JPG, GIF, SVG, WEBP (max. 2MB)
                                    </p>
                                    
                                    <!-- Indicateur de chargement -->
                                    <div id="loading-indicator" class="hidden absolute inset-0 rounded-xl flex items-center justify-center" style="background-color: rgba(255,255,255,0.8)">
                                        <div class="animate-spin rounded-full h-8 w-8 border-b-2" style="border-color: var(--primary)"></div>
                                    </div>
                                </div>
                                <input type="file" id="profile" name="profile" accept="image/*" class="hidden"
                                    onchange="handleImageUpload(event)">
                            </label>

                            <!-- Informations sur le fichier -->
                            <div id="file-info" class="hidden p-3 rounded-lg" style="background-color: var(--secondary); border: 1px solid var(--border)">
                                <div class="flex items-center gap-2 text-sm" style="color: var(--foreground)">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span id="file-name"></span>
                                    <span id="file-size" class="text-xs"></span>
                                </div>
                            </div>

                            <!-- Bouton de sauvegarde -->
                            <button type="submit" class="w-full py-2.5 px-4 rounded-lg font-medium transition-colors duration-200"
                                    style="background-color: var(--primary); color: var(--primary-foreground)"
                                    onmouseover="this.style.backgroundColor='var(--primary-hover)'"
                                    onmouseout="this.style.backgroundColor='var(--primary)'">
                                Mettre à jour la photo
                            </button>
                        </form>
                    </div>
                   
                    <!-- Statistiques -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Compte Actif -->
                        <div class="p-4 rounded-lg" style="background-color: var(--secondary); border: 1px solid var(--border)">
                            <div class="text-2xl font-bold" style="color: var(--foreground)">✓</div>
                            <p class="text-xs mt-2" style="color: var(--muted-foreground)">Compte Actif</p>
                        </div>
                        <!-- Email Vérifié -->
                        <div class="p-4 rounded-lg" style="background-color: var(--secondary); border: 1px solid var(--border)">
                            <div class="text-2xl font-bold" style="color: var(--foreground)">📧</div>
                            <p class="text-xs mt-2" style="color: var(--muted-foreground)">Email Vérifié</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations Supplémentaires -->
            <div class="mt-6 p-6 rounded-lg" style="background-color: var(--secondary); border: 1px solid var(--border)">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" style="color: var(--muted-foreground)">
                            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm" style="color: var(--foreground)">
                            <strong>Conseil de sécurité :</strong> Gardez votre mot de passe confidentiel et changez-le régulièrement. Ne partagez jamais vos identifiants avec d'autres personnes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Fonction pour la gestion de l'upload d'image
function handleImageUpload(event) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('image-preview-container');
    const previewImage = document.getElementById('preview-image');
    const placeholderIcon = document.getElementById('placeholder-icon');
    const loadingIndicator = document.getElementById('loading-indicator');
    const fileInfo = document.getElementById('file-info');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    
    // Réinitialiser l'état
    if (file) {
        // Afficher le loader
        loadingIndicator.classList.remove('hidden');
        
        // Validation côté client
        const maxSize = 2 * 1024 * 1024; // 2MB
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp'];
        
        if (!allowedTypes.includes(file.type)) {
            showError('Le format de fichier n\'est pas autorisé. Formats acceptés: PNG, JPG, GIF, SVG, WEBP');
            resetUploadState();
            return;
        }
        
        if (file.size > maxSize) {
            showError('L\'image ne doit pas dépasser 2MB');
            resetUploadState();
            return;
        }
        
        // Afficher les informations du fichier
        fileName.textContent = file.name;
        fileSize.textContent = `(${formatFileSize(file.size)})`;
        fileInfo.classList.remove('hidden');
        
        // Lire et afficher l'image
        const reader = new FileReader();
        reader.onload = function(e) {
            setTimeout(() => {
                previewImage.src = e.target.result;
                previewImage.classList.remove('hidden');
                placeholderIcon.classList.add('hidden');
                loadingIndicator.classList.add('hidden');
            }, 500); // Simuler un léger délai pour montrer le loader
        };
        
        reader.onerror = function() {
            showError('Erreur lors de la lecture du fichier');
            resetUploadState();
        };
        
        reader.readAsDataURL(file);
    }
}

// Fonction pour réinitialiser l'état de l'upload
function resetUploadState() {
    const previewImage = document.getElementById('preview-image');
    const placeholderIcon = document.getElementById('placeholder-icon');
    const loadingIndicator = document.getElementById('loading-indicator');
    const fileInfo = document.getElementById('file-info');
    
    previewImage.classList.add('hidden');
    placeholderIcon.classList.remove('hidden');
    loadingIndicator.classList.add('hidden');
    fileInfo.classList.add('hidden');
}

// Fonction pour afficher une erreur
function showError(message) {
    // Créer une notification d'erreur temporaire
    const errorDiv = document.createElement('div');
    errorDiv.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-pulse';
    errorDiv.innerHTML = `
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            ${message}
        </div>
    `;
    
    document.body.appendChild(errorDiv);
    
    // Auto-suppression après 3 secondes
    setTimeout(() => {
        errorDiv.remove();
    }, 3000);
}

// Fonction pour formater la taille du fichier
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Gestion du drag and drop
document.addEventListener('DOMContentLoaded', function() {
    const uploadZone = document.getElementById('upload-zone');
    const fileInput = document.getElementById('profile');
    
    if (uploadZone) {
        // Empêcher le comportement par défaut
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, preventDefaults, false);
        });
        
        // Gérer le drop
        uploadZone.addEventListener('drop', handleDrop, false);
    }
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            handleImageUpload({ target: fileInput });
        }
    }
    
    console.log('Page de profil chargée avec gestion avancée des images');
});
</script>
@endsection
