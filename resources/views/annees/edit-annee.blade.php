@extends('layouts.app')

@section('title', "Modifier l'Année Académique")

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Modifier l'Année Académique</h1>
        <p class="mt-2 text-sm text-gray-700">
            Vous pouvez ici modifier les informations de l'année académique sélectionnée.
        </p>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <form action="{{ route('annees.update', $annee) }}" class="p-6 space-y-6">
            @csrf
            @method('PATCH')

            <!-- Libellé -->
            <div>
                <label for="libelle" class="block text-sm font-medium text-gray-700 mb-2">
                    Libellé <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="libelle"
                    id="libelle"
                    value="{{ old('libelle', $annee->libelle) }}"
                    required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('libelle') border-red-500 @enderror"
                    placeholder="Ex: 2025-2026"
                >

                @error('libelle')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <p class="mt-1 text-xs text-gray-500">Format recommandé : YYYY-YYYY (ex : 2025-2026)</p>
            </div>

            <!-- Dates -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Date début -->
                <div>
                    <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-2">
                        Date de début <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="date"
                        name="date_debut"
                        id="date_debut"
                        value="{{ old('date_debut', $annee->date_debut->format('Y-m-d')) }}"
                        required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('date_debut') border-red-500 @enderror"
                    >

                    @error('date_debut')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date fin -->
                <div>
                    <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-2">
                        Date de fin <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="date"
                        name="date_fin"
                        id="date_fin"
                        value="{{ old('date_fin', $annee->date_fin->format('Y-m-d')) }}"
                        required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('date_fin') border-red-500 @enderror"
                    >

                    @error('date_fin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Statut actif -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-lg p-4">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input 
                            type="checkbox"
                            name="is_active"
                            id="is_active"
                            value="1"
                            {{ old('is_active', $annee->is_active) ? 'checked' : '' }}
                            class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                        >
                    </div>
                    <div class="ml-3">
                        <label for="is_active" class="font-medium text-gray-900">
                            Définir comme année active
                        </label>
                        <p class="text-sm text-gray-600 mt-1">
                            Si cochée, cette année deviendra l'année active.  
                            Toute autre année active sera automatiquement désactivée.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Informations -->
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8..." clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">À propos de l'année active</h3>
                        <ul class="mt-2 text-sm text-blue-700 list-disc list-inside space-y-1">
                            <li>Une seule année peut être active à la fois</li>
                            <li>Utilisée par défaut dans les formulaires</li>
                            <li>Les nouveaux étudiants y sont automatiquement rattachés</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Boutons -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('annees.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    Annuler
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Mettre à jour l'Année Académique
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateDebut = document.getElementById('date_debut');
    const dateFin = document.getElementById('date_fin');

    dateDebut.addEventListener('change', () => {
        dateFin.min = dateDebut.value;
    });

    dateFin.addEventListener('change', () => {
        if (dateFin.value && dateDebut.value && dateFin.value <= dateDebut.value) {
            alert('La date de fin doit être postérieure à la date de début');
            dateFin.value = '';
        }
    });
});
</script>
@endpush

@endsection
