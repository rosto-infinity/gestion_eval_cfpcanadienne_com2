@extends('layouts.app')

@section('title', 'Modifier un Module')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Modifier un Module</h1>
        <p class="mt-2 text-sm text-gray-700">Mettre à jour les informations du module</p>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <form action="{{ route('modules.update', $module) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Code -->
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                        Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="code" id="code"
                        value="{{ old('code', $module->code) }}" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('code') border-red-500 @enderror"
                        placeholder="Ex: M1, M2, ...">
                    @error('code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        Format: M1 à M5 (Semestre 1), M6 à M10 (Semestre 2)
                    </p>
                </div>

                <!-- Ordre -->
                <div>
                    <label for="ordre" class="block text-sm font-medium text-gray-700 mb-2">
                        Ordre d'affichage <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="ordre" id="ordre"
                        value="{{ old('ordre', $module->ordre) }}" required min="1" max="100"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('ordre') border-red-500 @enderror">
                    @error('ordre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Intitulé -->
            <div>
                <label for="intitule" class="block text-sm font-medium text-gray-700 mb-2">
                    Intitulé <span class="text-red-500">*</span>
                </label>
                <input type="text" name="intitule" id="intitule"
                    value="{{ old('intitule', $module->intitule) }}" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('intitule') border-red-500 @enderror"
                    placeholder="Ex: Algorithmique et Structures de Données">
                @error('intitule')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Coefficient -->
            <div>
                <label for="coefficient" class="block text-sm font-medium text-gray-700 mb-2">
                    Coefficient <span class="text-red-500">*</span>
                </label>
                <input type="number" name="coefficient" id="coefficient" 
                    value="{{ old('coefficient', $module->coefficient) }}" 
                    required min="0.1" max="10" step="0.01"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('coefficient') border-red-500 @enderror">
                @error('coefficient')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Boutons -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('modules.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    Annuler
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Mettre à jour le Module
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
