<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
       <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="grid grid-cols-1 lg:grid-cols-2 min-h-screen">
        <!-- Colonne gauche - Logo et branding -->
        <div class="flex flex-col items-center justify-center bg-white dark:bg-gray-800 p-8 lg:p-12 border-r border-gray-200 dark:border-gray-700">
            <div class="max-w-md w-full text-center lg:text-left">
                <a href="/" class="inline-block mb-8">
                    <x-application-logo class="w-24 h-24 fill-current text-primary" /> 
                    <span class="text-primary text-center font-semibold text-lg">
                        Centre de Formation <br>Professionnelle  la Canadienne
                        </span>
                </a>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    Bienvenue sur notre plateforme
                </h1>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Connectez-vous pour accéder à votre tableau de bord et découvrir toutes les fonctionnalités de notre application.
                </p>
                
                <!-- Avantages ou informations supplémentaires -->
                <div class="mt-8 space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-gray-700 dark:text-gray-300">Interface intuitive et moderne</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-gray-700 dark:text-gray-300">Sécurité renforcée avec chiffrement SSL</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Colonne droite - Formulaire -->
        <div class="flex flex-col sm:justify-center items-center p-6 sm:p-8">
            <div class="w-full max-w-md  dark:bg-[#161615] rounded-2xl  dark:border-[#3E3E3A]  overflow-hidden">
                <div class="p-6 sm:p-8">
                    {{ $slot }}
                </div>
            </div>
            
            <!-- Informations supplémentaires en bas -->
            <div class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
                <div class="flex items-center justify-center gap-2">
                     
                </div>
            </div>
        </div>
    </div>
</div>
    </body>
</html>
