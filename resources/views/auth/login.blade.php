<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<x-guest-layout>
    <div class=" flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-950 p-4 sm:p-6">
        <div class="w-full max-w-md">
            <!-- Logo/Header -->
            <div class="text-center mb-8">
               
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Connectez-vous à votre compte
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Entrez vos identifiants pour accéder à votre tableau de bord
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('status')" />

            <!-- Formulaire de connexion -->
            <div class="bg-white dark:bg-[#161615] rounded-2xl border border-gray-200 dark:border-[#3E3E3A] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.05),0px_2px_8px_0px_rgba(0,0,0,0.05)] overflow-hidden">
                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-3">
                            <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 block" />
                            <x-text-input 
                                id="email" 
                                class="block w-full px-4 py-1 rounded-md border border-gray-300 dark:border-[#3E3E3A] bg-white dark:bg-[#1e1e1d] text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-200 shadow-sm"
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autofocus 
                                autocomplete="username"
                                placeholder="votre@email.com"
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500 dark:text-red-400" />
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <x-input-label for="password" :value="__('Mot de passe')" class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 block" />
                            <x-text-input 
                                id="password" 
                                class="block w-full px-4 py-1 rounded-md border border-gray-300 dark:border-[#3E3E3A] bg-white dark:bg-[#1e1e1d] text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-200 shadow-sm"
                                type="password"
                                name="password"
                                required 
                                autocomplete="current-password"
                                placeholder="••••••••"
                            />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500 dark:text-red-400" />
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-3">
                            <div class="flex items-center">
                                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input id="remember_me" type="checkbox" class="peer sr-only" name="remember">
                                        <div class="w-3 h-3 flex items-center justify-center rounded border border-gray-300 dark:border-[#3E3E3A] bg-white dark:bg-[#1e1e1d] peer-checked:border-primary peer-checked:bg-primary transition-all duration-200">
                                            <svg class="w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <span class="ms-2 text-[0.8rem] text-gray-700 dark:text-gray-300">{{ __('Se souvenir de moi') }}</span>
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <a class="text-[0.8rem] font-medium text-primary hover:text-primary/80 transition-colors duration-200" href="{{ route('password.request') }}">
                                    {{ __('Mot de passe oublié ?') }}
                                </a>
                            @endif
                        </div>

                         {{-- <!-- g-recaptcha -->
                        <div class="mb-4 ">
                            <x-input-label :value="__('Vérification de sécurité')"
                                class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-2 block" />

                            <div class="flex justify-center items-center">
                                <!-- Assurez-vous que la clé dans le .env est la même qu'ici -->
                                <div class="g-recaptcha"
                                    data-sitekey="{{ config('services.recaptcha.site_key')}}"> 
                                </div>
                            </div>

                            <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2 text-sm text-red-500 dark:text-red-400" />
                        </div> --}}
                        <!-- Submit Button & Register Link -->
                        <div class="space-y-4">
                            <x-primary-button class="w-full bg-primary hover:bg-primary/90 text-white font-medium py-1 px-4 rounded-md shadow-[0_2px_4px_0_rgba(121,23,249,0.25)] transition-all duration-200 flex items-center justify-center gap-2">
                                <span>{{ __('Se connecter') }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </x-primary-button>

                            {{-- <div class="text-center text-sm text-gray-600 dark:text-gray-400">
                                <span>{{ __("Vous n'avez pas de compte ?") }}</span>
                                <a href="{{ route('register') }}" class="font-medium text-primary hover:text-primary/80 ms-1 transition-colors duration-200">
                                    {{ __('Créez-en un gratuitement') }}
                                </a>
                            </div> --}}
                        </div>
                    </form>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
                <div class="flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Secure connection with SSL encryption</span>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>