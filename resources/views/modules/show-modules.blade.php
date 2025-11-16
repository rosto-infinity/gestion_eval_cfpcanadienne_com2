@extends('layouts.app')

@section('title', 'Détails du Module')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">
            {{ $module->intitule }}
        </h1>
        <p class="mt-2 text-sm text-gray-600">
            Détails du module d'enseignement
        </p>
    </div>

    <!-- Card -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden p-6 space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Code -->
            <div>
                <h3 class="text-sm font-medium text-gray-500">Code</h3>
                <p class="mt-1 text-lg text-gray-900 font-semibold">
                    {{ $module->code }}
                </p>
            </div>

            <!-- Ordre -->
            <div>
                <h3 class="text-sm font-medium text-gray-500">Ordre d'affichage</h3>
                <p class="mt-1 text-lg text-gray-900 font-semibold">
                    {{ $module->ordre }}
                </p>
            </div>
        </div>

        <!-- Intitulé -->
        <div>
            <h3 class="text-sm font-medium text-gray-500">Intitulé</h3>
            <p class="mt-1 text-lg text-gray-900 font-semibold">
                {{ $module->intitule }}
            </p>
        </div>

        <!-- Coefficient -->
        <div>
            <h3 class="text-sm font-medium text-gray-500">Coefficient</h3>
            <p class="mt-1 text-lg text-gray-900 font-semibold">
                {{ number_format($module->coefficient, 2) }}
            </p>
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-3 pt-4 border-t">
            <a href="{{ route('modules.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                Retour
            </a>

            <a href="{{ route('modules.edit', $module) }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Modifier
            </a>

            <form action="{{ route('modules.destroy', $module) }}" method="POST"
                  onsubmit="return confirm('Voulez-vous vraiment supprimer ce module ?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Supprimer
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
