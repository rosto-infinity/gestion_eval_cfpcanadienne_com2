@extends('layouts.app')

@section('title', 'Relevé de notes')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('evaluations.index') }}" class="text-blue-600 hover:text-blue-900 inline-flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour
    </a>
    <button onclick="window.print()" class="btn btn-primary">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
        </svg>
        Imprimer
    </button>
</div>

<div class="card" id="releve-notes">
    <div class="card-body">
        <!-- En-tête du relevé -->
        <div class="text-center mb-8 border-b-2 border-gray-200 pb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">RELEVÉ DE NOTES</h1>
            <p class="text-lg text-gray-600">Année Académique {{ $user->anneeAcademique->libelle }}</p>
        </div>

        <!-- Informations de l'étudiant -->
        <div class="grid grid-cols-2 gap-6 mb-8 bg-gray-50 p-6 rounded-lg">
            <div>
                <p class="text-sm text-gray-600">Matricule</p>
                <p class="text-lg font-semibold text-gray-900">{{ $user->matricule }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Nom et Prénom</p>
                <p class="text-lg font-semibold text-gray-900">{{ $user->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Spécialité</p>
                <p class="text-lg font-semibold text-gray-900">{{ $user->specialite->intitule }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Code Spécialité</p>
                <p class="text-lg font-semibold text-gray-900">{{ $user->specialite->code }}</p>
            </div>
        </div>

        <!-- Semestre 1 -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4 bg-blue-100 p-3 rounded">📘 SEMESTRE 1</h2>
            
            @if($evaluationsSemestre1->isEmpty())
            <div class="text-center py-8 bg-gray-50 rounded">
                <p class="text-gray-500">Aucune note enregistrée pour le semestre 1</p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Module</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Coef.</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Note /20</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Appréciation</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($evaluationsSemestre1 as $eval)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="badge badge-info">{{ $eval->module->code }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-gray-900">{{ $eval->module->intitule }}</span>
                            </td>
                            <td class="px-4 py-3 text-center text-sm text-gray-500">
                                {{ $eval->module->coefficient }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-lg font-bold {{ $eval->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($eval->note, 2) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge {{ $eval->note >= 10 ? 'badge-success' : 'badge-danger' }}">
                                    {{ $eval->getAppreciation() }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        
                        <!-- Moyenne du semestre -->
                        <tr class="bg-blue-50 font-bold">
                            <td colspan="3" class="px-4 py-3 text-right text-sm uppercase">
                                Moyenne Semestre 1 :
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-xl {{ $moyenneSemestre1 >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $moyenneSemestre1 ? number_format($moyenneSemestre1, 2) : '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($moyenneSemestre1)
                                <span class="badge {{ $moyenneSemestre1 >= 10 ? 'badge-success' : 'badge-danger' }}">
                                    {{ $moyenneSemestre1 >= 10 ? 'Admis' : 'Non admis' }}
                                </span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        <!-- Semestre 2 -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4 bg-green-100 p-3 rounded">📗 SEMESTRE 2</h2>
            
            @if($evaluationsSemestre2->isEmpty())
            <div class="text-center py-8 bg-gray-50 rounded">
                <p class="text-gray-500">Aucune note enregistrée pour le semestre 2</p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Module</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Coef.</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Note /20</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Appréciation</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($evaluationsSemestre2 as $eval)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="badge badge-success">{{ $eval->module->code }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-gray-900">{{ $eval->module->intitule }}</span>
                            </td>
                            <td class="px-4 py-3 text-center text-sm text-gray-500">
                                {{ $eval->module->coefficient }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-lg font-bold {{ $eval->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($eval->note, 2) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge {{ $eval->note >= 10 ? 'badge-success' : 'badge-danger' }}">
                                    {{ $eval->getAppreciation() }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        
                        <!-- Moyenne du semestre -->
                        <tr class="bg-green-50 font-bold">
                            <td colspan="3" class="px-4 py-3 text-right text-sm uppercase">
                                Moyenne Semestre 2 :
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-xl {{ $moyenneSemestre2 >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $moyenneSemestre2 ? number_format($moyenneSemestre2, 2) : '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($moyenneSemestre2)
                                <span class="badge {{ $moyenneSemestre2 >= 10 ? 'badge-success' : 'badge-danger' }}">
                                    {{ $moyenneSemestre2 >= 10 ? 'Admis' : 'Non admis' }}
                                </span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        <!-- Bilan des compétences -->
        @if($user->bilanCompetence)
        <div class="mt-8 border-t-2 border-gray-200 pt-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 bg-purple-100 p-3 rounded">🎯 BILAN FINAL</h2>
            
            <div class="bg-gray-50 p-6 rounded-lg">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-1">Moyenne Évaluations (30%)</p>
                        <p class="text-2xl font-bold text-blue-600">
                            {{ number_format($user->bilanCompetence->moy_evaluations, 2) }}
                        </p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-1">Bilan Compétences (70%)</p>
                        <p class="text-2xl font-bold text-purple-600">
                            {{ number_format($user->bilanCompetence->moy_competences, 2) }}
                        </p>
                    </div>
                    <div class="text-center col-span-2">
                        <p class="text-sm text-gray-600 mb-1">MOYENNE GÉNÉRALE</p>
                        <p class="text-4xl font-bold {{ $user->bilanCompetence->moyenne_generale >= 10 ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format($user->bilanCompetence->moyenne_generale, 2) }} /20
                        </p>
                        <p class="text-lg font-semibold mt-2">
                            <span class="badge {{ $user->bilanCompetence->moyenne_generale >= 10 ? 'badge-success' : 'badge-danger' }}">
                                {{ $user->bilanCompetence->getMention() }}
                            </span>
                        </p>
                    </div>
                </div>

                @if($user->bilanCompetence->observations)
                <div class="mt-6 border-t border-gray-200 pt-4">
                    <p class="text-sm font-medium text-gray-700 mb-2">Observations :</p>
                    <p class="text-sm text-gray-600">{{ $user->bilanCompetence->observations }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div class="mt-8 pt-6 border-t-2 border-gray-200 text-right text-sm text-gray-600">
            <p>Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
    @media print {
        .btn, nav, footer, a[href*="retour"] {
            display: none !important;
        }
        #releve-notes {
            box-shadow: none;
            border: none;
        }
    }
</style>
@endpush