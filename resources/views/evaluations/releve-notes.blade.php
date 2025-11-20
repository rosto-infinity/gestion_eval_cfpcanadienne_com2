@extends('layouts.app')

@section('title', 'Relevé de Notes')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- En-tête avec actions d'impression -->
    <div class="mb-6 flex items-center justify-between no-print">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Relevé de Notes</h1>
            <p class="mt-2 text-sm text-gray-700">Bulletin semestriel de l'étudiant</p>
        </div>
        <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Imprimer
        </button>
    </div>

    <!-- Bulletin -->
    <div id="bulletin" class="bg-white shadow-lg rounded-lg overflow-hidden print:shadow-none">
        <!-- En-tête du bulletin -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold mb-2">RELEVÉ DE NOTES</h2>
                <p class="text-indigo-100">Année Académique {{ $user->anneeAcademique->libelle }}</p>
            </div>
        </div>

        <!-- Informations étudiant -->
        <div class="p-8 border-b-2 border-gray-200">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Nom et Prénom</p>
                    <p class="text-lg font-bold text-gray-900">{{ $user->getFullName() }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Matricule</p>
                    <p class="text-lg font-bold text-gray-900">{{ $user->matricule }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Spécialité</p>
                    <p class="text-lg font-bold text-gray-900">{{ $user->specialite->intitule }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Code Spécialité</p>
                    <p class="text-lg font-bold text-gray-900">{{ $user->specialite->code }}</p>
                </div>
            </div>
        </div>

        <!-- Notes Semestre 1 -->
        <div class="p-8 border-b-2 border-gray-200">
            <div class="flex items-center mb-4">
                <span class="w-10 h-10 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold mr-3">S1</span>
                <h3 class="text-xl font-bold text-gray-900">SEMESTRE 1</h3>
            </div>
            
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b-2 border-gray-200">
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Code</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Intitulé du Module</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Coeff.</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Note /20</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Appréciation</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($evaluationsSemestre1 as $eval)
                    <tr class="{{ $eval->note >= 10 ? 'bg-green-50' : 'bg-red-50' }}">
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded font-bold text-sm">{{ $eval->module->code }}</span>
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $eval->module->intitule }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($eval->module->coefficient, 2) }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="text-lg font-bold {{ $eval->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($eval->note, 2) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($eval->note >= 16) bg-green-100 text-green-800
                                @elseif($eval->note >= 14) bg-blue-100 text-blue-800
                                @elseif($eval->note >= 12) bg-yellow-100 text-yellow-800
                                @elseif($eval->note >= 10) bg-orange-100 text-orange-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $eval->getAppreciation() }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">Aucune évaluation pour le semestre 1</td>
                    </tr>
                    @endforelse
                    @if($moyenneSemestre1)
                    <tr class="bg-green-100 font-bold">
                        <td colspan="3" class="px-4 py-3 text-right">MOYENNE SEMESTRE 1:</td>
                        <td class="px-4 py-3 text-center text-lg text-green-700">{{ number_format($moyenneSemestre1, 2) }}/20</td>
                        <td class="px-4 py-3"></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Notes Semestre 2 -->
        <div class="p-8">
            <div class="flex items-center mb-4">
                <span class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold mr-3">S2</span>
                <h3 class="text-xl font-bold text-gray-900">SEMESTRE 2</h3>
            </div>
            
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b-2 border-gray-200">
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Code</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Intitulé du Module</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Coeff.</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Note /20</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Appréciation</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($evaluationsSemestre2 as $eval)
                    <tr class="{{ $eval->note >= 10 ? 'bg-green-50' : 'bg-red-50' }}">
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded font-bold text-sm">{{ $eval->module->code }}</span>
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $eval->module->intitule }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($eval->module->coefficient, 2) }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="text-lg font-bold {{ $eval->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($eval->note, 2) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($eval->note >= 16) bg-green-100 text-green-800
                                @elseif($eval->note >= 14) bg-blue-100 text-blue-800
                                @elseif($eval->note >= 12) bg-yellow-100 text-yellow-800
                                @elseif($eval->note >= 10) bg-orange-100 text-orange-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $eval->getAppreciation() }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">Aucune évaluation pour le semestre 2</td>
                    </tr>
                    @endforelse
                    @if($moyenneSemestre2)
                    <tr class="bg-blue-100 font-bold">
                        <td colspan="3" class="px-4 py-3 text-right">MOYENNE SEMESTRE 2:</td>
                        <td class="px-4 py-3 text-center text-lg text-blue-700">{{ number_format($moyenneSemestre2, 2) }}/20</td>
                        <td class="px-4 py-3"></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Récapitulatif -->
        @if($moyenneSemestre1 && $moyenneSemestre2)
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-8 border-t-4 border-indigo-600">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg p-4 shadow">
                    <p class="text-sm text-gray-600 mb-1">Moyenne Semestre 1</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($moyenneSemestre1, 2) }}/20</p>
                </div>
                <div class="bg-white rounded-lg p-4 shadow">
                    <p class="text-sm text-gray-600 mb-1">Moyenne Semestre 2</p>
                    <p class="text-2xl font-bold text-blue-600">{{ number_format($moyenneSemestre2, 2) }}/20</p>
                </div>
                <div class="bg-white rounded-lg p-4 shadow">
                    <p class="text-sm text-gray-600 mb-1">Moyenne Annuelle</p>
                    <p class="text-2xl font-bold text-indigo-600">
                        {{ number_format(($moyenneSemestre1 + $moyenneSemestre2) / 2, 2) }}/20
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div class="p-8 bg-gray-50 text-center text-sm text-gray-600 border-t print:border-t-2 print:border-gray-300">
            <p class="mb-2">Date d'édition: {{ date('d/m/Y') }}</p>
            <p>Ce document est un relevé officiel des notes de l'étudiant(e)</p>
        </div>
    </div>
</div>

@push('scripts')
<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white;
    }
    
    #bulletin {
        box-shadow: none;
        border: 1px solid #000;
    }
    
    @page {
        margin: 1cm;
    }
}
</style>
@endpush
@endsection