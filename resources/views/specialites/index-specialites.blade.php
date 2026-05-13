<x-app-layout title="Spécialités">
<div class=" mx-auto px-4 sm:px-6 lg:px-8">
    <!-- En-tête -->
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Spécialités</h1>
            <p class="mt-2 text-sm text-muted-foreground">Gestion des spécialités académiques</p>
        </div>
         <!-- Afficher les erreurs de validation -->
                @if ($errors->any())
                    <div class="p-4 bg-red-50 dark:bg-red-950/20 border-b border-red-200 dark:border-red-800">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="flex-1">
                                <h4 class="font-semibold text-red-900 dark:text-red-100 mb-2">Erreurs de validation</h4>
                                <ul class="text-sm text-red-800 dark:text-red-200 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="flex items-center gap-2">
                                            <span class="inline-block w-1.5 h-1.5 bg-red-600 rounded-full"></span>
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('specialites.create') }}" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-primary-foreground uppercase tracking-widest hover:bg-primary/90 active:bg-primary/80 focus:outline-none focus:ring focus:ring-primary/50 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouvelle Spécialité
            </a>
        </div>
    </div>

    <!-- Barre de recherche -->
    <div class="bg-card text-card-foreground border border-border rounded-lg shadow mb-6 p-4">
        <form method="GET" action="{{ route('specialites.index') }}" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par code ou intitulé..." class="w-full bg-background text-foreground rounded-md border-border shadow-sm focus:border-primary focus:ring-primary">
            </div>
            <button type="submit" class="px-4 py-2 bg-secondary text-secondary-foreground rounded-md hover:bg-secondary/80">
                Rechercher
            </button>
            @if(request('search'))
                <a href="{{ route('specialites.index') }}" class="px-4 py-2 bg-muted text-muted-foreground rounded-md hover:bg-muted/80">
                    Réinitialiser
                </a>
            @endif
        </form>
    </div>

    <!-- Tableau des spécialités -->
    <div class="bg-card text-card-foreground border border-border shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-border">
            <thead class="bg-muted/50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Intitulé</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Description</th>
                    {{-- <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Étudiants</th> --}}
                    <th class="px-6 py-3 text-right text-xs font-medium text-muted-foreground uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-card divide-y divide-border">
                @forelse($specialites as $specialite)
                <tr class="hover:bg-muted/50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-primary/10 text-primary">
                            {{ $specialite->code }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-foreground">{{ $specialite->intitule }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-muted-foreground">
                            {{ Str::limit($specialite->description, 60) ?? 'N/A' }}
                        </div>
                    </td>
                    {{-- <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            {{ $specialite->users_count }} étudiant(s)
                        </span>
                    </td> --}}
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('specialites.show', $specialite) }}" class="text-primary hover:text-primary/80">Voir</a>
                        <a href="{{ route('specialites.edit', $specialite) }}" class="text-yellow-600 hover:text-yellow-700">Modifier</a>
                        <form action="{{ route('specialites.destroy', $specialite) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette spécialité ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-destructive hover:text-destructive/80">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-muted-foreground mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-muted-foreground text-lg">Aucune spécialité trouvée</p>
                            <a href="{{ route('specialites.create') }}" class="mt-4 text-primary hover:text-primary/80">Créer la première spécialité</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $specialites->links() }}
    </div>
</div>
</x-app-layout>