@extends('layouts.app')

@section('title', 'Erreur Serveur - 500')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo et Titre -->
        <div class="text-center">
            <div class="mx-auto h-24 w-24 flex items-center justify-center rounded-full bg-red-100 dark:bg-red-900/20 mb-6">
                <svg class="h-12 w-12 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">500</h1>
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-300 mb-4">Erreur Interne du Serveur</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-8">
                Une erreur inattendue s'est produite. Nos équipes ont été notifiées.
            </p>
        </div>

        <!-- Actions -->
        <div class="space-y-4">
            <a href="{{ route('dashboard') }}" 
               class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1 1v10a1 1 0 001 1h3m-6 0h6" />
                </svg>
                Retour au Tableau de Bord
            </a>

            <div class="text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Si le problème persiste, 
                    <a href="mailto:support@cfpcanadienne.com" class="font-medium text-red-600 dark:text-red-400 hover:underline">
                        contactez immédiatement le support
                    </a>
                </p>
            </div>
        </div>

        <!-- Informations Additionnelles -->
        <div class="mt-8 p-4 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
            <h3 class="text-sm font-semibold text-red-900 dark:text-red-300 mb-2">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.314 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                Détails de l'Erreur
            </h3>
            <div class="text-xs text-red-800 dark:text-red-200 space-y-1">
                <p><strong>Code:</strong> 500 - Erreur Interne</p>
                <p><strong>Timestamp:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
                <p><strong>Référence:</strong> ERR-{{ strtoupper(substr(md5(now()->timestamp), 0, 8)) }}</p>
                <p><strong>Utilisateur:</strong> {{ auth()->user()->name ?? 'Non connecté' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<!-- Footer pour la page 500 -->
<footer class="bg-gray-800 dark:bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Logo et Description -->
            <div class="col-span-1">
                <div class="flex items-center mb-4">
                    <div class="shrink-0">
                        <svg class="h-8 w-8 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                        </svg>
                    </div>
                    <span class="ml-2 text-xl font-bold">CFPC</span>
                </div>
                <p class="text-gray-300 text-sm">
                    Système de gestion des évaluations pour le Collège Fédéral des Professionnels du Canada.
                </p>
            </div>

            <!-- Liens Rapides -->
            <div class="col-span-1">
                <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase mb-4">
                    Liens Rapides
                </h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white text-sm transition-colors">
                            Tableau de Bord
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">
                            Documentation
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">
                            Support Technique
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact et Support -->
            <div class="col-span-1">
                <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase mb-4">
                    Support
                </h3>
                <ul class="space-y-2">
                    <li class="flex items-center">
                        <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="text-gray-300 text-sm">support@cfpcanadienne.com</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="text-gray-300 text-sm">1-800-CFPC-HELP</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-gray-300 text-sm">Lun-Ven: 9h-17h EST</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-8 border-t border-gray-700 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-300 text-sm">
                    &copy; {{ date('Y') }} Collège Fédéral des Professionnels du Canada. Tous droits réservés.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">
                        Politique de Confidentialité
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">
                        Conditions d'Utilisation
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">
                        Accessibilité
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
@endsection
