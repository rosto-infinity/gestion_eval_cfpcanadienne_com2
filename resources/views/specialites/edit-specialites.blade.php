@extends('layouts.app')

@section('title', 'Modifier une Spécialité')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Modifier la Spécialité</h1>
        <p class="mt-2 text-sm text-gray-700">{{ $specialite->code }} - {{ $specialite->intitule }}</p>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <form action="{{ route('specialites.update', $specialite) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Code -->
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                    Code <span class="text-red-500">*</span>
                </label>
                <input type="text" name="code" id="code" value="{{ old('code', $specialite->code) }}" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('code') border-red-500 @enderror">
                @error('code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Intitulé -->
            <div>
                <label for="intitule" class="block text-sm font-medium text-gray-700 mb-2">
                    Intitulé <span class="text-red-500">*</span>
                </label>
                <input type="text" name="intitule" id="intitule" value="{{ old('intitule', $specialite->intitule) }}" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('intitule') border-red-500 @enderror">
                @error('intitule')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea name="description" id="description" rows="4"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $specialite->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Boutons -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('specialites.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    Annuler
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection