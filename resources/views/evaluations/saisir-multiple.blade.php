@extends('layouts.app')

@section('title', 'Saisie Multiple des Évaluations')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Saisie Multiple des Évaluations</h1>
        <p class="mt-2 text-sm text-gray-700">Saisir toutes les notes d'un semestre pour un étudiant</p>
    </div>

    <!-- Sélection étudiant et semestre -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" action="{{ route('evaluations.saisir-multiple') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Sélectionner un étudiant <span class="text-red-500">*</span>
                    </label>
                    <select name="user_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()">
                        <option value="">Choisir un étudiant...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->matricule }} - {{ $user->getFullName() }} 
                                {{-- ({{ $user->specialite->code }} - {{ $user->anneeAcademique->libelle }}) --}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Semestre <span class="text-red-500">*</span>
                    </label>
                    <select name="semestre" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()">
                        <option value="1" {{ $semestre == 1 ? 'selected' : '' }}>Semestre 1</option>
                        <option value="2" {{ $semestre == 2 ? 'selected' : '' }}>Semestre 2</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    @if($user && $modules->isNotEmpty())
    <!-- Informations étudiant -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow p-6 mb-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">{{ $user->getFullName() }}</h2>
                <p class="mt-1 text-indigo-100">
                    Matricule: {{ $user->matricule }} | 
                    Spécialité: {{ $user->specialite->intitule }} | 
                    Année: {{ $user->anneeAcademique->libelle }}
                </p>
            </div>
            <div class="text-right">
                <span class="px-4 py-2 bg-white text-indigo-600 rounded-full font-bold text-lg">
                    Semestre {{ $semestre }}
                </span>
            </div>
        </div>
    </div>

    <!-- Formulaire de saisie -->
    <form action="{{ route('evaluations.store-multiple') }}" method="POST" class="bg-white rounded-lg shadow overflow-hidden">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <input type="hidden" name="semestre" value="{{ $semestre }}">

        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">
                Notes des Modules - Semestre {{ $semestre }}
            </h3>

            <div class="space-y-4">
                @foreach($modules as $module)
                    @php
                        $evaluation = $evaluations->get($module->id);
                    @endphp
                    <div class="flex items-center p-4 border rounded-lg {{ $evaluation ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                        <div class="flex-1">
                            <div class="flex items-center">
                                <span class="px-3 py-1 bg-{{ $semestre == 1 ? 'green' : 'blue' }}-100 text-{{ $semestre == 1 ? 'green' : 'blue' }}-800 rounded-full text-sm font-bold mr-3">
                                    {{ $module->code }}
                                </span>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $module->intitule }}</p>
                                    <p class="text-sm text-gray-500">Coefficient: {{ number_format($module->coefficient, 2) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="ml-4 w-32">
                            <input type="hidden" name="evaluations[{{ $loop->index }}][module_id]" value="{{ $module->id }}">
                            <div class="relative">
                                <input 
                                    type="number" 
                                    name="evaluations[{{ $loop->index }}][note]" 
                                    value="{{ old('evaluations.'.$loop->index.'.note', $evaluation?->note) }}"
                                    min="0" 
                                    max="20" 
                                    step="0.01"
                                    required
                                    class="w-full px-3 py-2 border rounded-md text-center text-lg font-bold focus:border-indigo-500 focus:ring-indigo-500 @error('evaluations.'.$loop->index.'.note') border-red-500 @enderror"
                                    placeholder="0.00">
                                <span class="absolute right-2 top-2 text-gray-500 text-sm">/20</span>
                            </div>
                            @error('evaluations.'.$loop->index.'.note')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @if($evaluation)
                            <div class="ml-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Saisi
                                </span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Boutons -->
        <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t">
            <div class="text-sm text-gray-600">
                @if($evaluations->isNotEmpty())
                    <span class="font-medium text-green-600">{{ $evaluations->count() }} note(s) déjà saisie(s)</span>
                @else
                    <span class="text-gray-500">Aucune note saisie pour ce semestre</span>
                @endif
            </div>
            <div class="space-x-3">
                <a href="{{ route('evaluations.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                    💾 Enregistrer les Notes
                </button>
            </div>
        </div>
    </form>

    <!-- Aperçu des statistiques -->
    @if($evaluations->isNotEmpty())
    <div class="mt-6 bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Statistiques Actuelles</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-50 rounded-lg p-4">
                <p class="text-sm text-gray-600">Notes Saisies</p>
                <p class="text-2xl font-bold text-blue-600">{{ $evaluations->count() }}/{{ $modules->count() }}</p>
            </div>
            <div class="bg-green-50 rounded-lg p-4">
                <p class="text-sm text-gray-600">Moyenne Semestre</p>
                <p class="text-2xl font-bold text-green-600">{{ number_format($evaluations->avg('note'), 2) }}/20</p>
            </div>
            <div class="bg-purple-50 rounded-lg p-4">
                <p class="text-sm text-gray-600">Meilleure Note</p>
                <p class="text-2xl font-bold text-purple-600">{{ number_format($evaluations->max('note'), 2) }}/20</p>
            </div>
        </div>
    </div>
    @endif

    @elseif($user && $modules->isEmpty())
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">Aucun module trouvé pour le semestre {{ $semestre }}. Veuillez d'abord créer les modules.</p>
            </div>
        </div>
    </div>
    @else
    <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Sélectionner un étudiant</h3>
        <p class="mt-1 text-sm text-gray-500">Choisissez un étudiant et un semestre pour commencer la saisie</p>
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-calcul de la moyenne
    const noteInputs = document.querySelectorAll('input[type="number"][name*="note"]');
    
    noteInputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.value < 0) this.value = 0;
            if (this.value > 20) this.value = 20;
        });
    });
});
</script>
@endpush
@endsection