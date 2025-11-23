@extends('layouts.app')

@section('title', 'Modifier un Module')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- En-tête -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-foreground">Modifier un Module</h1>
        <p class="mt-1 text-xs text-muted-foreground">Mettre à jour les informations</p>
    </div>

    <!-- Formulaire -->
    <div class="bg-card border border-border rounded-lg p-6">
        <form action="{{ route('modules.update', $module) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Grille 2 colonnes -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                
                <!-- Code -->
                <div>
                    <label for="code" class="block text-sm font-semibold text-foreground mb-2">
                        Code <span class="text-destructive">*</span>
                    </label>
                    <input type="text" name="code" id="code"
                        value="{{ old('code', $module->code) }}" required
                        class="w-full px-3 py-2 text-sm border border-border rounded-md bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors @error('code') border-destructive focus:ring-destructive/50 @enderror"
                        placeholder="M1, M2, ...">
                    @error('code')
                        <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-muted-foreground">
                        M1-M5 (S1) ou M6-M10 (S2)
                    </p>
                </div>

                <!-- Ordre -->
                <div>
                    <label for="ordre" class="block text-sm font-semibold text-foreground mb-2">
                        Ordre <span class="text-destructive">*</span>
                    </label>
                    <input type="number" name="ordre" id="ordre"
                        value="{{ old('ordre', $module->ordre) }}" required min="1" max="100"
                        class="w-full px-3 py-2 text-sm border border-border rounded-md bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors @error('ordre') border-destructive focus:ring-destructive/50 @enderror">
                    @error('ordre')
                        <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Intitulé -->
            <div>
                <label for="intitule" class="block text-sm font-semibold text-foreground mb-2">
                    Intitulé <span class="text-destructive">*</span>
                </label>
                <input type="text" name="intitule" id="intitule"
                    value="{{ old('intitule', $module->intitule) }}" required
                    class="w-full px-3 py-2 text-sm border border-border rounded-md bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors @error('intitule') border-destructive focus:ring-destructive/50 @enderror"
                    placeholder="Ex: Algorithmique et Structures de Données">
                @error('intitule')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <!-- Coefficient -->
            <div>
                <label for="coefficient" class="block text-sm font-semibold text-foreground mb-2">
                    Coefficient <span class="text-destructive">*</span>
                </label>
                <input type="number" name="coefficient" id="coefficient" 
                    value="{{ old('coefficient', $module->coefficient) }}" 
                    required min="0.1" max="10" step="0.01"
                    class="w-full px-3 py-2 text-sm border border-border rounded-md bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors @error('coefficient') border-destructive focus:ring-destructive/50 @enderror">
                @error('coefficient')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-border">
                <a href="{{ route('modules.index') }}" class="px-4 py-2 text-sm font-medium text-muted-foreground bg-muted hover:bg-muted/80 rounded-md transition-colors">
                    Annuler
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-primary-foreground bg-primary hover:bg-primary/90 rounded-md transition-colors">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
