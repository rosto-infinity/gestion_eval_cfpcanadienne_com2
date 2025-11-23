@extends('layouts.app')

@section('title', 'Modules')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- En-tête -->
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-foreground">Modules d'Enseignement</h1>
            <p class="mt-1 text-xs text-muted-foreground">Gestion des modules M1 à M10</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('modules.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-primary-foreground rounded-md text-xs font-semibold hover:bg-primary/90 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouveau
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Total -->
        <div class="bg-card border border-border rounded-lg p-4">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-lg bg-primary/10">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-muted-foreground">Total Modules</p>
                    <p class="text-xl font-bold text-foreground">{{ $modules->count() }}</p>
                </div>
            </div>
        </div>

        <!-- S1 -->
        <div class="bg-card border border-border rounded-lg p-4">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-lg bg-green-100 dark:bg-green-950/30">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-muted-foreground">Semestre 1</p>
                    <p class="text-xl font-bold text-foreground">{{ $semestre1->count() }}</p>
                </div>
            </div>
        </div>

        <!-- S2 -->
        <div class="bg-card border border-border rounded-lg p-4">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-950/30">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-muted-foreground">Semestre 2</p>
                    <p class="text-xl font-bold text-foreground">{{ $semestre2->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Semestre 1 -->
    <div class="mb-6">
        <div class="flex items-center gap-2 mb-3">
            <span class="w-6 h-6 rounded-full bg-green-100 dark:bg-green-950/30 text-green-600 flex items-center justify-center text-xs font-bold">S1</span>
            <h2 class="text-lg font-bold text-foreground">Semestre 1</h2>
        </div>
        
        <div class="bg-card border border-border rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-border bg-muted/30">
                            <th class="px-4 py-3 text-left font-semibold text-foreground">Code</th>
                            <th class="px-4 py-3 text-left font-semibold text-foreground">Intitulé</th>
                            <th class="px-4 py-3 text-center font-semibold text-foreground">Coef</th>
                            <th class="px-4 py-3 text-center font-semibold text-foreground">Éval</th>
                            <th class="px-4 py-3 text-right font-semibold text-foreground">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($semestre1 as $module)
                        <tr class="hover:bg-muted/30 transition-colors">
                            <td class="px-4 py-3">
                                <span class="text-xs font-bold px-2 py-1 rounded bg-green-100 dark:bg-green-950/30 text-green-700 dark:text-green-400">
                                    {{ $module->code }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-foreground">{{ $module->intitule }}</td>
                            <td class="px-4 py-3 text-center text-muted-foreground">{{ number_format($module->coefficient, 2) }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-xs font-bold px-2 py-1 rounded bg-primary/12 dark:bg-blue-950/30 text-blue-700 dark:text-blue-400">
                                    {{ $module->evaluations_count }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('modules.show', $module) }}" class="text-xs text-primary hover:text-primary/80 font-medium">Voir</a>
                                    <a href="{{ route('modules.edit', $module) }}" class="text-xs text-amber-600 hover:text-amber-700 font-medium">Éditer</a>
                                    <form action="{{ route('modules.destroy', $module) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer la suppression ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-destructive hover:text-destructive/80 font-medium">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-muted-foreground text-sm">
                                Aucun module
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Semestre 2 -->
    <div>
        <div class="flex items-center gap-2 mb-3">
            <span class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-950/30 text-blue-600 flex items-center justify-center text-xs font-bold">S2</span>
            <h2 class="text-lg font-bold text-foreground">Semestre 2</h2>
        </div>
        
        <div class="bg-card border border-border rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-border bg-muted/30">
                            <th class="px-4 py-3 text-left font-semibold text-foreground">Code</th>
                            <th class="px-4 py-3 text-left font-semibold text-foreground">Intitulé</th>
                            <th class="px-4 py-3 text-center font-semibold text-foreground">Coef</th>
                            <th class="px-4 py-3 text-center font-semibold text-foreground">Éval</th>
                            <th class="px-4 py-3 text-right font-semibold text-foreground">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($semestre2 as $module)
                        <tr class="hover:bg-muted/30 transition-colors">
                            <td class="px-4 py-3">
                                <span class="text-xs font-bold px-2 py-1 rounded bg-blue-100 dark:bg-blue-950/30 text-blue-700 dark:text-blue-400">
                                    {{ $module->code }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-foreground">{{ $module->intitule }}</td>
                            <td class="px-4 py-3 text-center text-muted-foreground">{{ number_format($module->coefficient, 2) }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-xs font-bold px-2 py-1 rounded bg-green-100 dark:bg-green-950/30 text-green-700 dark:text-green-400">
                                    {{ $module->evaluations_count }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('modules.show', $module) }}" class="text-xs text-primary hover:text-primary/80 font-medium">Voir</a>
                                    <a href="{{ route('modules.edit', $module) }}" class="text-xs text-amber-600 hover:text-amber-700 font-medium">Éditer</a>
                                    <form action="{{ route('modules.destroy', $module) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer la suppression ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-destructive hover:text-destructive/80 font-medium">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-muted-foreground text-sm">
                                Aucun module
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
