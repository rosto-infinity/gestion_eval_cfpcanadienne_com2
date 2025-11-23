@extends('layouts.app')

@section('title', 'Bilans de Compétences')

@section('content')
<div class=" mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- En-tête -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-foreground">📊 Bilans de Compétences</h1>
            <p class="mt-1 text-xs text-muted-foreground">Gestion des bilans d'étudiants</p>
        </div>
        <a href="{{ route('bilans.create') }}" class="px-4 py-2 text-sm font-medium text-primary-foreground bg-primary hover:bg-primary/90 rounded-md transition-colors inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nouveau bilan
        </a>
        <a href="{{ route('bilans.tableau-recapitulatif') }}" class="px-4 py-2 text-sm font-medium text-primary-foreground bg-primary/50 hover:bg-primary/90 rounded-md transition-colors inline-flex items-center gap-2">
           
            Recapitulatif
        </a>
    </div>

    <!-- Filtres -->
    <div class="bg-card border border-border rounded-lg p-5 mb-6">
        <form method="GET" action="{{ route('bilans.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <!-- Spécialité -->
            <div>
                <label for="specialite_id" class="block text-sm font-semibold text-foreground mb-2">Spécialité</label>
                <select name="specialite_id" id="specialite_id" class="w-full px-3 py-2 text-sm border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors">
                    <option value="">Toutes les spécialités</option>
                    @foreach($specialites as $specialite)
                    <option value="{{ $specialite->id }}" {{ request('specialite_id') == $specialite->id ? 'selected' : '' }}>
                        {{ $specialite->intitule }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Année académique -->
            <div>
                <label for="annee_id" class="block text-sm font-semibold text-foreground mb-2">Année académique</label>
                <select name="annee_id" id="annee_id" class="w-full px-3 py-2 text-sm border border-border rounded-md bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors">
                    <option value="">Toutes les années</option>
                    @foreach($annees as $annee)
                    <option value="{{ $annee->id }}" {{ request('annee_id') == $annee->id ? 'selected' : '' }}>
                        {{ $annee->libelle }} {{ $annee->is_active ? '(Active)' : '' }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Bouton Filtrer -->
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-primary-foreground bg-primary hover:bg-primary/90 rounded-md transition-colors inline-flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filtrer
                </button>
            </div>

        </form>
    </div>

    <!-- Liste des bilans -->
    <div class="bg-card border border-border rounded-lg overflow-hidden">
        
        @if($bilans->isEmpty())
        <!-- État vide -->
        <div class="text-center py-12 px-6">
            <svg class="mx-auto h-12 w-12 text-muted-foreground/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="mt-2 text-sm font-semibold text-foreground">Aucun bilan de compétences</h3>
            <p class="mt-1 text-xs text-muted-foreground">Commencez par créer un nouveau bilan.</p>
            <div class="mt-4">
                <a href="{{ route('bilans.create') }}" class="px-4 py-2 text-sm font-medium text-primary-foreground bg-primary hover:bg-primary/90 rounded-md transition-colors inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Créer un bilan
                </a>
            </div>
        </div>

        @else
        <!-- Tableau -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-muted border-b border-border">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-muted-foreground">Matricule</th>
                        <th class="px-4 py-3 text-left font-semibold text-muted-foreground">Étudiant</th>
                        <th class="px-4 py-3 text-left font-semibold text-muted-foreground">Spécialité</th>
                        <th class="px-4 py-3 text-left font-semibold text-muted-foreground">Année</th>
                        <th class="px-4 py-3 text-center font-semibold text-muted-foreground">Moy. Compétences</th>
                        <th class="px-4 py-3 text-center font-semibold text-muted-foreground">Moy. Générale</th>
                        <th class="px-4 py-3 text-right font-semibold text-muted-foreground">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach($bilans as $bilan)
                    <tr class="hover:bg-muted/50 transition-colors">
                        
                        <!-- Matricule -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="text-sm font-medium text-foreground">{{ $bilan->user->matricule ?? '-' }}</span>
                        </td>

                        <!-- Étudiant -->
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0 h-8 w-8">
                                    @if($bilan->user->profile)
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Storage::url($bilan->user->profile) }}" alt="{{ $bilan->user->name }}">
                                    @else
                                    <div class="h-8 w-8 rounded-full bg-primary/20 flex items-center justify-center text-xs font-semibold text-primary">
                                        {{ $bilan->user->initials() }}
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-foreground">{{ $bilan->user->name }}</div>
                                    <div class="text-xs text-muted-foreground">{{ $bilan->user->email }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Spécialité -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($bilan->user->specialite)
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-primary/10 text-primary">
                                {{ $bilan->user->specialite->intitule }}
                            </span>
                            @else
                            <span class="text-xs text-muted-foreground">-</span>
                            @endif
                        </td>

                        <!-- Année -->
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-foreground">
                            {{ $bilan->anneeAcademique->libelle ?? '-' }}
                        </td>

                        <!-- Moy. Compétences -->
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <div class="text-sm font-semibold text-primary">
                                {{ number_format($bilan->moy_competences, 2) }}/20
                            </div>
                        </td>

                        <!-- Moy. Générale -->
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <div class="text-sm font-bold {{ $bilan->moy_generale >= 10 ? 'text-green-600' : 'text-destructive' }}">
                                {{ number_format($bilan->moy_generale, 2) }}/20
                            </div>
                        </td>

                        <!-- Actions -->
                        <td class="px-4 py-3 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2">
                                
                                <!-- Voir -->
                                <a href="{{ route('bilans.show', $bilan) }}" class="p-1.5 text-muted-foreground hover:text-primary hover:bg-primary/10 rounded transition-colors" title="Voir">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                <!-- Modifier -->
                                <a href="{{ route('bilans.edit', $bilan) }}" class="p-1.5 text-muted-foreground hover:text-primary hover:bg-primary/10 rounded transition-colors" title="Modifier">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </a>

                                <!-- Supprimer -->
                                <form action="{{ route('bilans.destroy', $bilan) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce bilan ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-muted-foreground hover:text-destructive hover:bg-destructive/10 rounded transition-colors" title="Supprimer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-4 py-4 border-t border-border">
            {{ $bilans->links() }}
        </div>
        @endif

    </div>

    <!-- Statistiques globales -->
    @if(!$bilans->isEmpty())
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
        
        <!-- Total de bilans -->
        <div class="bg-card border border-border rounded-lg p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Total de bilans</p>
                    <p class="mt-2 text-2xl font-bold text-foreground">{{ $bilans->total() }}</p>
                </div>
                <div class="p-2.5 bg-primary/10 rounded-lg">
                    <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/>
                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm5-3a1 1 0 000 2h2a1 1 0 100-2H8z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Moyenne générale -->
        <div class="bg-card border border-border rounded-lg p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Moyenne générale</p>
                    <p class="mt-2 text-2xl font-bold text-primary">{{ number_format($bilans->avg('moy_generale'), 2) }}/20</p>
                </div>
                <div class="p-2.5 bg-primary/10 rounded-lg">
                    <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Admis -->
        <div class="bg-card border border-border rounded-lg p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Admis (≥10)</p>
                    <p class="mt-2 text-2xl font-bold text-green-600">{{ $bilans->where('moy_generale', '>=', 10)->count() }}</p>
                </div>
                <div class="p-2.5 bg-green-500/10 rounded-lg">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Ajourné -->
        <div class="bg-card border border-border rounded-lg p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide">Ajourné (<10)</p>
                    <p class="mt-2 text-2xl font-bold text-destructive">{{ $bilans->where('moy_generale', '<', 10)->count() }}</p>
                </div>
                <div class="p-2.5 bg-destructive/10 rounded-lg">
                    <svg class="w-5 h-5 text-destructive" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>
    @endif

</div>
@endsection
