@extends('layouts.app')

@section('title', 'Étudiants')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-foreground tracking-tight">Étudiants</h1>
                <p class="text-sm text-muted-foreground mt-1">Gestion académique et administrative des étudiants
                </p>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="location.reload()"
                    class="p-2 text-muted-foreground hover:text-foreground transition-colors rounded-full hover:bg-muted"
                    title="Actualiser">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
                <a href="{{ route('users.create') }}"
                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-primary-foreground bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ring shadow-sm transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouvel étudiant
                </a>
            </div>
        </div>

        <!-- Barre d'outils et Filtres -->
        <div class="bg-card rounded-xl shadow-sm border border-border p-4">
            <form method="GET" action="{{ route('users.index') }}"
                class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">

                <!-- Recherche -->
                <div class="md:col-span-3 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..."
                        class="block w-full pl-10 pr-3 py-2 border border-input rounded-lg leading-5 bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-1 focus:ring-ring focus:border-ring sm:text-sm transition-colors">
                </div>

                <!-- Filtres Dropdowns -->
                <div class="md:col-span-2">
                    <select name="specialite_id" onchange="this.form.submit()"
                        class="block w-full py-2 pl-3 pr-8 border border-input rounded-lg leading-5 bg-background text-foreground focus:outline-none focus:ring-1 focus:ring-ring focus:border-ring sm:text-sm transition-colors text-ellipsis overflow-hidden">
                        <option value="">Spécialités...</option>
                        @foreach ($specialites as $specialite)
                            <option value="{{ $specialite->id }}"
                                {{ request('specialite_id') == $specialite->id ? 'selected' : '' }}>
                                {{ $specialite->intitule }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <select name="annee_id" onchange="this.form.submit()"
                        class="block w-full py-2 pl-3 pr-8 border border-input rounded-lg leading-5 bg-background text-foreground focus:outline-none focus:ring-1 focus:ring-ring focus:border-ring sm:text-sm transition-colors text-ellipsis overflow-hidden">
                        <option value="">Années...</option>
                        @foreach ($annees as $annee)
                            <option value="{{ $annee->id }}" {{ request('annee_id') == $annee->id ? 'selected' : '' }}>
                                {{ $annee->libelle }} {{ $annee->is_active ? '(Active)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Actions Menu (Export/Import) -->
                <div class="md:col-span-5 flex flex-wrap justify-end gap-2">
                    <!-- Exporter Excel -->
                    <button type="submit" formaction="{{ route('users.export.all') }}"
                        class="inline-flex items-center px-3 py-2 border border-input shadow-sm text-xs font-medium rounded-lg text-primary bg-primary/10 hover:bg-primary/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ring transition-colors"
                        title="Exporter tous les étudiants">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0-6-6-6-6v6m0 0-6-6-6-6v6m0 0-6-6-6-6v6" />
                        </svg>
                        Export
                    </button>

                    <!-- Exporter Spécialité -->
                    <button type="submit" formaction="{{ route('users.export.by.specialite') }}"
                        class="inline-flex items-center px-3 py-2 border border-input shadow-sm text-xs font-medium rounded-lg text-secondary-foreground bg-secondary hover:bg-secondary/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ring transition-colors"
                        title="Exporter par spécialité">
                        <svg class="mr-2 h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v1a3 3 0 006 0h6a3 3 0 006 0v1M9 7H6a3 3 0 00-3 3v9a3 3 0 003 3h6a3 3 0 003-3V10a3 3 0 00-3-3H6a3 3 0 00-3 3v9a3 3 0 003 3z" />
                        </svg>
                        Par Spé.
                    </button>

                    <!-- Importer -->
                    <a href="{{ route('users.import') }}"
                        class="inline-flex items-center px-3 py-2 border border-input shadow-sm text-xs font-medium rounded-lg text-secondary-foreground bg-secondary hover:bg-secondary/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ring transition-colors">
                        <svg class="mr-2 h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Import
                    </a>

                    <!-- Modèle -->
                    <a href="{{ route('users.import.template') }}"
                        class="inline-flex items-center px-3 py-2 border border-input shadow-sm text-xs font-medium rounded-lg text-secondary-foreground bg-secondary hover:bg-secondary/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ring transition-colors">
                        <svg class="mr-2 h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0-6-6-6-6v6m0 0-6-6-6-6v6m0 0-6-6-6-6v6" />
                        </svg>
                        Modèle
                    </a>
                </div>
            </form>
        </div>

        <!-- Liste des étudiants -->
        <div class="space-y-4">
            @forelse($users as $user)
                <div
                    class="bg-card rounded-xl p-4 shadow-sm border border-border hover:shadow-md transition-shadow duration-200">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6">

                        <!-- Avatar -->
                        <div class="flex-shrink-0 relative">
                            @if ($user->profile)
                                <img class="h-16 w-16 sm:h-20 sm:w-20 rounded-full object-cover border-2 border-background shadow-sm"
                                    src="{{ Storage::url($user->profile) }}" alt="{{ $user->name }}"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div
                                    class="h-16 w-16 sm:h-20 sm:w-20 rounded-full bg-primary/10 flex items-center justify-center text-xl font-bold text-primary hidden shadow-sm">
                                    {{ $user->initials() }}
                                </div>
                            @else
                                <div
                                    class="h-16 w-16 sm:h-20 sm:w-20 rounded-full bg-secondary flex items-center justify-center text-xl font-bold text-secondary-foreground shadow-sm border-2 border-background">
                                    {{ $user->initials() }}
                                </div>
                            @endif
                            <span
                                class="absolute bottom-1 right-1 block h-4 w-4 rounded-full ring-2 ring-background {{ $user->statut === 'actif' ? 'bg-green-500' : ($user->statut === 'inactif' ? 'bg-gray-500' : 'bg-destructive') }}"></span>
                        </div>

                        <!-- Infos Principales -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="text-lg font-bold text-foreground truncate pr-4">
                                    {{ $user->name }}
                                </h3>
                                <!-- Mobile Menu / Actions (Responsive) -->
                            </div>
                            <p class="text-sm font-medium text-primary mb-2">
                                {{ $user->matricule ?? 'Sans matricule' }}
                            </p>

                            <div class="flex flex-wrap gap-2 text-sm text-muted-foreground">
                                @if ($user->specialite)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary">
                                        {{ $user->specialite->intitule }}
                                    </span>
                                @endif

                                @if ($user->niveau)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary text-secondary-foreground">
                                        {{ $user->niveau->label() }}
                                    </span>
                                @endif

                                @if ($user->anneeAcademique)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-accent text-accent-foreground">
                                        {{ $user->anneeAcademique->libelle }}
                                    </span>
                                @endif

                                <span class="inline-flex items-center gap-1 text-xs text-muted-foreground">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $user->email }}
                                </span>
                            </div>
                        </div>

                        <!-- Actions Buttons -->
                        <div
                            class="flex flex-row sm:flex-col gap-2 w-full sm:w-auto mt-2 sm:mt-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-border">
                            <a href="{{ route('users.show', $user) }}"
                                class="flex-1 sm:flex-none inline-flex items-center justify-center px-3 py-1.5 border border-input rounded-md text-sm font-medium text-secondary-foreground bg-secondary hover:bg-secondary/80 transition-colors">
                                Voir
                            </a>
                            <div class="flex gap-2">
                                <a href="{{ route('users.edit', $user) }}"
                                    class="flex-1 inline-flex items-center justify-center p-1.5 border border-input rounded-md text-muted-foreground hover:text-primary hover:bg-primary/10 transition-colors"
                                    title="Modifier">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>

                                @if ($user->anneeAcademique)
                                    <a href="{{ route('evaluations.releve-notes', $user) }}"
                                        class="flex-1 inline-flex items-center justify-center p-1.5 border border-input rounded-md text-muted-foreground hover:text-primary hover:bg-primary/10 transition-colors"
                                        title="Notes">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </a>
                                @endif

                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                    class="flex-1 inline sm:inline-block"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full h-full inline-flex items-center justify-center p-1.5 border border-transparent rounded-md text-destructive hover:bg-destructive/10 transition-colors"
                                        title="Supprimer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-card rounded-xl shadow-sm border border-border p-12 text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-muted mb-4">
                        <svg class="h-8 w-8 text-muted-foreground" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-foreground">Aucun étudiant trouvé</h3>
                    <p class="mt-1 text-muted-foreground">Commencez par ajouter un nouvel étudiant ou modifiez
                        vos filtres.</p>
                    <div class="mt-6 flex justify-center gap-4">
                        @if (request()->hasAny(['search', 'specialite_id', 'annee_id']))
                            <a href="{{ route('users.index') }}"
                                class="text-primary hover:text-primary/80 font-medium text-sm">Réinitialiser les
                                filtres</a>
                        @endif
                        <a href="{{ route('users.create') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-primary-foreground bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ring">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Ajouter un étudiant
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $users->links() }}
        </div>

    </div>
@endsection
