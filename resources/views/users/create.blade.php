@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Créer un Utilisateur</h1>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <h3 class="text-red-800 font-semibold mb-2">Erreurs de validation</h3>
                <ul class="list-disc list-inside text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
            @csrf

            <!-- Nom -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nom <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                    required
                >
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                    required
                >
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mot de passe -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Mot de passe <span class="text-red-500">*</span>
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                    required
                >
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmation mot de passe -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirmer le mot de passe <span class="text-red-500">*</span>
                </label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                >
            </div>

            <!-- Matricule -->
            <div class="mb-6">
                <label for="matricule" class="block text-sm font-medium text-gray-700 mb-2">
                    Matricule
                </label>
                <input 
                    type="text" 
                    id="matricule" 
                    name="matricule" 
                    value="{{ old('matricule') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('matricule') border-red-500 @enderror"
                >
                @error('matricule')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sexe -->
            <div class="mb-6">
                <label for="sexe" class="block text-sm font-medium text-gray-700 mb-2">
                    Sexe <span class="text-red-500">*</span>
                </label>
                <select 
                    id="sexe" 
                    name="sexe" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sexe') border-red-500 @enderror"
                    required
                >
                    <option value="">-- Sélectionner --</option>
                    <option value="M" {{ old('sexe') === 'M' ? 'selected' : '' }}>Masculin</option>
                    <option value="F" {{ old('sexe') === 'F' ? 'selected' : '' }}>Féminin</option>
                    <option value="Autre" {{ old('sexe') === 'Autre' ? 'selected' : '' }}>Autre</option>
                </select>
                @error('sexe')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Profil -->
            <div class="mb-6">
                <label for="profile" class="block text-sm font-medium text-gray-700 mb-2">
                    Profil
                </label>
                <input 
                    type="text" 
                    id="profile" 
                    name="profile" 
                    value="{{ old('profile') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('profile') border-red-500 @enderror"
                >
                @error('profile')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Niveau -->
            <div class="mb-6">
                <label for="niveau" class="block text-sm font-medium text-gray-700 mb-2">
                    Niveau <span class="text-red-500">*</span>
                </label>
                <select 
                    id="niveau" 
                    name="niveau" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('niveau') border-red-500 @enderror"
                    required
                >
                    <option value="">-- Sélectionner --</option>
                    <option value="3eme" {{ old('niveau') === '3eme' ? 'selected' : '' }}>3ème</option>
                    <option value="bepc" {{ old('niveau') === 'bepc' ? 'selected' : '' }}>BEPC</option>
                    <option value="premiere" {{ old('niveau') === 'premiere' ? 'selected' : '' }}>Première</option>
                    <option value="probatoire" {{ old('niveau') === 'probatoire' ? 'selected' : '' }}>Probatoire</option>
                    <option value="terminale" {{ old('niveau') === 'terminale' ? 'selected' : '' }}>Terminale</option>
                </select>
                @error('niveau')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Spécialité -->
            <div class="mb-6">
                <label for="specialite_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Spécialité
                </label>
                <select 
                    id="specialite_id" 
                    name="specialite_id" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('specialite_id') border-red-500 @enderror"
                >
                    <option value="">-- Sélectionner --</option>
                    @foreach ($specialites as $specialite)
                        <option value="{{ $specialite->id }}" {{ old('specialite_id') == $specialite->id ? 'selected' : '' }}>
                            {{ $specialite->nom }}
                        </option>
                    @endforeach
                </select>
                @error('specialite_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Année Académique -->
            <div class="mb-6">
                <label for="annee_academique_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Année Académique
                </label>
                <select 
                    id="annee_academique_id" 
                    name="annee_academique_id" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('annee_academique_id') border-red-500 @enderror"
                >
                    <option value="">-- Sélectionner --</option>
                    @foreach ($anneesAcademiques as $annee)
                        <option value="{{ $annee->id }}" {{ old('annee_academique_id') == $annee->id ? 'selected' : '' }}>
                            {{ $annee->nom }}
                        </option>
                    @endforeach
                </select>
                @error('annee_academique_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Boutons -->
            <div class="flex gap-4">
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                >
                    Créer l'utilisateur
                </button>
                <a 
                    href="{{ route('users.index') }}" 
                    class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition"
                >
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
