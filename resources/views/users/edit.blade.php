@extends('layouts.app')

@section('title', 'Modifier l\'Utilisateur')

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
                    <h1 class="text-3xl font-bold text-foreground">✏️ Modifier l'Utilisateur</h1>
                    <p class="mt-1 text-sm text-muted-foreground">
                        Mettez à jour les informations de <span
                            class="font-semibold text-foreground">{{ $user->name }}</span>
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
        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

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
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                placeholder="Ex: Jean Dupont" required
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
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                placeholder="exemple@email.com" required
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

                        <!-- Matricule -->
                        <div>
                            <label for="matricule" class="block text-sm font-semibold text-foreground mb-2">
                                Matricule
                            </label>
                            <input 
                                type="text" 
                                id="matricule" 
                                name="matricule"
                                value="{{ old('matricule', $user->matricule) }}" 
                                placeholder="Ex: CFPC-26WLF001"
                                class="flex-1 px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('matricule') border-destructive ring-2 ring-destructive/50 @enderror"
                            >
                            <p class="mt-2 text-xs text-muted-foreground">
                                @if($user->matricule)
                                    Matricule existant. Pour le modifier, supprimez-le d'abord.
                                @else
                                    Le matricule sera généré automatiquement lors de la sauvegarde
                                @endif
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

                        <!-- Sexe -->
                        <div>
                            <label for="sexe" class="block text-sm font-semibold text-foreground mb-2">
                                Sexe
                                <span class="text-destructive font-bold">*</span>
                            </label>
                            <select id="sexe" name="sexe" required
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('sexe') border-destructive ring-2 ring-destructive/50 @enderror">
                                <option value="">-- Sélectionner --</option>
                                <option value="M" {{ old('sexe', $user->sexe) === 'M' ? 'selected' : '' }}>Masculin
                                </option>
                                <option value="F" {{ old('sexe', $user->sexe) === 'F' ? 'selected' : '' }}>Féminin
                                </option>
                                <option value="Autre" {{ old('sexe', $user->sexe) === 'Autre' ? 'selected' : '' }}>Autre
                                </option>
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
                                Photo de profil
                            </label>
                            <input 
                                type="file" 
                                id="profile" 
                                name="profile" 
                                accept="image/*"
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('profile') border-destructive ring-2 ring-destructive/50 @enderror"
                            >
                            @if($user->profile)
                                <p class="mt-2 text-xs text-muted-foreground">
                                    Photo actuelle : <a href="{{ Storage::url($user->profile) }}" target="_blank" class="text-primary hover:underline">Voir</a>
                                </p>
                            @endif
                            <p class="mt-2 text-xs text-muted-foreground">
                                Formats acceptés: JPG, PNG, GIF (max 2MB)
                            </p>
                            @error('profile')
                                <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
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
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
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
                            <input 
                                type="date" 
                                id="date_naissance" 
                                name="date_naissance" 
                                value="{{ old('date_naissance', $user->date_naissance) }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('date_naissance') border-destructive ring-2 ring-destructive/50 @enderror"
                            >
                            @error('date_naissance')
                                <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
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
                            <input 
                                type="text" 
                                id="lieu_naissance" 
                                name="lieu_naissance" 
                                value="{{ old('lieu_naissance', $user->lieu_naissance) }}"
                                placeholder="Ex: Douala, Cameroun"
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('lieu_naissance') border-destructive ring-2 ring-destructive/50 @enderror"
                            >
                            @error('lieu_naissance')
                                <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
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
                            <input 
                                type="text" 
                                id="nationalite" 
                                name="nationalite" 
                                value="{{ old('nationalite', $user->nationalite ?? 'Camerounaise') }}"
                                placeholder="Ex: Camerounaise"
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('nationalite') border-destructive ring-2 ring-destructive/50 @enderror"
                            >
                            @error('nationalite')
                                <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>
                </div>

                <!-- SECTION : Contact -->
                <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-border bg-muted/30">
                        <h2 class="text-lg font-bold text-foreground flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
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
                            <input 
                                type="tel" 
                                id="telephone" 
                                name="telephone" 
                                value="{{ old('telephone', $user->telephone) }}"
                                placeholder="Ex: +237 6XX XXX XXX"
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('telephone') border-destructive ring-2 ring-destructive/50 @enderror"
                            >
                            @error('telephone')
                                <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
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
                            <input 
                                type="tel" 
                                id="telephone_urgence" 
                                name="telephone_urgence" 
                                value="{{ old('telephone_urgence', $user->telephone_urgence) }}"
                                placeholder="Ex: +237 6XX XXX XXX"
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('telephone_urgence') border-destructive ring-2 ring-destructive/50 @enderror"
                            >
                            <p class="mt-2 text-xs text-muted-foreground">
                                Contact d'une personne à prévenir en cas d'urgence
                            </p>
                            @error('telephone_urgence')
                                <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
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
                            <textarea 
                                id="adresse" 
                                name="adresse" 
                                rows="3"
                                placeholder="Ex: Quartier, Ville, Pays..."
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('adresse') border-destructive ring-2 ring-destructive/50 @enderror"
                            >{{ old('adresse', $user->adresse) }}</textarea>
                            @error('adresse')
                                <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
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
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                            </svg>
                            Documents et Statut
                        </h2>
                    </div>
                    <div class="p-6 space-y-6">

                        <!-- Pièce d'identité -->
                        <div>
                            <label for="piece_identite" class="block text-sm font-semibold text-foreground mb-2">
                                Pièce d'identité
                            </label>
                            <input 
                                type="text" 
                                id="piece_identite" 
                                name="piece_identite" 
                                value="{{ old('piece_identite', $user->piece_identite) }}"
                                placeholder="Ex: CNI N°1234567890123"
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('piece_identite') border-destructive ring-2 ring-destructive/50 @enderror"
                            >
                            <p class="mt-2 text-xs text-muted-foreground">
                                Numéro de CNI ou Passeport
                            </p>
                            @error('piece_identite')
                                <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
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
                            <select 
                                id="statut" 
                                name="statut" 
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('statut') border-destructive ring-2 ring-destructive/50 @enderror"
                            >
                                <option value="">-- Sélectionner --</option>
                                <option value="actif" {{ old('statut', $user->statut) === 'actif' ? 'selected' : '' }}>Actif</option>
                                <option value="inactif" {{ old('statut', $user->statut) === 'inactif' ? 'selected' : '' }}>Inactif</option>
                                <option value="suspendu" {{ old('statut', $user->statut) === 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                                <option value="archive" {{ old('statut', $user->statut) === 'archive' ? 'selected' : '' }}>Archivé</option>
                            </select>
                            <p class="mt-2 text-xs text-muted-foreground">
                                Actif = opérationnel | Inactif = temporaire | Suspendu = sanction | Archivé = diplômé/démission
                            </p>
                            @error('statut')
                                <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>
                </div>

                <!-- COLONNE DROITE : Sécurité et Académique -->
                <div class="space-y-8">

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
                                    Laisser vide pour ne pas modifier
                                </p>
                            </div>

                            <!-- Confirmation mot de passe -->
                            <div>
                                <label for="password_confirmation"
                                    class="block text-sm font-semibold text-foreground mb-2">
                                    Confirmer le mot de passe
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
                            <select 
                                id="niveau" 
                                name="niveau" 
                                required
                                class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('niveau') border-destructive ring-2 ring-destructive/50 @enderror"
                            >
                                <option value="">-- Sélectionner --</option>
                                
                                {{-- On boucle sur l'Enum Niveau --}}
                                @foreach ($niveaux as $niveau)
                                    <option 
                                        value="{{ $niveau->value }}" 
                                        {{-- On compare la valeur de l'enum (string) avec l'ancienne valeur --}}
                                        {{-- On gère si $user->niveau est un objet (casté) ou une string --}}
                                        {{ old('niveau', $user->niveau?->value ?? $user->niveau) === $niveau->value ? 'selected' : '' }}
                                    >
                                        {{ $niveau->label() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('niveau')
                                <p class="mt-2 text-sm text-destructive font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                            <!-- Spécialité -->
                            <div>
                                <label for="specialite_id" class="block text-sm font-semibold text-foreground mb-2">
                                    Spécialité
                                </label>
                                <select id="specialite_id" name="specialite_id"
                                    class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('specialite_id') border-destructive ring-2 ring-destructive/50 @enderror">
                                    <option value="">-- Sélectionner --</option>
                                    @foreach ($specialites as $specialite)
                                        <option value="{{ $specialite->id }}"
                                            {{ old('specialite_id', $user->specialite_id) == $specialite->id ? 'selected' : '' }}>
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
                                    Année Académique
                                </label>
                                <select id="annee_academique_id" name="annee_academique_id"
                                    class="w-full px-4 py-2.5 rounded-lg border border-border bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 transition-all @error('annee_academique_id') border-destructive ring-2 ring-destructive/50 @enderror">
                                    <option value="">-- Sélectionner --</option>
                                    @foreach ($anneesAcademiques as $annee)
                                        <option value="{{ $annee->id }}"
                                            {{ old('annee_academique_id', $user->annee_academique_id) == $annee->id ? 'selected' : '' }}>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier l'utilisateur
                </button>
            </div>

        </form>

        <!-- Informations utilisateur actuel -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">

            <!-- Date de création -->
            <div class="p-4 bg-muted/30 border border-border rounded-lg">
                <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Créé le</p>
                <p class="text-sm font-semibold text-foreground">
                    {{ $user->created_at->format('d/m/Y à H:i') }}
                </p>
            </div>

            <!-- Dernière modification -->
            <div class="p-4 bg-muted/30 border border-border rounded-lg">
                <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Dernière modification
                </p>
                <p class="text-sm font-semibold text-foreground">
                    {{ $user->updated_at->format('d/m/Y à H:i') }}
                </p>
            </div>

            <!-- Statut -->
            <div class="p-4 bg-muted/30 border border-border rounded-lg">
                <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">Statut</p>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-primary"></span>
                    <p class="text-sm font-semibold text-foreground">Actif</p>
                </div>
            </div>

        </div>
        @if (auth()->user()->role->isAtLeast(\App\Enums\Role::SUPERADMIN))
            <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-sm">
                <h2 class="text-xl font-bold mb-6">Modifier l'utilisateur : {{ $user->name }}</h2>

                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <!-- Nom -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                    </div>

                    <!-- Rôle (La partie critique) -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Rôle attribué</label>
                        <select name="role"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            @foreach ($roles as $role)
                                <option value="{{ $role->value }}"
                                    {{ old('role', $user->role->value) === $role->value ? 'selected' : '' }}>
                                    {{ $role->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-2 text-sm text-red-600 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-between items-center border-t pt-4">
                        <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:underline">Annuler</a>
                        <button type="submit"
                            class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>


            <!-- Zone de danger -->
            <div class="mt-8 p-6 bg-destructive/5 border border-destructive/20 rounded-lg">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-destructive" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-destructive mb-2">⚠️ Zone de danger</h3>
                        <p class="text-sm text-muted-foreground mb-4">
                            Les actions suivantes sont irréversibles. Veuillez être prudent.
                        </p>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.');"
                            class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 bg-destructive hover:bg-destructive/90 text-destructive-foreground rounded-lg font-semibold transition-all duration-200 text-sm">
                                Supprimer cet utilisateur
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection


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



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Vérifier si l'utilisateur a un nom pour générer le matricule
    function checkUserEligibility() {
        const userName = document.getElementById('name').value;
        const generateBtn = document.getElementById('generateMatriculeBtn');
        
        const isEligible = userName && userName.trim().length > 0;
        
        if (generateBtn) {
            generateBtn.disabled = !isEligible;
            if (!isEligible) {
                generateBtn.title = 'Veuillez entrer le nom de l\'utilisateur';
            } else {
                generateBtn.title = 'Générer le matricule';
            }
        }
    }
    
    // Écouter les changements sur le champ nom
    const nameInput = document.getElementById('name');
    
    if (nameInput) {
        nameInput.addEventListener('input', checkUserEligibility);
        nameInput.addEventListener('change', checkUserEligibility);
    }
    
    // Vérification initiale
    checkUserEligibility();
});

function generateMatricule() {
    const userName = document.getElementById('name').value;
    const matriculeField = document.getElementById('matricule');
    const generateBtn = document.getElementById('generateMatriculeBtn');
    
    if (!userName || userName.trim().length === 0) {
        alert('Veuillez entrer le nom de l\'utilisateur avant de générer le matricule.');
        return;
    }
    
    // Désactiver le bouton pendant la génération
    generateBtn.disabled = true;
    generateBtn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Génération...';
    
    // Appeler l'API pour générer le matricule
    fetch(`/api/generate-matricule?user_name=${encodeURIComponent(userName)}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                matriculeField.value = data.matricule;
                matriculeField.classList.remove('bg-muted', 'text-muted-foreground');
                matriculeField.classList.add('bg-background', 'text-foreground');
                matriculeField.disabled = false;
                matriculeField.readOnly = false;
                
                // Mettre à jour le bouton
                generateBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Généré';
                generateBtn.classList.add('bg-green-600', 'hover:bg-green-700');
                generateBtn.classList.remove('bg-primary', 'hover:bg-primary/90');
                generateBtn.disabled = true;
                
                // Mettre à jour le message d'aide
                const helpText = document.querySelector('.text-xs.text-muted-foreground');
                if (helpText) {
                    helpText.textContent = 'Matricule généré avec succès. Vous pouvez le modifier si nécessaire.';
                }
            } else {
                alert('Erreur lors de la génération du matricule: ' + (data.error || 'Erreur inconnue'));
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de la génération du matricule. Veuillez réessayer.');
        })
        .finally(() => {
            if (!matriculeField.value) {
                // Réactiver le bouton seulement si le matricule n'a pas été généré
                generateBtn.disabled = false;
                generateBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Générer';
            }
        });
}
</script>
