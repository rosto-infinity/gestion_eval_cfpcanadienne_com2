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
                            <!-- Avatar -->
                            <div class="w-16 h-16 rounded-full flex items-center justify-center text-2xl  font-bold" style="background-color: var(--primary); color: var(--primary-foreground)">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
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

                            @if(auth()->user()->specialite)
                                <div class="flex justify-between items-center py-2" style="border-bottom: 1px solid var(--border)">
                                    <span class="text-sm font-medium" style="color: var(--muted-foreground)">Spécialité :</span>
                                    <span class="text-sm font-semibold" style="color: var(--foreground)">{{ auth()->user()->specialite->nom }}</span>
                                </div>
                            @endif

                            @if(auth()->user()->anneeAcademique)
                                <div class="flex justify-between items-center py-2" style="border-bottom: 1px solid var(--border)">
                                    <span class="text-sm font-medium" style="color: var(--muted-foreground)">Année Académique :</span>
                                    <span class="text-sm font-semibold" style="color: var(--foreground)">{{ auth()->user()->anneeAcademique->nom }}</span>
                                </div>
                            @endif

                            @if(auth()->user()->niveau)
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-sm font-medium" style="color: var(--muted-foreground)">Niveau :</span>
                                    <span class="text-sm font-semibold" style="color: var(--foreground)">{{ auth()->user()->niveau }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Bouton Modifier -->
                        <div class="mt-6 pt-6" style="border-top: 1px solid var(--border)">
                            <a href="{{ route('profile.edit') }}" class="w-full inline-flex justify-center items-center px-4 py-2 rounded-lg transition font-medium" style="background-color: var(--primary); color: var(--primary-foreground)" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Modifier les Détails
                            </a>
                        </div>
                        
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
@endsection
