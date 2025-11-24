@extends('layouts.app')

@section('title', 'Modifier une Spécialité')

@section('content')
<div class="min-h-screen" style="background-color: var(--background)">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- En-tête -->
        <div class="mb-8">
            <a 
                href="{{ route('specialites.index') }}" 
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg mb-6 transition-all duration-200 hover:shadow-md"
                style="color: var(--primary); background-color: var(--secondary)"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="font-medium">{{ __('Retour') }}</span>
            </a>

            <div>
                <h1 class="text-4xl font-bold mb-2" style="color: var(--foreground)">
                    {{ __('Modifier la Spécialité') }}
                </h1>
                <p class="text-sm" style="color: var(--muted-foreground)">
                    <span class="font-semibold" style="color: var(--primary)">{{ $specialite->code }}</span>
                    {{ __('•') }}
                    <span>{{ $specialite->intitule }}</span>
                </p>
            </div>
        </div>

        <!-- Contenu principal - 2 Colonnes -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Colonne de gauche - Formulaire Principal -->
            <div class="lg:col-span-2">
                <form 
                    action="{{ route('specialites.update', $specialite) }}" 
                    method="POST" 
                    class="rounded-xl border-2 overflow-hidden shadow-sm"
                    style="background-color: var(--card); border-color: var(--border)"
                >
                    @csrf
                    @method('PUT')

                    <div class="p-8 space-y-8">

                        <!-- Code -->
                        <div class="group">
                            <label 
                                for="code" 
                                class="block text-sm font-semibold mb-3 transition-colors"
                                style="color: var(--foreground)"
                            >
                                {{ __('Code') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="code" 
                                    id="code" 
                                    value="{{ old('code', $specialite->code) }}" 
                                    required
                                    class="w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:outline-none @error('code') ring-2 @enderror"
                                    style="background-color: var(--input); border-color: var(--border); color: var(--foreground); --tw-ring-color: var(--primary)"
                                    placeholder="Ex: INFO"
                                />
                                <svg 
                                    class="absolute right-3 top-3.5 w-5 h-5 opacity-0 group-focus-within:opacity-100 transition-opacity"
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24"
                                    style="color: var(--primary)"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>

                            @error('code')
                            <div class="mt-2 p-3 rounded-lg bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800">
                                <p class="text-sm flex items-center gap-2 text-red-600 dark:text-red-400">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            </div>
                            @enderror
                        </div>

                        <!-- Intitulé -->
                        <div class="group">
                            <label 
                                for="intitule" 
                                class="block text-sm font-semibold mb-3 transition-colors"
                                style="color: var(--foreground)"
                            >
                                {{ __('Intitulé') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="intitule" 
                                    id="intitule" 
                                    value="{{ old('intitule', $specialite->intitule) }}" 
                                    required
                                    class="w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:outline-none @error('intitule') ring-2 @enderror"
                                    style="background-color: var(--input); border-color: var(--border); color: var(--foreground); --tw-ring-color: var(--primary)"
                                    placeholder="Ex: Informatique"
                                />
                                <svg 
                                    class="absolute right-3 top-3.5 w-5 h-5 opacity-0 group-focus-within:opacity-100 transition-opacity"
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24"
                                    style="color: var(--primary)"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>

                            @error('intitule')
                            <div class="mt-2 p-3 rounded-lg bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800">
                                <p class="text-sm flex items-center gap-2 text-red-600 dark:text-red-400">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            </div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="group">
                            <label 
                                for="description" 
                                class="block text-sm font-semibold mb-3 transition-colors"
                                style="color: var(--foreground)"
                            >
                                {{ __('Description') }}
                            </label>
                            <div class="relative">
                                <textarea 
                                    name="description" 
                                    id="description" 
                                    rows="6"
                                    class="w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:outline-none resize-none @error('description') ring-2 @enderror"
                                    style="background-color: var(--input); border-color: var(--border); color: var(--foreground); --tw-ring-color: var(--primary)"
                                    placeholder="{{ __('Décrivez cette spécialité...') }}"
                                >{{ old('description', $specialite->description) }}</textarea>
                                
                                <div class="absolute bottom-3 right-3 text-xs font-medium px-2 py-1 rounded" style="background-color: var(--secondary); color: var(--muted-foreground)">
                                    <span id="char-count">{{ strlen(old('description', $specialite->description)) }}</span>/500
                                </div>
                            </div>

                            @error('description')
                            <div class="mt-2 p-3 rounded-lg bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800">
                                <p class="text-sm flex items-center gap-2 text-red-600 dark:text-red-400">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            </div>
                            @enderror
                        </div>

                    </div>

                    <!-- Actions -->
                    <div 
                        class="flex items-center justify-end gap-3 px-8 py-6 border-t-2"
                        style="background-color: var(--secondary); border-color: var(--border)"
                    >
                        <a 
                            href="{{ route('specialites.index') }}" 
                            class="px-6 py-2.5 rounded-lg font-semibold transition-all duration-200 hover:shadow-md active:scale-95"
                            style="background-color: var(--secondary); color: var(--foreground); border: 2px solid var(--border)"
                        >
                            {{ __('Annuler') }}
                        </a>

                        <button 
                            type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg font-semibold transition-all duration-200 hover:shadow-lg active:scale-95"
                            style="background-color: var(--primary); color: var(--primary-foreground)"
                            onmouseover="this.style.opacity='0.9'"
                            onmouseout="this.style.opacity='1'"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ __('Mettre à jour') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Colonne de droite - Informations & Aperçu -->
            <div class="lg:col-span-1 space-y-6">

             
                <!-- Informations de Gestion -->
                <div class="rounded-xl border-2 overflow-hidden shadow-sm" style="background-color: var(--card); border-color: var(--border)">
                    <div class="p-6">
                        <h3 class="text-lg font-bold mb-4 flex items-center gap-2" style="color: var(--foreground)">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--primary)">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('Gestion') }}
                        </h3>

                        <div class="space-y-4">
                            <div class="p-3 rounded-lg border-l-4" style="background-color: var(--secondary); border-color: var(--primary)">
                                <p class="text-xs font-medium mb-1" style="color: var(--muted-foreground)">
                                    {{ __('Créée le') }}
                                </p>
                                <p class="text-sm font-semibold" style="color: var(--foreground)">
                                    {{ $specialite->created_at->format('d/m/Y') }}
                                </p>
                                <p class="text-xs mt-1" style="color: var(--muted-foreground)">
                                    {{ $specialite->created_at->format('H:i') }}
                                </p>
                            </div>

                            <div class="p-3 rounded-lg border-l-4" style="background-color: var(--secondary); border-color: #10b981">
                                <p class="text-xs font-medium mb-1" style="color: var(--muted-foreground)">
                                    {{ __('Modifiée le') }}
                                </p>
                                <p class="text-sm font-semibold" style="color: var(--foreground)">
                                    {{ $specialite->updated_at->format('d/m/Y') }}
                                </p>
                                <p class="text-xs mt-1" style="color: var(--muted-foreground)">
                                    {{ $specialite->updated_at->format('H:i') }}
                                </p>
                            </div>

                            
                        </div>
                    </div>
                </div>

              

            </div>
        </div>

        <!-- Alerte de succès -->
        @if (session('status') === 'specialite-updated')
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:leave="transition ease-in duration-200"
            x-init="setTimeout(() => show = false, 4000)"
            class="mt-6 flex items-center gap-3 px-6 py-4 rounded-lg border-l-4 animate-in"
            style="background-color: var(--secondary); border-color: #10b981"
        >
            <svg class="w-5 h-5 flex-shrink-0 animate-bounce" fill="currentColor" viewBox="0 0 20 20" style="color: #10b981">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm font-medium" style="color: var(--foreground)">
                {{ __('✓ Spécialité mise à jour avec succès !') }}
            </p>
        </div>
        @endif

    </div>
</div>

<script>
    // Compteur de caractères
    const descriptionField = document.getElementById('description');
    const charCount = document.getElementById('char-count');

    if (descriptionField) {
        descriptionField.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });

        // Limiter à 500 caractères
        descriptionField.addEventListener('keypress', function(e) {
            if (this.value.length >= 500) {
                e.preventDefault();
            }
        });
    }
</script>

<style>
    /* Animations */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-in {
        animation: slideIn 0.3s ease-out;
    }

    /* Placeholder styling */
    input::placeholder,
    textarea::placeholder {
        opacity: 0.6;
    }

    /* Focus states */
    input:focus,
    textarea:focus {
        outline: none;
    }

    /* Line clamp */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
