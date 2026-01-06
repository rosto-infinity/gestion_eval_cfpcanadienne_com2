@extends('layouts.app')

@section('title', 'Page Expirée - 419')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo et Titre -->
        <div class="text-center">
            <div class="mx-auto h-24 w-24 flex items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900/20 mb-6">
                <svg class="h-12 w-12 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">419</h1>
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-300 mb-4">Page Expirée</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-8">
                Votre session a expiré. Veuillez rafraîchir la page et réessayer.
            </p>
        </div>

        <!-- Actions -->
        <div class="space-y-4">
            <a href="{{ route('login') }}" 
               class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Retour à la Connexion
            </a>

            <div class="text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Pour des raisons de sécurité, 
                    <strong>les formulaires expirent après un certain temps</strong>.
                </p>
            </div>
        </div>

        <!-- Informations Additionnelles -->
        <div class="mt-8 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
            <h3 class="text-sm font-semibold text-yellow-900 dark:text-yellow-300 mb-2">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Informations de Sécurité
            </h3>
            <div class="text-xs text-yellow-800 dark:text-yellow-200 space-y-1">
                <p><strong>Code:</strong> 419 - Page Expirée</p>
                <p><strong>Cause:</strong> Token CSRF invalide ou expiré</p>
                <p><strong>Action:</strong> Rechargez la page</p>
                <p><strong>Timestamp:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<!-- Footer pour la page 419 -->
<footer class="bg-gray-800 dark:bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Logo et Description -->
            <div class="col-span-1">
                <div class="flex items-center mb-4">
                    <div class="shrink-0">
                        <svg class="h-8 w-8 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
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
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white text-sm transition-colors">
                            Connexion
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
