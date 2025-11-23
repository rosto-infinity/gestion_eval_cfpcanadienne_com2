@extends('layouts.app')

@section('title', 'Années Académiques')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- En-tête -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-4xl font-bold text-foreground">📅 Années Académiques</h1>
            <p class="mt-2 text-sm text-muted-foreground">Gestion des périodes scolaires et calendriers</p>
        </div>
        <a href="{{ route('annees.create') }}" 
           class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-semibold transition-all duration-200 shadow-sm hover:shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Nouvelle Année</span>
        </a>
    </div>

    <!-- Info année active -->
    @php
        $activeYear = $annees->firstWhere('is_active', true);
    @endphp
    @if($activeYear)
    <div class="mb-8 p-6 bg-primary/5 border-l-4 border-primary rounded-lg shadow-sm">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-primary/20">
                    <svg class="h-6 w-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-foreground">Année Académique Active</h3>
                <p class="mt-1 text-base font-semibold text-primary">{{ $activeYear->libelle }}</p>
                <p class="mt-2 text-sm text-muted-foreground flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/>
                    </svg>
                    Du <strong>{{ $activeYear->date_debut->format('d/m/Y') }}</strong> au <strong>{{ $activeYear->date_fin->format('d/m/Y') }}</strong>
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Tableau des années -->
    <div class="card bg-card border border-border rounded-lg shadow-sm overflow-hidden">
        <div class="p-6 border-b border-border">
            <h2 class="text-xl font-bold text-foreground">Liste des années académiques</h2>
        </div>
        
        <div class="overflow-x-auto">
            @if($annees->isEmpty())
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-muted-foreground/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-foreground">Aucune année académique</h3>
                <p class="mt-1 text-sm text-muted-foreground">Commencez par créer votre première année académique.</p>
                <a href="{{ route('annees.create') }}" 
                   class="mt-6 inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg font-semibold transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Créer la première année
                </a>
            </div>
            @else
            <table class="w-full text-sm">
                <thead class="bg-muted/50 border-b border-border">
                    <tr>
                        <th class="px-6 py-4 text-left font-bold text-foreground">Libellé</th>
                        <th class="px-6 py-4 text-left font-bold text-foreground">Période</th>
                        <th class="px-6 py-4 text-center font-bold text-foreground">Statut</th>
                        <th class="px-6 py-4 text-right font-bold text-foreground">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach($annees as $annee)
                    <tr class="hover:bg-muted/30 transition-colors duration-150 {{ $annee->is_active ? 'bg-primary/5' : '' }}">
                        <!-- Libellé -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($annee->is_active)
                                    <span class="text-xl">⭐</span>
                                @else
                                    <div class="w-6 h-6 rounded-full bg-muted/30"></div>
                                @endif
                                <div>
                                    <div class="font-semibold text-foreground">{{ $annee->libelle }}</div>
                                    @if($annee->is_active)
                                        <div class="text-xs font-medium text-primary mt-1">Année en cours</div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Période -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 text-foreground">
                                <svg class="w-4 h-4 text-muted-foreground" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/>
                                </svg>
                                <span class="font-medium">{{ $annee->date_debut->format('d/m/Y') }}</span>
                                <span class="text-muted-foreground">→</span>
                                <span class="font-medium">{{ $annee->date_fin->format('d/m/Y') }}</span>
                            </div>
                        </td>

                        <!-- Statut -->
                        <td class="px-6 py-4 text-center">
                            @if($annee->is_active)
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary font-semibold text-xs">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-muted text-muted-foreground font-semibold text-xs">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    Inactive
                                </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                @if(!$annee->is_active)
                                    <form action="{{ route('annees.activate', $annee) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-primary hover:bg-primary/10 rounded-lg transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Activer
                                        </button>
                                    </form>
                                @endif
                                
                                <a href="{{ route('annees.show', $annee) }}" 
                                   class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-primary hover:bg-primary/10 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Voir
                                </a>
                                
                                <a href="{{ route('annees.edit', $annee) }}" 
                                   class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-accent hover:bg-accent/10 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Modifier
                                </a>
                                
                                @if(!$annee->is_active)
                                    <form action="{{ route('annees.destroy', $annee) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette année ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-destructive hover:bg-destructive/10 rounded-lg transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Supprimer
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    @if($annees->hasPages())
    <div class="mt-6">
        {{ $annees->links() }}
    </div>
    @endif

    <!-- Information importante -->
    <div class="mt-8 p-6 bg-accent/5 border-l-4 border-accent rounded-lg shadow-sm">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-accent/20">
                    <svg class="h-6 w-6 text-accent" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-foreground">Note importante</h3>
                <p class="mt-2 text-sm text-muted-foreground">
                    Une seule année peut être active à la fois. L'activation d'une nouvelle année désactivera automatiquement l'année précédente. Les années inactives peuvent être supprimées, mais les années actives sont protégées.
                </p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    :root {
        --background: #ffffff;
        --foreground: #1a1a1a;
        --primary: #09e540;
        --primary-foreground: #ffffff;
        --accent: #f59e0b;
        --accent-foreground: #ffffff;
        --destructive: #ef4444;
        --muted: #e5e5e5;
        --muted-foreground: #666666;
        --border: #d0d0d0;
        --card: #fafafa;
        --card-foreground: #1a1a1a;
    }

    body {
        font-family: 'DejaVu Sans', 'Helvetica', sans-serif;
        color: var(--foreground);
        background-color: var(--background);
    }

    /* Variables de couleur */
    .bg-background { background-color: var(--background); }
    .bg-card { background-color: var(--card); }
    .bg-primary { background-color: var(--primary); }
    .bg-primary-foreground { background-color: var(--primary-foreground); }
    .bg-accent { background-color: var(--accent); }
    .bg-accent-foreground { background-color: var(--accent-foreground); }
    .bg-destructive { background-color: var(--destructive); }
    .bg-muted { background-color: var(--muted); }
    .bg-primary\/5 { background-color: rgba(9, 229, 64, 0.05); }
    .bg-primary\/10 { background-color: rgba(9, 229, 64, 0.1); }
    .bg-primary\/20 { background-color: rgba(9, 229, 64, 0.2); }
    .bg-accent\/5 { background-color: rgba(245, 158, 11, 0.05); }
    .bg-accent\/10 { background-color: rgba(245, 158, 11, 0.1); }
    .bg-accent\/20 { background-color: rgba(245, 158, 11, 0.2); }
    .bg-destructive\/10 { background-color: rgba(239, 68, 68, 0.1); }
    .bg-muted\/30 { background-color: rgba(229, 229, 229, 0.3); }
    .bg-muted\/50 { background-color: rgba(229, 229, 229, 0.5); }

    .text-foreground { color: var(--foreground); }
    .text-primary { color: var(--primary); }
    .text-accent { color: var(--accent); }
    .text-destructive { color: var(--destructive); }
    .text-muted-foreground { color: var(--muted-foreground); }

    .border { border: 1px solid var(--border); }
    .border-b { border-bottom: 1px solid var(--border); }
    .border-l-4 { border-left: 4px solid; }
    .border-primary { border-color: var(--primary); }
    .border-accent { border-color: var(--accent); }
    .border-border { border-color: var(--border); }

    .rounded-lg { border-radius: 0.5rem; }
    .rounded-full { border-radius: 9999px; }

    .p-4 { padding: 1rem; }
    .p-6 { padding: 1.5rem; }
    .p-12 { padding: 3rem; }
    .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
    .px-4 { padding-left: 1rem; padding-right: 1rem; }
    .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
    .py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
    .py-1\.5 { padding-top: 0.375rem; padding-bottom: 0.375rem; }
    .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
    .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
    .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
    .py-8 { padding-top: 2rem; padding-bottom: 2rem; }

    .mb-2 { margin-bottom: 0.5rem; }
    .mb-4 { margin-bottom: 1rem; }
    .mb-6 { margin-bottom: 1.5rem; }
    .mb-8 { margin-bottom: 2rem; }
    .mt-1 { margin-top: 0.25rem; }
    .mt-2 { margin-top: 0.5rem; }
    .mt-4 { margin-top: 1rem; }
    .mt-6 { margin-top: 1.5rem; }

    .gap-1 { gap: 0.25rem; }
    .gap-2 { gap: 0.5rem; }
    .gap-3 { gap: 0.75rem; }
    .gap-4 { gap: 1rem; }

    .font-bold { font-weight: 700; }
    .font-semibold { font-weight: 600; }
    .font-medium { font-weight: 500; }

    .text-center { text-align: center; }
    .text-left { text-align: left; }
    .text-right { text-align: right; }

    .text-xs { font-size: 0.75rem; }
    .text-sm { font-size: 0.875rem; }
    .text-base { font-size: 1rem; }
    .text-lg { font-size: 1.125rem; }
    .text-xl { font-size: 1.25rem; }
    .text-4xl { font-size: 2.25rem; }

    .w-4 { width: 1rem; }
    .w-5 { width: 1.25rem; }
    .w-6 { width: 1.5rem; }
    .w-12 { width: 3rem; }

    .h-4 { height: 1rem; }
    .h-5 { height: 1.25rem; }
    .h-6 { height: 1.5rem; }
    .h-12 { height: 3rem; }

    .flex { display: flex; }
    .flex-col { flex-direction: column; }
    .items-start { align-items: flex-start; }
    .items-center { align-items: center; }
    .items-end { align-items: flex-end; }
    .justify-center { justify-content: center; }
    .justify-between { justify-content: space-between; }
    .justify-end { justify-content: flex-end; }

    .gap-2 { gap: 0.5rem; }
    .gap-3 { gap: 0.75rem; }
    .gap-4 { gap: 1rem; }

    .inline-flex { display: inline-flex; }

    .hover\:bg-primary\/10:hover { background-color: rgba(9, 229, 64, 0.1); }
    .hover\:bg-accent\/10:hover { background-color: rgba(245, 158, 11, 0.1); }
    .hover\:bg-destructive\/10:hover { background-color: rgba(239, 68, 68, 0.1); }
    .hover\:bg-muted\/30:hover { background-color: rgba(229, 229, 229, 0.3); }
    .hover\:bg-primary\/90:hover { background-color: rgba(9, 229, 64, 0.9); }

    .transition-all { transition-property: all; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 200ms; }
    .transition-colors { transition-property: color, background-color, border-color; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 200ms; }
    .duration-150 { transition-duration: 150ms; }
    .duration-200 { transition-duration: 200ms; }

    .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
    .shadow-md { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
    .hover\:shadow-md:hover { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }

    .max-w-7xl { max-width: 80rem; }
    .mx-auto { margin-left: auto; margin-right: auto; }

    .overflow-x-auto { overflow-x: auto; }

    .divide-y { border-bottom-width: 1px; }
    .divide-y > * + * { border-top-width: 1px; }
    .divide-border { border-color: var(--border); }

    @media (min-width: 640px) {
        .sm\:px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        .sm\:flex { display: flex; }
        .sm\:items-center { align-items: center; }
        .sm\:justify-between { justify-content: space-between; }
        .sm\:mt-0 { margin-top: 0; }
        .sm\:flex-row { flex-direction: row; }
        .sm\:w-auto { width: auto; }
    }

    @media (min-width: 1024px) {
        .lg\:px-8 { padding-left: 2rem; padding-right: 2rem; }
    }
</style>
@endpush
