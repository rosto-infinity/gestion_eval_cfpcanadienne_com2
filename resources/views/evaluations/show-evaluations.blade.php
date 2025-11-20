@extends('layouts.app')

@section('title', 'Détails de l\'Évaluation')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- En-tête avec navigation -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('evaluations.index') }}" class="text-indigo-600 hover:text-indigo-900 inline-flex items-center mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour aux évaluations
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Détails de l'Évaluation</h1>
            <p class="mt-2 text-sm text-gray-700">Consultation complète de l'évaluation</p>
        </div>
        
        <!-- Actions rapides -->
        <div class="flex flex-col space-y-2">
            <a href="{{ route('evaluations.edit', $evaluation) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Modifier
            </a>
            <form action="{{ route('evaluations.destroy', $evaluation) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Supprimer
                </button>
            </form>
        </div>
    </div>

    <!-- Cartes principales -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Carte Note -->
        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg shadow-lg p-6 border border-indigo-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-indigo-900 uppercase tracking-wide">Note Obtenue</h3>
                <svg class="w-8 h-8 text-indigo-300" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
            <div class="text-5xl font-bold {{ $evaluation->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                {{ number_format($evaluation->note, 2) }}
            </div>
            <div class="text-sm text-indigo-700 mt-2">/20</div>
            <div class="mt-4 pt-4 border-t border-indigo-200">
                <p class="text-xs text-indigo-600 uppercase tracking-wide mb-1">Statut</p>
                @if($evaluation->note >= 10)
                <span class="inline-block px-3 py-1 bg-green-200 text-green-800 text-xs font-bold rounded-full">
                    ✓ Validée
                </span>
                @else
                <span class="inline-block px-3 py-1 bg-red-200 text-red-800 text-xs font-bold rounded-full">
                    ✗ Non Validée
                </span>
                @endif
            </div>
        </div>

        <!-- Carte Appréciation -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow-lg p-6 border border-purple-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-purple-900 uppercase tracking-wide">Appréciation</h3>
                <svg class="w-8 h-8 text-purple-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18.868 3.884c.419-.419.419-1.098 0-1.517a1.075 1.075 0 00-1.52 0l-5.528 5.528-2.36-2.36a1.075 1.075 0 00-1.52 1.52l3.4 3.4a1.075 1.075 0 001.52 0l6.428-6.428z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="text-3xl font-bold text-purple-900 mb-3">
                {{ $evaluation->getAppreciation() }}
            </div>
            <div class="space-y-2">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-purple-700">Très Bien</span>
                    <span class="text-purple-500">≥ 16</span>
                </div>
                <div class="flex items-center justify-between text-xs">
                    <span class="text-purple-700">Bien</span>
                    <span class="text-purple-500">14-15</span>
                </div>
                <div class="flex items-center justify-between text-xs">
                    <span class="text-purple-700">Assez Bien</span>
                    <span class="text-purple-500">12-13</span>
                </div>
                <div class="flex items-center justify-between text-xs">
                    <span class="text-purple-700">Passable</span>
                    <span class="text-purple-500">10-11</span>
                </div>
                <div class="flex items-center justify-between text-xs">
                    <span class="text-purple-700">Insuffisant</span>
                    <span class="text-purple-500">&lt; 10</span>
                </div>
            </div>
        </div>

        <!-- Carte Semestre -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-lg p-6 border border-blue-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-blue-900 uppercase tracking-wide">Information</h3>
                <svg class="w-8 h-8 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-blue-600 uppercase tracking-wide mb-1">Semestre</p>
                    <span class="inline-block px-3 py-1 {{ $evaluation->semestre == 1 ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }} text-sm font-bold rounded-full">
                        Semestre {{ $evaluation->semestre }}
                    </span>
                </div>
                <div>
                    <p class="text-xs text-blue-600 uppercase tracking-wide mb-1">Année Académique</p>
                    <p class="text-sm font-semibold text-blue-900">{{ $evaluation->anneeAcademique->libelle }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Informations de l'Étudiant -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6 border-l-4 border-indigo-600">
        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Informations de l'Étudiant
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-600 uppercase tracking-wide font-semibold mb-1">Nom Complet</p>
                <p class="text-lg font-bold text-gray-900">{{ $evaluation->user->getFullName() }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-600 uppercase tracking-wide font-semibold mb-1">Matricule</p>
                <p class="text-lg font-bold text-gray-900">{{ $evaluation->user->matricule }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-600 uppercase tracking-wide font-semibold mb-1">Email</p>
                <p class="text-sm font-semibold text-indigo-600 truncate">{{ $evaluation->user->email }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-600 uppercase tracking-wide font-semibold mb-1">Spécialité</p>
                <p class="text-lg font-bold text-gray-900">
                    {{ $evaluation->user->specialite?->intitule ?? '-' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Informations du Module -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6 border-l-4 border-purple-600">
        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"/>
            </svg>
            Informations du Module
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-600 uppercase tracking-wide font-semibold mb-1">Code Module</p>
                <p class="text-lg font-bold text-gray-900">{{ $evaluation->module->code }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-600 uppercase tracking-wide font-semibold mb-1">Intitulé</p>
                <p class="text-sm font-semibold text-gray-900">{{ $evaluation->module->intitule }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-600 uppercase tracking-wide font-semibold mb-1">Crédits</p>
                <p class="text-lg font-bold text-gray-900">{{ $evaluation->module->credit }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-600 uppercase tracking-wide font-semibold mb-1">Coefficient</p>
                <p class="text-lg font-bold text-gray-900">{{ $evaluation->module->coefficient ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Analyse de la Note -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Analyse de la Note
        </h2>

        <!-- Barre de progression -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-semibold text-gray-700">Progression</span>
                <span class="text-sm font-bold {{ $evaluation->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format(($evaluation->note / 20) * 100, 1) }}%
                </span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                <div class="h-full {{ $evaluation->note >= 10 ? 'bg-green-500' : 'bg-red-500' }} rounded-full transition-all duration-300" 
                     style="width: {{ ($evaluation->note / 20) * 100 }}%"></div>
            </div>
        </div>

        <!-- Comparaison avec les seuils -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="p-4 bg-red-50 rounded-lg border border-red-200">
                <p class="text-xs text-red-600 uppercase tracking-wide font-semibold mb-2">Insuffisant</p>
                <p class="text-2xl font-bold text-red-600">&lt; 10</p>
                <p class="text-xs text-red-500 mt-1">
                    @if($evaluation->note < 10)
                    ✓ Votre note
                    @else
                    Écart: +{{ number_format($evaluation->note - 10, 2) }}
                    @endif
                </p>
            </div>
            <div class="p-4 bg-orange-50 rounded-lg border border-orange-200">
                <p class="text-xs text-orange-600 uppercase tracking-wide font-semibold mb-2">Passable</p>
                <p class="text-2xl font-bold text-orange-600">10-11</p>
                <p class="text-xs text-orange-500 mt-1">
                    @if($evaluation->note >= 10 && $evaluation->note < 12)
                    ✓ Votre note
                    @elseif($evaluation->note < 10)
                    Écart: +{{ number_format(10 - $evaluation->note, 2) }}
                    @else
                    Écart: +{{ number_format($evaluation->note - 11, 2) }}
                    @endif
                </p>
            </div>
            <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                <p class="text-xs text-yellow-600 uppercase tracking-wide font-semibold mb-2">Assez Bien</p>
                <p class="text-2xl font-bold text-yellow-600">12-13</p>
                <p class="text-xs text-yellow-500 mt-1">
                    @if($evaluation->note >= 12 && $evaluation->note < 14)
                    ✓ Votre note
                    @elseif($evaluation->note < 12)
                    Écart: +{{ number_format(12 - $evaluation->note, 2) }}
                    @else
                    Écart: +{{ number_format($evaluation->note - 13, 2) }}
                    @endif
                </p>
            </div>
            <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                <p class="text-xs text-green-600 uppercase tracking-wide font-semibold mb-2">Bien/Très Bien</p>
                <p class="text-2xl font-bold text-green-600">≥ 14</p>
                <p class="text-xs text-green-500 mt-1">
                    @if($evaluation->note >= 14)
                    ✓ Votre note
                    @else
                    Écart: +{{ number_format(14 - $evaluation->note, 2) }}
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Informations Temporelles -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Historique
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                <p class="text-xs text-blue-600 uppercase tracking-wide font-semibold mb-1">Créée le</p>
                <p class="text-lg font-bold text-gray-900">{{ $evaluation->created_at->format('d/m/Y') }}</p>
                <p class="text-sm text-gray-600">à {{ $evaluation->created_at->format('H:i:s') }}</p>
            </div>
            <div class="p-4 bg-purple-50 rounded-lg border border-purple-200">
                <p class="text-xs text-purple-600 uppercase tracking-wide font-semibold mb-1">Dernière modification</p>
                <p class="text-lg font-bold text-gray-900">{{ $evaluation->updated_at->format('d/m/Y') }}</p>
                <p class="text-sm text-gray-600">à {{ $evaluation->updated_at->format('H:i:s') }}</p>
            </div>
        </div>
    </div>

    <!-- Résumé Complet -->
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg shadow-md p-6 mb-6 border border-indigo-200">
        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Résumé Complet
        </h2>
        <div class="space-y-3 text-sm">
            <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                <span class="text-gray-700">Étudiant:</span>
                <span class="font-semibold text-gray-900">{{ $evaluation->user->getFullName() }} ({{ $evaluation->user->matricule }})</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                <span class="text-gray-700">Module:</span>
                <span class="font-semibold text-gray-900">{{ $evaluation->module->code }} - {{ $evaluation->module->intitule }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                <span class="text-gray-700">Note:</span>
                <span class="font-semibold {{ $evaluation->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format($evaluation->note, 2) }}/20
                </span>
            </div>
            <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                <span class="text-gray-700">Appréciation:</span>
                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                    @if($evaluation->note >= 16) bg-green-100 text-green-800
                    @elseif($evaluation->note >= 14) bg-green-100 text-green-800
                    @elseif($evaluation->note >= 12) bg-yellow-100 text-yellow-800
                    @elseif($evaluation->note >= 10) bg-orange-100 text-orange-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ $evaluation->getAppreciation() }}
                </span>
            </div>
            <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                <span class="text-gray-700">Semestre:</span>
                <span class="font-semibold text-gray-900">Semestre {{ $evaluation->semestre }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                <span class="text-gray-700">Année Académique:</span>
                <span class="font-semibold text-gray-900">{{ $evaluation->anneeAcademique->libelle }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                <span class="text-gray-700">Statut:</span>
                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $evaluation->note >= 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $evaluation->note >= 10 ? '✓ Validée' : '✗ Non Validée' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Boutons d'action -->
    <div class="flex items-center justify-between pt-6 border-t border-gray-200 bg-white rounded-lg p-6 shadow-md">
        <a href="{{ route('evaluations.index') }}" class="inline-flex items-center px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Retour à la liste
        </a>

        <div class="flex space-x-3">
            <a href="{{ route('evaluations.edit', $evaluation) }}" class="inline-flex items-center px-6 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Modifier
            </a>

            <a href="{{ route('evaluations.releveNotes', $evaluation->user) }}" class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Relevé de Notes
            </a>

            <form action="{{ route('evaluations.destroy', $evaluation) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Supprimer
                </button>
            </form>
        </div>
    </div>

    <!-- Aide -->
    <div class="mt-6 bg-blue-50 rounded-lg p-4 border border-blue-200">
        <h3 class="text-sm font-semibold text-blue-900 mb-2">💡 Informations</h3>
        <ul class="text-sm text-blue-800 space-y-1">
            <li>• Cette page affiche tous les détails de l'évaluation</li>
            <li>• Vous pouvez modifier la note en cliquant sur le bouton "Modifier"</li>
            <li>• Consultez le relevé de notes complet de l'étudiant</li>
            <li>• Les modifications sont enregistrées automatiquement</li>
        </ul>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation d'entrée
    const cards = document.querySelectorAll('.bg-gradient-to-br, .bg-white');
    cards.forEach((card, index) => {
        card.style.animation = `fadeInUp 0.5s ease-out ${index * 0.05}s both`;
    });

    // Animation de la barre de progression
    const progressBar = document.querySelector('[style*="width"]');
    if (progressBar) {
        progressBar.style.animation = 'slideIn 1s ease-out';
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

    @keyframes slideIn {
        from {
            width: 0 !important;
        }
        to {
            width: var(--width) !important;
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush
