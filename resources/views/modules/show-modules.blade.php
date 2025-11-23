@extends('layouts.app')

@section('title', 'Détails du Module')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- En-tête -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-foreground">
            {{ $module->intitule }}
        </h1>
        <p class="mt-1 text-xs text-muted-foreground">
            Détails du module d'enseignement
        </p>
    </div>

    <!-- Card -->
    <div class="bg-card border border-border rounded-lg p-6 space-y-5">

        <!-- Grille 2 colonnes -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            
            <!-- Code -->
            <div>
                <h3 class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Code</h3>
                <p class="mt-2 text-lg font-semibold text-foreground">
                    {{ $module->code }}
                </p>
            </div>

            <!-- Ordre -->
            <div>
                <h3 class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Ordre</h3>
                <p class="mt-2 text-lg font-semibold text-foreground">
                    {{ $module->ordre }}
                </p>
            </div>

        </div>

        <!-- Intitulé -->
        <div class="pt-2">
            <h3 class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Intitulé</h3>
            <p class="mt-2 text-base font-medium text-foreground">
                {{ $module->intitule }}
            </p>
        </div>

        <!-- Coefficient -->
        <div class="pt-2">
            <h3 class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Coefficient</h3>
            <p class="mt-2 text-lg font-semibold text-foreground">
                {{ number_format($module->coefficient, 2) }}
            </p>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-border">
            
            <a href="{{ route('modules.index') }}"
               class="px-4 py-2 text-sm font-medium text-muted-foreground bg-muted hover:bg-muted/80 rounded-md transition-colors">
                Retour
            </a>

            <a href="{{ route('modules.edit', $module) }}"
               class="px-4 py-2 text-sm font-medium text-primary-foreground bg-primary hover:bg-primary/90 rounded-md transition-colors">
                Modifier
            </a>

            <form action="{{ route('modules.destroy', $module) }}" method="POST" class="inline"
                  onsubmit="return confirm('Voulez-vous vraiment supprimer ce module ?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-destructive-foreground bg-destructive hover:bg-destructive/90 rounded-md transition-colors">
                    Supprimer
                </button>
            </form>

        </div>

    </div>

</div>
@endsection
