@extends('layouts.app')

@section('title', 'Bilans de Compétences')

@section('content')
<div class="mb-6 flex justify-between items-center p-6">
    <h1 class="text-3xl font-bold text-gray-900">📊 Bilans de Compétences</h1>
    <a href="{{ route('bilans.create') }}" class="btn btn-primary">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nouveau bilan
    </a>
</div>

<!-- Filtres -->
<div class="card mb-6 p-6">
    <div class="card-body">
        <form method="GET" action="{{ route('bilans.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="specialite_id" class="block text-sm font-medium text-gray-700 mb-2">Spécialité</label>
                <select name="specialite_id" id="specialite_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Toutes les spécialités</option>
                    @foreach($specialites as $specialite)
                    <option value="{{ $specialite->id }}" {{ request('specialite_id') == $specialite->id ? 'selected' : '' }}>
                        {{ $specialite->intitule }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="annee_id" class="block text-sm font-medium text-gray-700 mb-2">Année académique</label>
                <select name="annee_id" id="annee_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Toutes les années</option>
                    @foreach($annees as $annee)
                    <option value="{{ $annee->id }}" {{ request('annee_id') == $annee->id ? 'selected' : '' }}>
                        {{ $annee->libelle }} {{ $annee->is_active ? '(Active)' : '' }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="btn btn-primary w-full">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filtrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Liste des bilans -->
<div class="card" >
    <div class="card-body">
        @if($bilans->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun bilan de compétences</h3>
            <p class="mt-1 text-sm text-gray-500">Commencez par créer un nouveau bilan.</p>
            <div class="mt-6">
                <a href="{{ route('bilans.create') }}" class="btn btn-primary">
                    Créer un bilan
                </a>
            </div>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Matricule</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Étudiant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Spécialité</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Année</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Moy. Compétences</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Moy. Générale</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Mention</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($bilans as $bilan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">{{ $bilan->user->matricule ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($bilan->user->profile)
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ Storage::url($bilan->user->profile) }}" alt="{{ $bilan->user->name }}">
                                    @else
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                        {{ $bilan->user->initials() }}
                                    </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $bilan->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $bilan->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($bilan->user->specialite)
                            <span class="badge badge-info">{{ $bilan->user->specialite->intitule }}</span>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $bilan->anneeAcademique->libelle ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="text-sm font-semibold text-purple-600">
                                {{ number_format($bilan->moy_competences, 2) }}/20
                            </div>
                            <div class="text-xs text-gray-500 mt-1">70%</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="text-sm font-bold {{ $bilan->moy_generale >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($bilan->moy_generale, 2) }}/20
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            {{-- <span class="badge {{ $bilan->getMentionBadgeClass() }}">
                                {{ $bilan->getMention() }}
                            </span> --}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <a href="{{ route('bilans.show', $bilan) }}" class="text-blue-600 hover:text-blue-900" title="Voir">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('bilans.edit', $bilan) }}" class="text-indigo-600 hover:text-indigo-900" title="Modifier">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                            </a>
                            {{-- <a href="{{ route('bilans.pdf', $bilan) }}" class="text-red-600 hover:text-red-900" title="Télécharger PDF" target="_blank">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </a> --}}
                            <form action="{{ route('bilans.destroy', $bilan) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce bilan ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $bilans->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Statistiques globales -->
@if(!$bilans->isEmpty())
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6 p-6">
    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total de bilans</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $bilans->total() }}</p>
                </div>
                <svg class="w-12 h-12 text-blue-100" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/>
                    <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm5-3a1 1 0 000 2h2a1 1 0 100-2H8z" clip-rule="evenodd"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Moyenne générale</p>
                    <p class="text-3xl font-bold text-purple-600">{{ number_format($bilans->avg('moy_generale'), 2) }}</p>
                </div>
                <svg class="w-12 h-12 text-purple-100" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Admis (≥10)</p>
                    <p class="text-3xl font-bold text-green-600">{{ $bilans->where('moy_generale', '>=', 10)->count() }}</p>
                </div>
                <svg class="w-12 h-12 text-green-100" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Ajourné (<10)</p>
                    <p class="text-3xl font-bold text-red-600">{{ $bilans->where('moy_generale', '<', 10)->count() }}</p>
                </div>
                <svg class="w-12 h-12 text-red-100" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animations des cartes de statistiques
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.animation = `fadeInUp 0.5s ease-out ${index * 0.1}s both`;
    });
});
</script>
@endpush
