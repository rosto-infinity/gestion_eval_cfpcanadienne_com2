
resources/views/bilans/show-bilans.blade.php
@extends('layouts.app')

@section('title', 'Détails du Bilan de Compétences')

@section('content')
<div class="mb-6 p-6 mb-6">
    <a href="{{ route('bilans.index') }}" class="text-blue-600 hover:text-blue-900 inline-flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour à la liste
    </a>
</div>

<!-- En-tête du bilan -->
<div class="card mb-6 p-6 p-6 bg-gradient-to-r from-blue-50 to-purple-50">
    <div class="card-body">
        <div class="flex items-start justify-between">
            <div class="flex items-start space-x-4">
                <!-- Photo de l'étudiant -->
                <div class="flex-shrink-0">
                    @if($bilan->user->profile)
                    <img class="h-20 w-20 rounded-full object-cover border-4 border-white shadow-lg" 
                         src="{{ Storage::url($bilan->user->profile) }}" 
                         alt="{{ $bilan->user->name }}">
                    @else
                    <div class="h-20 w-20 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-2xl border-4 border-white shadow-lg">
                        {{ $bilan->user->initials() }}
                    </div>
                    @endif
                </div>

                <!-- Informations de l'étudiant -->
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $bilan->user->name }}</h1>
                    
                    <div class="mt-3 grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-xs text-gray-600 uppercase tracking-wide">Matricule</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $bilan->user->matricule ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 uppercase tracking-wide">Spécialité</p>
                            @if($bilan->user->specialite)
                            <p class="text-lg font-semibold text-gray-900">{{ $bilan->user->specialite->intitule }}</p>
                            @else
                            <p class="text-lg font-semibold text-gray-400">-</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 uppercase tracking-wide">Année Académique</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $bilan->anneeAcademique->libelle }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 uppercase tracking-wide">Email</p>
                            <p class="text-lg font-semibold text-gray-900 truncate">{{ $bilan->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col space-y-2">
                <a href="{{ route('bilans.edit', $bilan) }}" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('bilans.pdf', $bilan) }}" class="btn btn-secondary btn-sm" target="_blank">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    PDF
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Résultats et Mentions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 p-6 p-6">
    <!-- Moyenne des Compétences -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-600 uppercase">Moy. Compétences (70%)</h3>
                <svg class="w-8 h-8 text-purple-200" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                </svg>
            </div>
            <div class="text-4xl font-bold text-purple-600">{{ number_format($bilan->moy_competences, 2) }}</div>
            <div class="text-sm text-gray-500 mt-2">/20</div>
        </div>
    </div>

    <!-- Moyenne Générale -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-600 uppercase">Moyenne Générale</h3>
                <svg class="w-8 h-8 {{ $bilan->moy_generale >= 10 ? 'text-green-200' : 'text-red-200' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="text-4xl font-bold {{ $bilan->moy_generale >= 10 ? 'text-green-600' : 'text-red-600' }}">
                {{ number_format($bilan->moy_generale, 2) }}
            </div>
            <div class="text-sm text-gray-500 mt-2">/20</div>
        </div>
    </div>

    <!-- Mention -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-600 uppercase">Mention</h3>
                <svg class="w-8 h-8 text-yellow-200" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
            {{-- <div class="text-3xl font-bold">
                <span class="badge {{ $bilan->getMentionBadgeClass() }} text-lg px-4 py-2">
                    {{ $bilan->getMention() }}
                </span>
            </div> --}}
            <div class="text-sm text-gray-500 mt-2">
                @if($bilan->moy_generale >= 10)
                    ✅ Admis
                @else
                    ❌ Ajourné
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Calcul détaillé -->
<div class="card mb-6 p-6 p-6">
    <div class="card-header">
        <h3 class="text-lg font-semibold text-gray-900">📊 Détail du Calcul</h3>
    </div>
    <div class="card-body">
        <div class="space-y-4">
            <!-- Évaluation Semestre 1 -->
            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Moyenne Évaluations Semestre 1</span>
                    <span class="text-lg font-bold text-blue-600">
                        {{ number_format($evaluationsSemestre1->avg('note') ?? 0, 2) }}/20
                    </span>
                </div>
                <div class="text-xs text-gray-600">
                    {{ $evaluationsSemestre1->count() }} évaluation(s) saisie(s)
                </div>
            </div>

            <!-- Évaluation Semestre 2 -->
            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Moyenne Évaluations Semestre 2</span>
                    <span class="text-lg font-bold text-blue-600">
                        {{ number_format($evaluationsSemestre2->avg('note') ?? 0, 2) }}/20
                    </span>
                </div>
                <div class="text-xs text-gray-600">
                    {{ $evaluationsSemestre2->count() }} évaluation(s) saisie(s)
                </div>
            </div>

            <!-- Moyenne Générale des Évaluations -->
            <div class="p-4 bg-indigo-50 rounded-lg border border-indigo-200">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Moyenne Générale Évaluations (30%)</span>
                    <span class="text-lg font-bold text-indigo-600">
                        {{ number_format((($evaluationsSemestre1->avg('note') ?? 0) + ($evaluationsSemestre2->avg('note') ?? 0)) / 2, 2) }}/20
                    </span>
                </div>
                <div class="text-xs text-gray-600">
                    Contribution: {{ number_format(((($evaluationsSemestre1->avg('note') ?? 0) + ($evaluationsSemestre2->avg('note') ?? 0)) / 2) * 0.30, 2) }}/20
                </div>
            </div>

            <!-- Compétences -->
            <div class="p-4 bg-purple-50 rounded-lg border border-purple-200">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Moyenne Compétences (70%)</span>
                    <span class="text-lg font-bold text-purple-600">
                        {{ number_format($bilan->moy_competences, 2) }}/20
                    </span>
                </div>
                <div class="text-xs text-gray-600">
                    Contribution: {{ number_format($bilan->moy_competences * 0.70, 2) }}/20
                </div>
            </div>

            <!-- Résultat Final -->
            <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-2 border-green-300">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-bold text-gray-900 uppercase">Moyenne Générale Finale</span>
                    <span class="text-3xl font-bold {{ $bilan->moy_generale >= 10 ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format($bilan->moy_generale, 2) }}/20
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Évaluations par Semestre -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6 p-6">
    <!-- Semestre 1 -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">📚 Évaluations Semestre 1</h3>
        </div>
        <div class="card-body">
            @if($evaluationsSemestre1->isEmpty())
            <div class="text-center py-8">
                <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="mt-2 text-sm text-gray-600">Aucune évaluation</p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Matière</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase">Note</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase">Résultat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($evaluationsSemestre1 as $eval)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $eval->matiere->intitule ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-lg font-bold {{ $eval->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($eval->note, 2) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($eval->note >= 10)
                                <span class="badge badge-success">✓ Validé</span>
                                @else
                                <span class="badge badge-danger">✗ Non validé</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 font-semibold">
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900">Moyenne</td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-lg font-bold text-blue-600">
                                    {{ number_format($evaluationsSemestre1->avg('note'), 2) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($evaluationsSemestre1->avg('note') >= 10)
                                <span class="badge badge-success">✓ Validé</span>
                                @else
                                <span class="badge badge-danger">✗ Non validé</span>
                                @endif
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endif
        </div>
    </div>

    <!-- Semestre 2 -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-semibold text-gray-900">📚 Évaluations Semestre 2</h3>
        </div>
        <div class="card-body">
            @if($evaluationsSemestre2->isEmpty())
            <div class="text-center py-8">
                <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="mt-2 text-sm text-gray-600">Aucune évaluation</p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Matière</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase">Note</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase">Résultat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($evaluationsSemestre2 as $eval)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $eval->matiere->intitule ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-lg font-bold {{ $eval->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($eval->note, 2) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($eval->note >= 10)
                                <span class="badge badge-success">✓ Validé</span>
                                @else
                                <span class="badge badge-danger">✗ Non validé</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 font-semibold">
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900">Moyenne</td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-lg font-bold text-blue-600">
                                    {{ number_format($evaluationsSemestre2->avg('note'), 2) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($evaluationsSemestre2->avg('note') >= 10)
                                <span class="badge badge-success">✓ Validé</span>
                                @else
                                <span class="badge badge-danger">✗ Non validé</span>
                                @endif
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Observations -->
@if($bilan->observations)
<div class="card mb-6 p-6">
    <div class="card-header">
        <h3 class="text-lg font-semibold text-gray-900">📝 Observations</h3>
    </div>
    <div class="card-body">
        <div class="p-4 bg-amber-50 rounded-lg border-l-4 border-amber-400">
            <p class="text-gray-800 whitespace-pre-wrap">{{ $bilan->observations }}</p>
        </div>
    </div>
</div>
@endif

<!-- Informations supplémentaires -->
<div class="card p-6">
    <div class="card-header">
        <h3 class="text-lg font-semibold text-gray-900">ℹ️ Informations</h3>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-600 mb-1">Créé le</p>
                <p class="text-lg font-semibold text-gray-900">
                    {{ $bilan->created_at->format('d/m/Y à H:i') }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Dernière modification</p>
                <p class="text-lg font-semibold text-gray-900">
                    {{ $bilan->updated_at->format('d/m/Y à H:i') }}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Boutons d'action -->
<div class="mt-6 flex items-center justify-between mb-6 p-6">
    <a href="{{ route('bilans.index') }}" class="btn btn-secondary">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour à la liste
    </a>
    
    <div class="flex space-x-3 p-6">
        <a href="{{ route('bilans.edit', $bilan) }}" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
            Modifier
        </a>
        
        <a href="{{ route('bilans.pdf', $bilan) }}" class="btn btn-secondary" target="_blank">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Télécharger PDF
        </a>

        <form action="{{ route('bilans.destroy', $bilan) }}" method="POST" class="inline" 
              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce bilan ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Supprimer
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation d'entrée des cartes
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.animation = `fadeInUp 0.5s ease-out ${index * 0.1}s both`;
    });

    // Impression améliorée
    const printBtn = document.querySelector('[href*="pdf"]');
    if (printBtn) {
        printBtn.addEventListener('click', function(e) {
            console.log('Génération du PDF...');
        });
    }
});

// Animation CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush
