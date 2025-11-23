@extends('layouts.app')

@section('title', 'Créer une Spécialité')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-foreground">Créer une Spécialité</h1>
        <p class="mt-1 text-sm text-muted-foreground">Ajouter une nouvelle spécialité académique</p>
    </div>

    <!-- Form Card -->
    <div class="bg-card rounded-[var(--radius)] shadow-sm border border-border">
        <form action="{{ route('specialites.store') }}" method="POST" class="p-6 space-y-5">
            @csrf

            <!-- Code -->
            <div>
                <label for="code" class="block text-sm font-medium text-foreground mb-1">
                    Code <span class="text-destructive">*</span>
                </label>
                <input type="text" 
                    name="code" 
                    id="code" 
                    value="{{ old('code') }}" 
                    required
                    class="w-full px-3 py-2 border border-input rounded-[calc(var(--radius)-2px)] text-foreground placeholder-muted-foreground bg-background focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent transition-colors @error('code') border-destructive @enderror"
                    placeholder="Ex: INFO, GC, ELEC">
                @error('code')
                    <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <!-- Intitulé -->
            <div>
                <label for="intitule" class="block text-sm font-medium text-foreground mb-1">
                    Intitulé <span class="text-destructive">*</span>
                </label>
                <input type="text" 
                    name="intitule" 
                    id="intitule" 
                    value="{{ old('intitule') }}" 
                    required
                    class="w-full px-3 py-2 border border-input rounded-[calc(var(--radius)-2px)] text-foreground placeholder-muted-foreground bg-background focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent transition-colors @error('intitule') border-destructive @enderror"
                    placeholder="Ex: Informatique et Réseaux">
                @error('intitule')
                    <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-foreground mb-1">
                    Description
                </label>
                <textarea name="description" 
                    id="description" 
                    rows="4"
                    class="w-full px-3 py-2 border border-input rounded-[calc(var(--radius)-2px)] text-foreground placeholder-muted-foreground bg-background focus:outline-none focus:ring-2 focus:ring-ring focus:border-transparent transition-colors resize-none @error('description') border-destructive @enderror"
                    placeholder="Description de la spécialité...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-border">
                <a href="{{ route('specialites.index') }}" 
                    class="px-4 py-2 text-sm font-medium text-secondary-foreground bg-secondary hover:bg-accent rounded-[calc(var(--radius)-2px)] transition-colors">
                    Annuler
                </a>
                <button type="submit" 
                    class="px-4 py-2 text-sm font-medium text-primary-foreground bg-primary hover:bg-primary/90 rounded-[calc(var(--radius)-2px)] transition-colors">
                    Créer la Spécialité
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
