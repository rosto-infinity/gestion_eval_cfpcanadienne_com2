@extends('layouts.app')

@section('title', 'Détail de la spécialité - ' . $specialite->code)

@section('content')
<div class="mb-6 flex justify-between items-center no-print">
    <div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('bilan.specialite.index') }}" class="text-blue-600 hover:text-blue-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">
                📋 {{ $specialite->code }} - {{ $specialite->intitule }}
            </h1>
        </div>
        <p class="mt-2 text-sm text-gray-700">
            Détail des évaluations et bilan des compétences par étudiant
        </p>
    </div>
    <div class="flex space-x-3">
        <button onclick="window.print()" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Imprimer
        </button>
        <a href="{{ route('bilan.specialite.export-detail-pdf', ['specialite' => $specialite->id] + request()->all()) }}" class="btn btn-success">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Exporter PDF
        </a>
    </div>
</div>

<!-- Statistiques de la spécialité -->
<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
    <div class="card bg-blue-50">
        <div class="card-body">
            <div class="text-center">
                <p class="text-sm font-medium text-gray-600">Total Étudiants</p>
                <p class="text-3xl font-bold text-blue-700">{{ $stats['total'] }}</p>
            </div>
        </div>
    </div>

    <div class="card bg-green-50">
        <div class="card-body">
            <div class="text-center">
                <p class="text-sm font-medium text-gray-600">Admis</p>
                <p class="text-3xl font-bold text-green-700">{{ $stats['admis'] }}</p>
            </div>
        </div>
    </div>

    <div class="card bg-red-50">
        <div class="card-body">
            <div class="text-center">
                <p class="text-sm font-medium text-gray-600">Non Admis</p>
                <p class="text-3xl font-bold text-red-700">{{ $stats['non_admis'] }}</p>
            </div>
        </div>
    </div>

    <div class="card bg-purple-50">
        <div class="card-body">
            <div class="text-center">
                <p class="text-sm font-medium text-gray-600">Taux d'Admission</p>
                <p class="text-3xl font-bold text-purple-700">{{ number_format($stats['taux_admission'], 1) }}%</p>
            </div>
        </div>
    </div>

    <div class="card bg-yellow-50">
        <div class="card-body">
            <div class="text-center">
                <p class="text-sm font-medium text-gray-600">Moy. Générale</p>
                <p class="text-3xl font-bold text-yellow-700">{{ number_format($stats['moy_generale'], 2) }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Filtre année -->
<div class="card mb-6 no-print">
    <div class="card-body">
        <form method="GET" action="{{ route('bilan.specialite.show', $specialite) }}" class="flex items-end space-x-4">
            <div class="flex-1">
                <label for="annee_id" class="block text-sm font-medium text-gray-700 mb-2">Année académique</label>
                <select name="annee_id" id="annee_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @foreach($annees as $annee)
                    <option value="{{ $annee->id }}" {{ request('annee_id', $anneeActive?->id) == $annee->id ? 'selected' : '' }}>
                        {{ $annee->libelle }} {{ $annee->is_active ? '⭐' : '' }}
                    </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filtrer
            </button>
        </form>
    </div>
</div>

<!-- Légende -->
<div class="card mb-6 no-print">
    <div class="card-body bg-blue-50">
        <div class="flex items-start">
            <svg class="h-5 w-5 text-blue-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div class="text-sm text-blue-800">
                <p class="font-semibold mb-2">💡 Information sur le calcul :</p>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Évaluations semestrielles (30%)</strong> : Moyenne des modules M1 à M10</li>
                    <li><strong>MOY/20 EVAL1</strong> = Moyenne des modules M1 à M5 (Semestre 1)</li>
                    <li><strong>MOY/20 EVAL2</strong> = Moyenne des modules M6 à M10 (Semestre 2)</li>
                    <li><strong>Bilan des compétences (70%)</strong> = Évaluation pratique des compétences</li>
                    <li><strong>MOY.GEN (100%)</strong> = [(MOY EVAL1 + MOY EVAL2) / 2 × 30%] + [Bilan compétences × 70%]</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Tableau principal -->
<div class="card">
    <div class="overflow-x-auto">
        @if($etudiants->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun étudiant</h3>
            <p class="mt-1 text-sm text-gray-500">Aucun étudiant inscrit dans cette spécialité.</p>
        </div>
        @else
        <table class="min-w-full divide-y divide-gray-300 border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th rowspan="2" class="px-3 py-2 text-center text-xs font-bold text-gray-700 uppercase border border-gray-300" style="min-width: 40px;">
                        N°
                    </th>
                    <th rowspan="2" class="px-3 py-2 text-left text-xs font-bold text-gray-700 uppercase border border-gray-300" style="min-width: 200px;">
                        Nom et prénoms<br/>
                        <span class="font-normal lowercase">names and first names</span>
                    </th>
                    <th colspan="7" class="px-3 py-2 text-center text-xs font-bold text-gray-700 uppercase border border-gray-300 bg-blue-50">
                        Évaluations semestrielles/semester évaluations (30%)
                    </th>
                    <th colspan="6" class="px-3 py-2 text-center text-xs font-bold text-gray-700 uppercase border border-gray-300 bg-green-50">
                        Semestre 2/semester 2
                    </th>
                    <th rowspan="2" class="px-3 py-2 text-center text-xs font-bold text-gray-700 uppercase border border-gray-300 bg-purple-50" style="min-width: 100px;">
                        MOY/20 Bilan des<br/>compétences<br/>(70%) skills<br/>assessment
                    </th>
                    <th rowspan="2" class="px-3 py-2 text-center text-xs font-bold text-gray-700 uppercase border border-gray-300 bg-red-50" style="min-width: 100px;">
                        MOY.GEN. (100%)<br/>
                        <span class="font-normal lowercase">en (rouge)</span>
                    </th>
                </tr>
                <tr>
                    <!-- Semestre 1 -->
                    <th class="px-2 py-2 text-center text-xs font-bold text-gray-700 uppercase border border-gray-300 bg-blue-50">
                        Semestre/<br/>semester 1
                    </th>
                    @for($i = 1; $i <= 5; $i++)
                    <th class="px-2 py-2 text-center text-xs font-bold text-gray-700 border border-gray-300 bg-blue-50">
                        M{{ $i }}
                    </th>
                    @endfor
                    <th class="px-2 py-2 text-center text-xs font-bold text-gray-700 uppercase border border-gray-300 bg-blue-100">
                        MOY/20<br/>EVAL1
                    </th>
                    
                    <!-- Semestre 2 -->
                    @for($i = 6; $i <= 10; $i++)
                    <th class="px-2 py-2 text-center text-xs font-bold text-gray-700 border border-gray-300 bg-green-50">
                        M{{ $i }}
                    </th>
                    @endfor
                    <th class="px-2 py-2 text-center text-xs font-bold text-gray-700 uppercase border border-gray-300 bg-green-100">
                        MOY/20<br/>EVAL2
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($etudiants as $index => $data)
                @php
                    $etudiant = $data->etudiant;
                    $evalS1 = $data->evaluations_s1->keyBy('module.code');
                    $evalS2 = $data->evaluations_s2->keyBy('module.code');
                @endphp
                <tr class="hover:bg-gray-50">
                    <!-- N° -->
                    <td class="px-3 py-3 text-center text-sm font-medium text-gray-900 border border-gray-300">
                        {{ $index + 1 }}
                    </td>
                    
                    <!-- Nom -->
                    <td class="px-3 py-3 text-sm font-medium text-gray-900 border border-gray-300">
                        <div class="flex items-center">
                            @if($etudiant->profile)
                            <img class="h-8 w-8 rounded-full object-cover mr-2 no-print" src="{{ Storage::url($etudiant->profile) }}" alt="{{ $etudiant->name }}">
                            @endif
                            <div>
                                {{ strtoupper($etudiant->name) }}
                                <div class="text-xs text-gray-500">{{ $etudiant->matricule }}</div>
                            </div>
                        </div>
                    </td>
                    
                    <!-- Semestre 1 - Label vide -->
                    <td class="px-2 py-3 text-center bg-blue-50 border border-gray-300"></td>
                    
                    <!-- Notes Semestre 1 (M1-M5) -->
                    @for($i = 1; $i <= 5; $i++)
                    @php
                        $eval = $evalS1->get("M{$i}");
                        $note = $eval?->note ?? null;
                    @endphp
                    <td class="px-2 py-3 text-center text-sm font-semibold border border-gray-300 {{ $note && $note >= 10 ? 'bg-green-50 text-green-700' : ($note ? 'bg-red-50 text-red-700' : 'bg-gray-50') }}">
                        {{ $note ? number_format($note, 0) : '-' }}
                    </td>
                    @endfor
                    
                    <!-- Moyenne Semestre 1 -->
                    <td class="px-2 py-3 text-center text-base font-bold border border-gray-300 {{ $data->moy_semestre1 >= 10 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $data->moy_semestre1 > 0 ? number_format($data->moy_semestre1, 2) : '-' }}
                    </td>
                    
                    <!-- Notes Semestre 2 (M6-M10) -->
                    @for($i = 6; $i <= 10; $i++)
                    @php
                        $eval = $evalS2->get("M{$i}");
                        $note = $eval?->note ?? null;
                    @endphp
                    <td class="px-2 py-3 text-center text-sm font-semibold border border-gray-300 {{ $note && $note >= 10 ? 'bg-green-50 text-green-700' : ($note ? 'bg-red-50 text-red-700' : 'bg-gray-50') }}">
                        {{ $note ? number_format($note, 0) : '-' }}
                    </td>
                    @endfor
                    
                    <!-- Moyenne Semestre 2 -->
                    <td class="px-2 py-3 text-center text-base font-bold border border-gray-300 {{ $data->moy_semestre2 >= 10 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $data->moy_semestre2 > 0 ? number_format($data->moy_semestre2, 2) : '-' }}
                    </td>
                    
                    <!-- Bilan des compétences (70%) -->
                    <td class="px-2 py-3 text-center text-base font-bold border border-gray-300 bg-purple-50 text-purple-700">
                        {{ $data->moy_competences > 0 ? number_format($data->moy_competences, 2) : '-' }}
                    </td>
                    
                    <!-- Moyenne Générale (100%) -->
                    <td class="px-2 py-3 text-center text-lg font-bold border border-gray-300 {{ $data->moyenne_generale >= 10 ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                        {{ $data->moyenne_generale > 0 ? number_format($data->moyenne_generale, 2) : '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        table {
            font-size: 7px;
        }
        th, td {
            padding: 3px 2px !important;
        }
        @page {
            size: landscape;
            margin: 0.5cm;
        }
        body {
            background: white;
        }
    }
</style>
@endpush