<section>
    <header class="mb-6">
        <h2 class="text-2xl font-bold" style="color: var(--foreground)">
            {{ __('Informations du Profil') }}
        </h2>

        <p class="mt-2 text-sm" style="color: var(--muted-foreground)">
            {{ __("Mettez à jour les informations de votre profil et votre adresse email.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Conteneur des champs -->
        <div class="space-y-6">
            <!-- Nom -->
            <div class="group">
                <label for="name" class="block text-sm font-semibold mb-2 transition-colors" style="color: var(--foreground)">
                    {{ __('Nom Complet') }}
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        id="name" 
                        name="name" 
                        type="text" 
                        value="{{ old('name', $user->name ?? '') }}"
                        class="w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:outline-none @error('name') ring-2 @enderror"
                        style="background-color: var(--input); border-color: var(--border); color: var(--foreground); --tw-ring-color: var(--primary)"
                        required 
                        autofocus 
                        autocomplete="name"
                        placeholder="Ex: Jean Dupont"
                    />
                    <svg class="absolute right-3 top-3.5 w-5 h-5 opacity-0 group-focus-within:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--primary)">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                
                <!-- Affichage de la valeur actuelle -->
                @if($user->name)
                    <p class="mt-1 text-xs" style="color: var(--muted-foreground)">
                        {{ __('Valeur actuelle') }}: <span class="font-semibold" style="color: var(--foreground)">{{ $user->name }}</span>
                    </p>
                @endif

                @error('name')
                    <div class="mt-2 p-3 rounded-lg bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800">
                        <p class="text-sm flex items-center gap-2" style="color: var(--destructive)">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    </div>
                @enderror
            </div>

            <!-- Email -->
            <div class="group">
                <label for="email" class="block text-sm font-semibold mb-2 transition-colors" style="color: var(--foreground)">
                    {{ __('Adresse Email') }}
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        value="{{ old('email', $user->email ?? '') }}"
                        class="w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:outline-none @error('email') ring-2 @enderror"
                        style="background-color: var(--input); border-color: var(--border); color: var(--foreground); --tw-ring-color: var(--primary)"
                        required 
                        autocomplete="email"
                        placeholder="votre.email@exemple.com"
                    />
                    <svg class="absolute right-3 top-3.5 w-5 h-5 opacity-0 group-focus-within:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--primary)">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>

                <!-- Affichage de la valeur actuelle -->
                @if($user->email)
                    <div class="mt-2 flex items-center gap-2">
                        <p class="text-xs" style="color: var(--muted-foreground)">
                            {{ __('Valeur actuelle') }}: 
                        </p>
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium" style="background-color: var(--secondary); color: var(--foreground)">
                            {{ $user->email }}
                            @if($user->hasVerifiedEmail())
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" style="color: #10b981">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </span>
                    </div>
                @endif

                @error('email')
                    <div class="mt-2 p-3 rounded-lg bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800">
                        <p class="text-sm flex items-center gap-2" style="color: var(--destructive)">
                            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    </div>
                @enderror

                <!-- Alerte Vérification Email -->
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-4 p-4 rounded-lg border-l-4 animate-in fade-in slide-in-from-top-2" style="background-color: var(--secondary); border-color: var(--primary)">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 mt-0.5 flex-shrink-0 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--primary)">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v2M6.25 6.25h11.5M6.25 6.25L3 3m0 0v11.5m0 0L6.25 11.5M17.75 6.25L21 3m0 0v11.5m0 0l-3.25-3.25"></path>
                            </svg>
                            <div class="flex-1">
                                <h3 class="text-sm font-semibold" style="color: var(--foreground)">
                                    {{ __('Email non vérifiée') }}
                                </h3>
                                <p class="text-sm mt-1" style="color: var(--muted-foreground)">
                                    {{ __('Votre adresse email n\'est pas encore vérifiée.') }}
                                </p>
                                <button 
                                    form="send-verification" 
                                    type="button"
                                    class="mt-3 text-sm font-semibold underline transition-all hover:opacity-75 active:scale-95"
                                    style="color: var(--primary)"
                                >
                                    {{ __('→ Renvoyer l\'email de vérification') }}
                                </button>

                                @if (session('status') === 'verification-link-sent')
                                    <div class="mt-3 p-3 rounded-lg bg-green-50 dark:bg-green-950 border border-green-200 dark:border-green-800">
                                        <p class="text-sm font-medium flex items-center gap-2" style="color: #10b981">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ __('Un nouveau lien a été envoyé à votre email.') }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && $user->hasVerifiedEmail())
                    <div class="mt-4 p-4 rounded-lg border-l-4" style="background-color: var(--secondary); border-color: #10b981">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" style="color: #10b981">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold" style="color: var(--foreground)">
                                    {{ __('Email vérifiée') }}
                                </h3>
                                <p class="text-sm mt-1" style="color: var(--muted-foreground)">
                                    {{ __('Votre adresse email a été vérifiée le') }} 
                                    <span class="font-semibold" style="color: var(--foreground)">
                                        {{ $user->email_verified_at?->format('d/m/Y à H:i') }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Informations supplémentaires (optionnel) -->
            @if($user->phone || $user->address || $user->city)
                <div class="p-4 rounded-lg border-2" style="background-color: var(--secondary); border-color: var(--border)">
                    <h3 class="text-sm font-semibold mb-3" style="color: var(--foreground)">
                        {{ __('Autres Informations') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @if($user->phone)
                            <div>
                                <p class="text-xs" style="color: var(--muted-foreground)">{{ __('Téléphone') }}</p>
                                <p class="text-sm font-medium" style="color: var(--foreground)">{{ $user->phone }}</p>
                            </div>
                        @endif
                        @if($user->address)
                            <div>
                                <p class="text-xs" style="color: var(--muted-foreground)">{{ __('Adresse') }}</p>
                                <p class="text-sm font-medium" style="color: var(--foreground)">{{ $user->address }}</p>
                            </div>
                        @endif
                        @if($user->city)
                            <div>
                                <p class="text-xs" style="color: var(--muted-foreground)">{{ __('Ville') }}</p>
                                <p class="text-sm font-medium" style="color: var(--foreground)">{{ $user->city }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Informations de compte -->
            <div class="p-4 rounded-lg border-2" style="background-color: var(--secondary); border-color: var(--border)">
                <h3 class="text-sm font-semibold mb-3" style="color: var(--foreground)">
                    {{ __('Informations de Compte') }}
                </h3>
                <div class="space-y-2 text-xs" style="color: var(--muted-foreground)">
                    <div class="flex justify-between">
                        <span>{{ __('Compte créé le') }}:</span>
                        <span class="font-semibold" style="color: var(--foreground)">
                            {{ $user->created_at->format('d/m/Y à H:i') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span>{{ __('Dernière mise à jour') }}:</span>
                        <span class="font-semibold" style="color: var(--foreground)">
                            {{ $user->updated_at->format('d/m/Y à H:i') }}
                        </span>
                    </div>
                    @if($user->last_login_at)
                        <div class="flex justify-between">
                            <span>{{ __('Dernière connexion') }}:</span>
                            <span class="font-semibold" style="color: var(--foreground)">
                                {{ $user->last_login_at->format('d/m/Y à H:i') }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-4 pt-6 border-t" style="border-color: var(--border)">
            <button 
                type="submit"
                class="px-6 py-3 rounded-lg font-semibold transition-all duration-200 hover:shadow-lg active:scale-95 flex items-center gap-2"
                style="background-color: var(--primary); color: var(--primary-foreground)"
                onmouseover="this.style.opacity='0.9'"
                onmouseout="this.style.opacity='1'"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ __('Enregistrer les modifications') }}
            </button>

            <button 
                type="reset"
                class="px-6 py-3 rounded-lg font-semibold transition-all duration-200 hover:shadow-md active:scale-95 flex items-center gap-2"
                style="background-color: var(--secondary); color: var(--foreground); border: 2px solid var(--border)"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                {{ __('Réinitialiser') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:leave="transition ease-in duration-200"
                    x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg ml-auto"
                    style="background-color: var(--secondary)"
                >
                    <svg class="w-5 h-5 animate-bounce" fill="currentColor" viewBox="0 0 20 20" style="color: #10b981">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-sm font-medium" style="color: var(--foreground)">
                        {{ __('✓ Profil mis à jour avec succès !') }}
                    </p>
                </div>
            @endif
        </div>
    </form>
</section>
