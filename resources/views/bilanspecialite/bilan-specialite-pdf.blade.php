@extends('layouts.pdf')

@section('title', 'Bilan par Spécialité - ' . ($annee ? $annee->libelle : 'Toutes les années'))

@section('content')
<div class="w-full min-h-screen bg-white p-8">
    <!-- En-tête du document -->
    <div class="mb-8 text-center border-b-2 border-gray-200 pb-6">
        <div class="flex items-center justify-center mb-4">
            <div class="bg-blue-600 text-white w-12 h-12 rounded-full flex items-center justify-center font-bold text-xl">
                📊
            </div>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">BILAN DES PERFORMANCES ACADEMIQUES</h1>
        <h2 class="text-xl font-semibold text-blue-700 mb-1">PAR SPÉCIALITÉ</h2>
        @if($annee)
            <p class="text-lg text-gray-700 font-medium">{{ $annee->libelle }} {{ $annee->annee_debut }}/{{ $annee->annee_fin }}</p>
        @else
            <p class="text-lg text-gray-700 font-medium">Toutes les années académiques</p>
        @endif
        <p class="text-sm text-gray-500 mt-2">Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <!-- Statistiques globales -->
    <div class="mb-8">
        <h3 class="text-lg font-bold text-gray-900 mb-4 text-center">RÉSUMÉ DES STATISTIQUES GLOBALES</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="border rounded-lg p-4 bg-blue-50">
                <p class="text-sm font-medium text-blue-800 mb-1">SPÉCIALITÉS</p>
                <p class="text-2xl font-bold text-blue-900">{{ $statsGlobales['total_specialites'] }}</p>
            </div>
            <div class="border rounded-lg p-4 bg-green-50">
                <p class="text-sm font-medium text-green-800 mb-1">TOTAL ÉTUDIANTS</p>
                <p class="text-2xl font-bold text-green-900">{{ $statsGlobales['total_etudiants'] }}</p>
            </div>
            <div class="border rounded-lg p-4 bg-purple-50">
                <p class="text-sm font-medium text-purple-800 mb-1">TAUX D'ADMISSION</p>
                <p class="text-2xl font-bold text-purple-900">{{ number_format($statsGlobales['taux_admission'], 1) }}%</p>
            </div>
            <div class="border rounded-lg p-4 bg-yellow-50">
                <p class="text-sm font-medium text-yellow-800 mb-1">MOY. GÉNÉRALE</p>
                <p class="text-2xl font-bold text-yellow-900">{{ number_format($statsGlobales['moyenne_generale'], 2) }}/20</p>
            </div>
        </div>
    </div>

    <!-- Tableau principal -->
    @if($bilanParSpecialite->isEmpty())
        <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
            <p class="text-xl font-semibold text-gray-700 mb-2">Aucune donnée disponible</p>
            <p class="text-gray-600">Aucun bilan trouvé pour les paramètres sélectionnés.</p>
        </div>
    @else
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-4 text-center">DÉTAIL PAR SPÉCIALITÉ</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b-2 border-gray-300">
                            <th class="px-4 py-3 text-left text-sm font-bold text-gray-700 border-r border-gray-200">Spécialité</th>
                            <th class="px-4 py-3 text-center text-sm font-bold text-gray-700 border-r border-gray-200 bg-blue-50">Étudiants</th>
                            <th class="px-4 py-3 text-center text-sm font-bold text-gray-700 border-r border-gray-200 bg-blue-100">Moy. S1</th>
                            <th class="px-4 py-3 text-center text-sm font-bold text-gray-700 border-r border-gray-200 bg-green-50">Moy. S2</th>
                            <th class="px-4 py-3 text-center text-sm font-bold text-gray-700 border-r border-gray-200 bg-purple-50">Moy. Comp.</th>
                            <th class="px-4 py-3 text-center text-sm font-bold text-gray-700 border-r border-gray-200 bg-yellow-50">Moy. Gén.</th>
                            <th class="px-4 py-3 text-center text-sm font-bold text-gray-700 border-r border-gray-200 bg-green-100">Admis</th>
                            <th class="px-4 py-3 text-center text-sm font-bold text-gray-700 border-r border-gray-200 bg-red-100">Non Admis</th>
                            <th class="px-4 py-3 text-center text-sm font-bold text-gray-700 bg-gray-50">Taux Adm.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bilanParSpecialite as $bilan)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-gray-900">{{ $bilan->specialite->code }}</div>
                                    <div class="text-xs text-gray-600 mt-1">{{ Str::limit($bilan->specialite->intitule, 30) }}</div>
                                </td>
                                <td class="px-4 py-3 text-center bg-blue-50 font-medium text-blue-800">{{ $bilan->total_etudiants }}</td>
                                <td class="px-4 py-3 text-center bg-blue-100 font-medium {{ $bilan->moy_semestre1 >= 10 ? 'text-green-700' : 'text-red-700' }}">
                                    {{ number_format($bilan->moy_semestre1, 2) }}
                                </td>
                                <td class="px-4 py-3 text-center bg-green-50 font-medium {{ $bilan->moy_semestre2 >= 10 ? 'text-green-700' : 'text-red-700' }}">
                                    {{ number_format($bilan->moy_semestre2, 2) }}
                                </td>
                                <td class="px-4 py-3 text-center bg-purple-50 font-medium {{ $bilan->moy_competences >= 10 ? 'text-green-700' : 'text-red-700' }}">
                                    {{ number_format($bilan->moy_competences, 2) }}
                                </td>
                                <td class="px-4 py-3 text-center bg-yellow-50 font-bold text-lg {{ $bilan->moyenne_generale >= 10 ? 'text-green-700' : 'text-red-700' }}">
                                    {{ number_format($bilan->moyenne_generale, 2) }}
                                </td>
                                <td class="px-4 py-3 text-center bg-green-100 font-bold text-green-800">{{ $bilan->admis }}</td>
                                <td class="px-4 py-3 text-center bg-red-100 font-bold text-red-800">{{ $bilan->non_admis }}</td>
                                <td class="px-4 py-3 text-center bg-gray-50">
                                    <div class="font-medium {{ $bilan->taux_admission >= 50 ? 'text-green-700' : 'text-red-700' }}">
                                        {{ number_format($bilan->taux_admission, 1) }}%
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 border-t-2 border-gray-300">
                        <tr>
                            <td class="px-4 py-3 font-bold text-right" colspan="1">TOTAL</td>
                            <td class="px-4 py-3 text-center font-bold bg-blue-50">{{ $statsGlobales['total_etudiants'] }}</td>
                            <td class="px-4 py-3 text-center bg-blue-100"></td>
                            <td class="px-4 py-3 text-center bg-green-50"></td>
                            <td class="px-4 py-3 text-center bg-purple-50"></td>
                            <td class="px-4 py-3 text-center bg-yellow-50 font-bold">
                                {{ number_format($statsGlobales['moyenne_generale'], 2) }}/20
                            </td>
                            <td class="px-4 py-3 text-center bg-green-100 font-bold text-green-800">
                                {{ $statsGlobales['total_admis'] }}
                            </td>
                            <td class="px-4 py-3 text-center bg-red-100 font-bold text-red-800">
                                {{ $statsGlobales['total_non_admis'] }}
                            </td>
                            <td class="px-4 py-3 text-center bg-gray-50 font-bold">
                                {{ number_format($statsGlobales['taux_admission'], 1) }}%
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Résumé analytique -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-4 text-center">ANALYSE COMPARATIVE</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="border rounded-lg p-4">
                    <h4 class="font-bold text-gray-800 mb-3">🏆 MEILLEURES PERFORMANCES</h4>
                    <ul class="space-y-2">
                        @php
                            $topMoyennes = $bilanParSpecialite->sortByDesc('moyenne_generale')->take(3);
                            $topAdmission = $bilanParSpecialite->sortByDesc('taux_admission')->take(3);
                        @endphp
                        
                        @foreach($topMoyennes as $index => $bilan)
                            <li class="flex justify-between items-center border-b border-gray-100 pb-2 last:border-b-0">
                                <span class="font-medium text-blue-700">{{ $bilan->specialite->code }}</span>
                                <span class="font-bold text-green-700">{{ number_format($bilan->moyenne_generale, 2) }}/20</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="border rounded-lg p-4">
                    <h4 class="font-bold text-gray-800 mb-3">📈 TAUX D'ADMISSION</h4>
                    <ul class="space-y-2">
                        @foreach($topAdmission as $index => $bilan)
                            <li class="flex justify-between items-center border-b border-gray-100 pb-2 last:border-b-0">
                                <span class="font-medium text-purple-700">{{ $bilan->specialite->code }}</span>
                                <span class="font-bold {{ $bilan->taux_admission >= 80 ? 'text-green-700' : 'text-amber-700' }}">
                                    {{ number_format($bilan->taux_admission, 1) }}%
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Pied de page -->
    <div class="mt-8 pt-6 border-t-2 border-gray-200 text-center">
        <p class="text-sm text-gray-600 mb-2">
            Document confidentiel - Usage interne uniquement
        </p>
        <p class="text-xs text-gray-500">
            Généré par le système de gestion académique | Page {{ $page ?? 1 }}/{{ $totalPages ?? 1 }}
        </p>
    </div>
</div>
@endsection

@section('styles')
<style>
    @page {
        margin: 2cm;
        size: landscape;
    }
    
    body {
        font-family: 'DejaVu Sans', sans-serif;
        color: #333;
        line-height: 1.5;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
        font-size: 0.85rem;
    }
    
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    
    th {
        background-color: #f8fafc;
        font-weight: 600;
    }
    
    tr:hover {
        background-color: #f8fafc;
    }
    
    .bg-blue-50 { background-color: #eff6ff; }
    .bg-green-50 { background-color: #f0fdf4; }
    .bg-purple-50 { background-color: #f5f3ff; }
    .bg-yellow-50 { background-color: #fffbeb; }
    .bg-blue-100 { background-color: #dbeafe; }
    .bg-green-100 { background-color: #dcfce7; }
    .bg-red-100 { background-color: #fee2e2; }
    .bg-gray-50 { background-color: #f9fafb; }
    
    .text-green-700 { color: #166534; }
    .text-red-700 { color: #b91c1c; }
    .text-blue-700 { color: #1d4ed8; }
    .text-purple-700 { color: #7e22ce; }
    
    .border { border: 1px solid #e5e7eb; }
    .rounded-lg { border-radius: 0.5rem; }
    .p-4 { padding: 1rem; }
    .mb-4 { margin-bottom: 1rem; }
    .mb-6 { margin-bottom: 1.5rem; }
    .mb-8 { margin-bottom: 2rem; }
    .mt-8 { margin-top: 2rem; }
    .pt-6 { padding-top: 1.5rem; }
    
    .font-bold { font-weight: 700; }
    .font-semibold { font-weight: 600; }
    .font-medium { font-weight: 500; }
    
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    
    .w-full { width: 100%; }
    .min-h-screen { min-height: 100vh; }
    .p-8 { padding: 2rem; }
    
    @media print {
        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .no-print, .no-print * {
            display: none !important;
        }
    }
</style>
@endsection