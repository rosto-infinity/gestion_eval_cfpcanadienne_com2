<section>
    <header class="mb-6">
        <h2 class="text-2xl font-bold" style="color: var(--foreground)">
            {{ __('Mettre à Jour le Mot de Passe') }}
        </h2>

        <p class="mt-2 text-sm" style="color: var(--muted-foreground)">
            {{ __('Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Conteneur des champs -->
        <div class="space-y-6">
            <!-- Mot de passe actuel -->
            <div class="group">
                <label for="update_password_current_password" class="block text-sm font-semibold mb-2 transition-colors" style="color: var(--foreground)">
                    {{ __('Mot de Passe Actuel') }}
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        id="update_password_current_password" 
                        name="current_password" 
                        type="password" 
                        class="w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:outline-none @error('current_password', 'updatePassword') ring-2 @enderror"
                        style="background-color: var(--input); border-color: var(--border); color: var(--foreground); --tw-ring-color: var(--primary)"
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                    <button 
                        type="button"
                        onclick="togglePasswordVisibility('update_password_current_password')"
                        class="absolute right-3 top-3.5 text-gray-500 hover:text-gray-700 transition-colors"
                        style="color: var(--muted-foreground)"
                        tabindex="-1"
                    >
                        <svg id="icon-update_password_current_password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
                @error('current_password', 'updatePassword')
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

            <!-- Nouveau mot de passe -->
            <div class="group">
                <label for="update_password_password" class="block text-sm font-semibold mb-2 transition-colors" style="color: var(--foreground)">
                    {{ __('Nouveau Mot de Passe') }}
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        id="update_password_password" 
                        name="password" 
                        type="password" 
                        class="w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:outline-none @error('password', 'updatePassword') ring-2 @enderror"
                        style="background-color: var(--input); border-color: var(--border); color: var(--foreground); --tw-ring-color: var(--primary)"
                        autocomplete="new-password"
                        placeholder="••••••••"
                    />
                    <button 
                        type="button"
                        onclick="togglePasswordVisibility('update_password_password')"
                        class="absolute right-3 top-3.5 text-gray-500 hover:text-gray-700 transition-colors"
                        style="color: var(--muted-foreground)"
                        tabindex="-1"
                    >
                        <svg id="icon-update_password_password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Indicateur de force du mot de passe -->
                <div class="mt-3 space-y-2">
                    <div class="flex gap-1">
                        <div id="strength-1" class="flex-1 h-1 rounded-full transition-all duration-300" style="background-color: var(--border)"></div>
                        <div id="strength-2" class="flex-1 h-1 rounded-full transition-all duration-300" style="background-color: var(--border)"></div>
                        <div id="strength-3" class="flex-1 h-1 rounded-full transition-all duration-300" style="background-color: var(--border)"></div>
                        <div id="strength-4" class="flex-1 h-1 rounded-full transition-all duration-300" style="background-color: var(--border)"></div>
                    </div>
                    <p id="strength-text" class="text-xs font-medium" style="color: var(--muted-foreground)">
                        {{ __('Entrez un mot de passe') }}
                    </p>
                </div>

                @error('password', 'updatePassword')
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

            <!-- Confirmation mot de passe -->
            <div class="group">
                <label for="update_password_password_confirmation" class="block text-sm font-semibold mb-2 transition-colors" style="color: var(--foreground)">
                    {{ __('Confirmer le Mot de Passe') }}
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        id="update_password_password_confirmation" 
                        name="password_confirmation" 
                        type="password" 
                        class="w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:outline-none @error('password_confirmation', 'updatePassword') ring-2 @enderror"
                        style="background-color: var(--input); border-color: var(--border); color: var(--foreground); --tw-ring-color: var(--primary)"
                        autocomplete="new-password"
                        placeholder="••••••••"
                    />
                    <button 
                        type="button"
                        onclick="togglePasswordVisibility('update_password_password_confirmation')"
                        class="absolute right-3 top-3.5 text-gray-500 hover:text-gray-700 transition-colors"
                        style="color: var(--muted-foreground)"
                        tabindex="-1"
                    >
                        <svg id="icon-update_password_password_confirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Indicateur de correspondance -->
                <div id="match-indicator" class="mt-2 hidden">
                    <p class="text-sm flex items-center gap-2 font-medium">
                        <svg id="match-icon" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span id="match-text">{{ __('Les mots de passe correspondent') }}</span>
                    </p>
                </div>

                @error('password_confirmation', 'updatePassword')
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
        </div>

        <!-- Conseils de sécurité -->
        <div class="p-4 rounded-lg border-l-4" style="background-color: var(--secondary); border-color: var(--primary)">
            <div class="flex gap-3">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--primary)">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-semibold" style="color: var(--foreground)">
                        {{ __('Conseils pour un mot de passe sécurisé') }}
                    </h3>
                    <ul class="mt-2 text-xs space-y-1" style="color: var(--muted-foreground)">
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full" style="background-color: var(--primary)"></span>
                            {{ __('Au moins 8 caractères') }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full" style="background-color: var(--primary)"></span>
                            {{ __('Mélanger majuscules, minuscules et chiffres') }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full" style="background-color: var(--primary)"></span>
                            {{ __('Inclure des caractères spéciaux (!@#$%^&*)') }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full" style="background-color: var(--primary)"></span>
                            {{ __('Éviter les informations personnelles') }}
                        </li>
                    </ul>
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
                {{ __('Mettre à Jour le Mot de Passe') }}
            </button>

            @if (session('status') === 'password-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:leave="transition ease-in duration-200"
                    x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg"
                    style="background-color: var(--secondary)"
                >
                    <svg class="w-5 h-5 animate-bounce" fill="currentColor" viewBox="0 0 20 20" style="color: #10b981">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-sm font-medium" style="color: var(--foreground)">
                        {{ __('✓ Mot de passe mis à jour avec succès !') }}
                    </p>
                </div>
            @endif
        </div>
    </form>
</section>

<!-- Scripts pour la gestion des mots de passe -->
<script>
    // Toggle visibilité du mot de passe
    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById('icon-' + fieldId);
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>';
        } else {
            field.type = 'password';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
        }
    }

    // Indicateur de force du mot de passe
    document.getElementById('update_password_password').addEventListener('input', function() {
        const password = this.value;
        const strength = calculatePasswordStrength(password);
        updatePasswordStrengthIndicator(strength);
    });

    function calculatePasswordStrength(password) {
        let strength = 0;
        
        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        if (/\d/.test(password)) strength++;
        if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) strength++;
        
        return Math.min(strength, 4);
    }

    function updatePasswordStrengthIndicator(strength) {
        const strengthText = document.getElementById('strength-text');
        const colors = ['#ef4444', '#f97316', '#eab308', '#10b981'];
        const texts = [
            '{{ __("Mot de passe faible") }}',
            '{{ __("Mot de passe moyen") }}',
            '{{ __("Mot de passe bon") }}',
            '{{ __("Mot de passe très sécurisé") }}'
        ];

        for (let i = 1; i <= 4; i++) {
            const element = document.getElementById('strength-' + i);
            if (i <= strength) {
                element.style.backgroundColor = colors[strength - 1];
            } else {
                element.style.backgroundColor = 'var(--border)';
            }
        }

        if (strength > 0) {
            strengthText.textContent = texts[strength - 1];
            strengthText.style.color = colors[strength - 1];
        }
    }

    // Vérification de correspondance des mots de passe
    const passwordField = document.getElementById('update_password_password');
    const confirmField = document.getElementById('update_password_password_confirmation');
    const matchIndicator = document.getElementById('match-indicator');
    const matchIcon = document.getElementById('match-icon');
    const matchText = document.getElementById('match-text');

    function checkPasswordMatch() {
        if (confirmField.value && passwordField.value) {
            if (passwordField.value === confirmField.value) {
                matchIndicator.classList.remove('hidden');
                matchIcon.style.color = '#10b981';
                matchText.textContent = '{{ __("Les mots de passe correspondent") }}';
                matchText.style.color = '#10b981';
            } else {
                matchIndicator.classList.remove('hidden');
                matchIcon.style.color = '#ef4444';
                matchIcon.innerHTML = '<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>';
                matchText.textContent = '{{ __("Les mots de passe ne correspondent pas") }}';
                matchText.style.color = '#ef4444';
            }
        } else {
            matchIndicator.classList.add('hidden');
        }
    }

    passwordField.addEventListener('input', checkPasswordMatch);
    confirmField.addEventListener('input', checkPasswordMatch);
</script>
