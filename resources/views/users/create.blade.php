@extends('layouts.app')

@section('title', 'Créer un Utilisateur')

@section('content')
    <div class=" mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- En-tête -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-3">
                <a href="{{ route('users.index') }}"
                    class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-primary/10 hover:bg-primary/20 transition-colors duration-200">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-foreground">👤 Créer un Utilisateur</h1>
                    <p class="mt-1 text-sm text-muted-foreground">
                        Remplissez le formulaire ci-dessous pour créer un nouvel utilisateur.
                    </p>
                </div>
            </div>
        </div>

        <!-- Messages d'erreur -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-destructive/10 border-l-4 border-destructive rounded-lg">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-destructive" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-destructive mb-2">Erreurs de validation</h3>
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm text-destructive/90 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-destructive flex-shrink-0"></span>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulaire -->
        <form action="{{ route('users.store') }}" method="POST" class="space-y-8 enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- COLONNE GAUCHE : Informations personnelles -->
                <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-border bg-muted/30">
                        <h2 class="text-lg font-bold text-foreground flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                            Informations Personnelles
                        </h2>
                    </div>
                    <div class="p-6 space-y-6">

                        <!-- Nom -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-foreground mb-2">
                                Nom
                                <span class="text-destructive font-bold">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                placeholder="Ex: Jean Dupont"
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('name') border-destructive ring-2 ring-destructive/50 @enderror">
                            @error('name')
                                <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-foreground mb-2">
                                Email
                                <span class="text-destructive font-bold">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                placeholder="exemple@email.com"
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('email') border-destructive ring-2 ring-destructive/50 @enderror">
                            @error('email')
                                <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>



                        <!-- Sexe -->
                        <div>
                            <label for="sexe" class="block text-sm font-semibold text-foreground mb-2">
                                Sexe
                                <span class="text-destructive font-bold">*</span>
                            </label>
                            <select id="sexe" name="sexe"
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('sexe') border-destructive ring-2 ring-destructive/50 @enderror">
                                <option value="">-- Sélectionner --</option>
                                <option value="M" {{ old('sexe') === 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="F" {{ old('sexe') === 'F' ? 'selected' : '' }}>Féminin</option>
                                <option value="Autre" {{ old('sexe') === 'Autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('sexe')
                                <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Photo de profil -->
                        <div>
                            <label for="profile" class="block text-sm font-semibold text-foreground mb-2">
                                Photo de profil <span class="text-red-500">*</span>
                            </label>

                            <div class="flex items-center gap-4">
                                <label for="profile" class="cursor-pointer flex-1">
                                    <div
                                        class="border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl p-6 text-center hover:border-[#ff0000] dark:hover:border-[#f95454] transition-colors">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-semibold text-[#ff0000]  dark:text-[#f95454]">Cliquez pour
                                                uploader</span> ou glissez-déposez
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500">PNG, JPG, GIF, SVG, WEBP (max.
                                            2MB)</p>
                                    </div>
                                    <input type="file" id="profile" name="profile" accept="image/*" class="hidden"
                                        onchange="previewImage(event)">
                                </label>
                            </div>
                             <div id="preview" class="mt-4  pb-7 hidden">
                                <img id="preview-image"
                                    class="h-32  w-auto object-contain rounded-xl border-2 border-gray-200 dark:border-gray-700">
                            </div>
                            @error('profile')
                                <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>
                </div>

                <!-- SECTION : Informations Civiles -->
                <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-border bg-muted/30">
                        <h2 class="text-lg font-bold text-foreground flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                            Informations Civiles
                        </h2>
                    </div>
                    <div class="p-6 space-y-6">

                        <!-- Date de naissance -->
                        <div>
                           
                            <label for="date_naissance" class="block text-sm font-semibold text-foreground mb-2">
                                Date de naissance
                            </label>
                            <input type="date" id="date_naissance" name="date_naissance"
                                value="{{ old('date_naissance') }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('date_naissance') border-destructive ring-2 ring-destructive/50 @enderror">
                            @error('date_naissance')
                                <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Lieu de naissance -->
                        <div>
                            <label for="lieu_naissance" class="block text-sm font-semibold text-foreground mb-2">
                                Lieu de naissance
                            </label>
                            <input type="text" id="lieu_naissance" name="lieu_naissance"
                                value="{{ old('lieu_naissance') }}" placeholder="Ex: Douala, Cameroun"
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('lieu_naissance') border-destructive ring-2 ring-destructive/50 @enderror">
                            @error('lieu_naissance')
                                <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Nationalité -->
                        <div>
                            <label for="nationalite" class="block text-sm font-semibold text-foreground mb-2">
                                Nationalité
                            </label>
                            <input type="text" id="nationalite" name="nationalite"
                                value="{{ old('nationalite', 'Camerounaise') }}" placeholder="Ex: Camerounaise"
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('nationalite') border-destructive ring-2 ring-destructive/50 @enderror">
                            @error('nationalite')
                                <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            <div class="space-y-8 ">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- SECTION : Sécurité -->
                    <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-border bg-muted/30">
                            <h2 class="text-lg font-bold text-foreground flex items-center gap-2">
                                <svg class="w-5 h-5 text-accent" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Sécurité
                            </h2>
                        </div>
                        <div class="p-6 space-y-6">

                            <!-- Mot de passe -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-foreground mb-2">
                                    Mot de passe
                                    <span class="text-destructive font-bold">*</span>
                                </label>
                                <input type="password" id="password" name="password" placeholder="••••••••"
                                    class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('password') border-destructive ring-2 ring-destructive/50 @enderror">
                                @error('password')
                                    <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="mt-2 text-xs text-muted-foreground flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Minimum 8 caractères
                                </p>
                            </div>

                            <!-- Confirmation mot de passe -->
                            <div>
                                <label for="password_confirmation"
                                    class="block text-sm font-semibold text-foreground mb-2">
                                    Confirmer le mot de passe
                                    <span class="text-destructive font-bold">*</span>
                                </label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    placeholder="••••••••"
                                    class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all">
                                <p class="mt-2 text-xs text-muted-foreground">
                                    Doit être identique au mot de passe ci-dessus
                                </p>
                            </div>

                        </div>
                    </div>

                    <!-- SECTION : Informations Académiques -->
                    <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-border bg-muted/30">
                            <h2 class="text-lg font-bold text-foreground flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                                Informations Académiques
                            </h2>
                        </div>
                        <div class="p-6 space-y-6">

                            <!-- Niveau -->
                            <div>
                                <label for="niveau" class="block text-sm font-semibold text-foreground mb-2">
                                    Niveau
                                    <span class="text-destructive font-bold">*</span>
                                </label>
                                <select id="niveau" name="niveau"
                                    class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('niveau') border-destructive ring-2 ring-destructive/50 @enderror">
                                    <option value="">-- Sélectionner --</option>
                                    <option value="3eme" {{ old('niveau') === '3eme' ? 'selected' : '' }}>3ème</option>
                                    <option value="bepc" {{ old('niveau') === 'bepc' ? 'selected' : '' }}>BEPC</option>
                                    <option value="premiere" {{ old('niveau') === 'premiere' ? 'selected' : '' }}>Première
                                    </option>
                                    <option value="probatoire" {{ old('niveau') === 'probatoire' ? 'selected' : '' }}>
                                        Probatoire</option>
                                    <option value="terminale" {{ old('niveau') === 'terminale' ? 'selected' : '' }}>
                                        Terminale</option>
                                    <option value="bacc" {{ old('niveau') === 'bacc' ? 'selected' : '' }}>Baccalauréat
                                    </option>
                                    <option value="licence" {{ old('niveau') === 'licence' ? 'selected' : '' }}>Licence
                                    </option>
                                    <option value="cep" {{ old('niveau') === 'cep' ? 'selected' : '' }}>CEP</option>

                                </select>
                                @error('niveau')
                                    <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Spécialité -->
                            <div>
                                <label for="specialite_id" class="block text-sm font-semibold text-foreground mb-2">
                                    Spécialité <span class="text-destructive font-bold">*</span>
                                </label>
                                <select id="specialite_id" name="specialite_id"
                                    class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('specialite_id') border-destructive ring-2 ring-destructive/50 @enderror">
                                    <option value="">-- Sélectionner --</option>
                                    @foreach ($specialites as $specialite)
                                        <option value="{{ $specialite->id }}"
                                            {{ old('specialite_id') == $specialite->id ? 'selected' : '' }}>
                                            {{ $specialite->intitule }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('specialite_id')
                                    <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Année Académique -->
                            <div>
                                <label for="annee_academique_id" class="block text-sm font-semibold text-foreground mb-2">
                                    Année Académique <span class="text-destructive font-bold">*</span>
                                </label>
                                <select id="annee_academique_id" name="annee_academique_id"
                                    class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('annee_academique_id') border-destructive ring-2 ring-destructive/50 @enderror">
                                    <option value="">-- Sélectionner --</option>
                                    @foreach ($anneesAcademiques as $annee)
                                        <option value="{{ $annee->id }}"
                                            {{ old('annee_academique_id') == $annee->id ? 'selected' : '' }}>
                                            {{ $annee->libelle }}
                                            @if ($annee->is_active)
                                                <span class="text-primary font-semibold">(Active)</span>
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('annee_academique_id')
                                    <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>


                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- SECTION : Contact -->
                    <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-border bg-muted/30">
                            <h2 class="text-lg font-bold text-foreground flex items-center gap-2">
                                <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                Contact
                            </h2>
                        </div>
                        <div class="p-6 space-y-6">

                            <!-- Téléphone -->
                            <div>
                                <label for="telephone" class="block text-sm font-semibold text-foreground mb-2">
                                    Téléphone
                                </label>
                                <input type="tel" id="telephone" name="telephone" value="{{ old('telephone') }}"
                                    placeholder="Ex: +237 6XX XXX XXX"
                                    class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('telephone') border-destructive ring-2 ring-destructive/50 @enderror">
                                @error('telephone')
                                    <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Téléphone d'urgence -->
                            <div>
                                <label for="telephone_urgence" class="block text-sm font-semibold text-foreground mb-2">
                                    Téléphone d'urgence
                                </label>
                                <input type="tel" id="telephone_urgence" name="telephone_urgence"
                                    value="{{ old('telephone_urgence') }}" placeholder="Ex: +237 6XX XXX XXX"
                                    class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('telephone_urgence') border-destructive ring-2 ring-destructive/50 @enderror">
                                <p class="mt-2 text-xs text-muted-foreground">
                                    Contact d'une personne à prévenir en cas d'urgence
                                </p>
                                @error('telephone_urgence')
                                    <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Adresse -->
                            <div>
                                <label for="adresse" class="block text-sm font-semibold text-foreground mb-2">
                                    Adresse
                                </label>
                                <textarea id="adresse" name="adresse" rows="3" placeholder="Ex: Quartier, Ville, Pays..."
                                    class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('adresse') border-destructive ring-2 ring-destructive/50 @enderror">{{ old('adresse') }}</textarea>
                                @error('adresse')
                                    <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <!-- SECTION : Documents et Statut -->
                    <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-border bg-muted/30">
                            <h2 class="text-lg font-bold text-foreground flex items-center gap-2">
                                <svg class="w-5 h-5 text-accent" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                        clip-rule="evenodd" />
                                </svg>
                                Documents et Statut
                            </h2>
                        </div>
                        <div class="p-6 space-y-6">

                            <!-- Matricule -->
                            <div>
                                <label for="matricule" class="block text-sm font-semibold text-foreground mb-2">
                                    Matricule
                                </label>
                                <input type="text" id="matricule" name="matricule" value="{{ old('matricule') }}"
                                    placeholder="Sera généré automatiquement"
                                    class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('matricule') border-destructive ring-2 ring-destructive/50 @enderror"
                                    readonly>
                                <p class="mt-2 text-xs text-muted-foreground">
                                    Le matricule sera généré automatiquement lors de la création
                                </p>
                                @error('matricule')
                                    <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Pièce d'identité -->
                            <div>
                                <label for="piece_identite" class="block text-sm font-semibold text-foreground mb-2">
                                    Pièce d'identité
                                </label>
                                <input type="text" id="piece_identite" name="piece_identite"
                                    value="{{ old('piece_identite') }}" placeholder="Ex: CNI N°1234567890123"
                                    class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('piece_identite') border-destructive ring-2 ring-destructive/50 @enderror">
                                <p class="mt-2 text-xs text-muted-foreground">
                                    Numéro de CNI ou Passeport
                                </p>
                                @error('piece_identite')
                                    <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Statut -->
                            <div>
                                <label for="statut" class="block text-sm font-semibold text-foreground mb-2">
                                    Statut
                                </label>
                                <select id="statut" name="statut"
                                    class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('statut') border-destructive ring-2 ring-destructive/50 @enderror">
                                    <option value="">-- Sélectionner --</option>
                                    <option value="actif" {{ old('statut') === 'actif' ? 'selected' : '' }}>Actif
                                    </option>
                                    <option value="inactif" {{ old('statut') === 'inactif' ? 'selected' : '' }}>Inactif
                                    </option>
                                    <option value="suspendu" {{ old('statut') === 'suspendu' ? 'selected' : '' }}>Suspendu
                                    </option>
                                    <option value="archive" {{ old('statut') === 'archive' ? 'selected' : '' }}>Archivé
                                    </option>
                                </select>
                                <p class="mt-2 text-xs text-muted-foreground">
                                    Actif = opérationnel | Inactif = temporaire | Suspendu = sanction | Archivé =
                                    diplômé/démission
                                </p>
                                @error('statut')
                                    <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>


            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row gap-4 justify-end pt-6 border-t border-border">
                <a href="{{ route('users.index') }}"
                    class="px-6 py-2.5 bg-muted hover:bg-muted/80 text-muted-foreground rounded-lg font-semibold transition-all duration-200 text-center">
                    Annuler
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-semibold transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Créer l'utilisateur
                </button>
            </div>

        </form>

        <!-- Aide supplémentaire -->
        <div class="mt-8 p-4 bg-muted/30 border border-border rounded-lg">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-muted-foreground flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd" />
                </svg>
                <div class="text-sm text-muted-foreground">
                    <p class="font-semibold text-foreground mb-2">💡 Conseils :</p>
                    <ul class="space-y-1 list-disc list-inside">
                        <li>L'email doit être unique et valide</li>
                        <li>Le mot de passe doit contenir au minimum 8 caractères</li>
                        <li>Tous les champs marqués d'un <span class="text-destructive font-bold">*</span> sont
                            obligatoires</li>
                        <li>L'année académique active sera sélectionnée par défaut</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
<script>
// Fonction globale pour la prévisualisation d'image
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewImage = document.getElementById('preview-image');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialisation si nécessaire
    console.log('Formulaire de création chargé');
});
</script>
@endsection

@push('styles')
    <style>
        .card {
            display: block;
        }

        select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            padding-right: 2.5rem;
            appearance: none;
        }

        @media (prefers-color-scheme: dark) {
            select {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23adb5bd' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            }
        }
    </style>
@endpush
