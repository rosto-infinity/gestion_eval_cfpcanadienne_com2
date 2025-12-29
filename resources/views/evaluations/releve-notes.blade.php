@extends('layouts.app')

@section('title', 'Relevé de notes')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">

        <!-- Actions -->
        <div class="mb-4 flex justify-between items-center">
            {{-- On n'affiche le bouton Retour que si l'utilisateur est au moins MANAGER --}}
            @if (auth()->user()->role->isAtLeast(\App\Enums\Role::MANAGER))
                <a href="{{ route('bilans.index') }}"
                    class="text-sm text-primary hover:text-primary/80 inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour
                </a>
            @else
                {{-- Optionnel : Un bouton retour vers le Dashboard pour l'étudiant --}}
                <a href="{{ route('dashboard') }}"
                    class="text-sm text-primary hover:text-primary/80 inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Tableau de bord
                </a>
            @endif
            <!-- Version finale et correcte -->
            <a href="{{ route('evaluations.releve-notes.pdf', $user) }}" target="_blank" class="inline-block">
                <button
                    class="text-sm px-3 py-1.5 bg-primary text-primary-foreground rounded hover:bg-primary/90 inline-flex items-center gap-1 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Export Pdf
                </button>
            </a>

            <button onclick="window.print()"
                class="text-sm px-3 py-1.5 bg-primary text-primary-foreground rounded hover:bg-primary/90 inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Imprimer
            </button>
        </div>

        <!-- Document -->
        <div class="bg-card border border-border rounded-lg p-6" id="releve-notes">

            <!-- En-tête -->
            <table border="0" cellspacing="0" cellpadding="0"
                style="width: 100%; border: 1px solid #ddd; font-family: sans-serif; font-size: 10px;">
                <!-- Première rangée : Colonnes de texte et logo -->
                <tr>
                    <!-- Colonne de gauche (Français) -->
                    <td style="width: 33%;line-height: 1; vertical-align: top; padding: 10px;text-align: center;">
                        <p style="font-weight: bold; text-decoration: underline; margin: 0 0 5px 0;">Ministère de l’emploi
                            et de la Formation Professionnelle</p>
                        <p style="font-size: 8px; color: #666; margin: 0 0 5px 0;">*************</p>
                        <p style="margin: 0 0 5px 0;">Centre de Formation Professionnelle la Canadienne</p>
                        <p style="font-size: 8px; color: #666; margin: 0 0 5px 0;">*************</p>
                        <p style="margin: 0;">B.P.: 837 Bafoussam</p>
                        <p style="margin: 0 0 5px 0;">Tel: +237 695 82 92 30 / 671 33 78 29</p>
                        <p style="font-size: 8px; color: #666; margin: 0 0 0 0;">*************</p>
                    </td>

                    <!-- Colonne centrale (Logo) -->
                    <td style="width: 33%; vertical-align: middle; text-align: center; padding: 10px;">
                        <!-- Remplacez ceci par votre balise image <img> -->
                        <div
                            style="width: 150px; height: 100px; background-color: #f0f0f0; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                            <img src="/android-chrome-192x192.png" alt="Logo CFPC"
                                style="max-width: 100%; max-height: 100%;">
                        </div>
                    </td>

                    <!-- Colonne de droite (Anglais) -->
                    <td style="width: 33%; vertical-align: top; text-align: right; padding: 10px; text-align: center;">
                        <p style="font-weight: bold; text-decoration: underline; margin: 0 0 5px 0;">Ministry of employment
                            and Vacational Training</p>
                        <p style="font-size: 8px; color: #666; margin: 0 0 5px 0;">*************</p>
                        <p style="margin: 0 0 5px 0;">Canadian Vocational Training center</p>
                        <p style="font-size: 8px; color: #666; margin: 0 0 5px 0;">*************</p>
                        <p style="margin: 0;">contact@cfpcanadienne.com</p>
                        <p style="margin: 0 0 0 0;">www.cfpcanadiennecom</p>
                        <p style="font-size: 8px; color: #666; margin: 0 0 0 0;">*************</p>
                    </td>
                </tr>

                <!-- Deuxième rangée : Ligne inférieure pleine largeur -->
                <tr>
                    <td colspan="3" style="border-top: 2px solid #000; text-align: center; padding-top: 5px;">
                        <p style="font-size: 9px; margin: 0;">
                            Créée et agréée, renouvelée par Arrêté ministériel N° 000355/MINEFOP/SG/DFOP/SDGSF/CSACD/CBAC
                        </p>
                    </td>
                </tr>
            </table>



            <!-- Infos Étudiant -->
            <div class="grid grid-cols-2 gap-4 mb-6 bg-muted/30 p-4 rounded">
                <div>
                    <p class="text-xs text-muted-foreground">Matricule</p>
                    <p class="font-semibold text-foreground">{{ $user->matricule }}</p>
                </div>
                <div>
                    <p class="text-xs text-muted-foreground">Nom et Prénom</p>
                    <p class="font-semibold text-foreground">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-muted-foreground">Spécialité</p>
                    <p class="font-semibold text-foreground">
                        {{ $user->specialite->intitule ?? 'Module non assigné'  }}
                        
                    </p>
                </div>
                <div>
                    <p class="text-xs text-muted-foreground">Code</p>
                    <p class="font-semibold text-foreground">{{ $user->specialite->code ?? 'Code non assigné'}}</p>
                </div>
            </div>

            <!-- Semestre 1 -->
            <div class="mb-6">
                <h2 class="text-lg font-bold text-foreground mb-3 bg-blue-100 dark:bg-blue-950/30 p-2.5 rounded">SEMESTRE 1
                </h2>

                @if ($evaluationsSemestre1->isEmpty())
                    <div class="text-center py-4 bg-muted/20 rounded text-sm text-muted-foreground">
                        Aucune note
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-border bg-muted/30">
                                    <th class="px-3 py-2 text-left font-semibold text-foreground">Code</th>
                                    <th class="px-3 py-2 text-left font-semibold text-foreground">Module</th>
                                    <th class="px-3 py-2 text-center font-semibold text-foreground">Coef</th>
                                    <th class="px-3 py-2 text-center font-semibold text-foreground">Note</th>
                                    <th class="px-3 py-2 text-left font-semibold text-foreground">Appréciation</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border">
                                @foreach ($evaluationsSemestre1 as $eval)
                                    <tr class="hover:bg-muted/20">
                                        <td class="px-3 py-2">
                                            <span class="text-xs font-bold px-2 py-0.5 rounded bg-blue-100 text-blue-700">
                                                {{ $eval->module->code }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 text-foreground">{{ $eval->module->intitule }}</td>
                                        <td class="px-3 py-2 text-center text-muted-foreground">
                                            {{ $eval->module->coefficient }}</td>
                                        <td
                                            class="px-3 py-2 text-center font-bold {{ $eval->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ number_format($eval->note, 2) }}
                                        </td>
                                        <td class="px-3 py-2">
                                            <span
                                                class="text-xs font-bold px-2 py-0.5 rounded {{ $eval->note >= 10 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $eval->getAppreciation() }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach

                                <!-- Moyenne S1 -->
                                <tr class="bg-blue-50 dark:bg-blue-950/20 font-bold">
                                    <td colspan="3" class="px-3 py-2 text-right text-foreground">Moyenne S1 :</td>
                                    <td
                                        class="px-3 py-2 text-center {{ $moyenneSemestre1 >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $moyenneSemestre1 ? number_format($moyenneSemestre1, 2) : '-' }}
                                    </td>
                                    <td class="px-3 py-2">
                                        @if ($moyenneSemestre1)
                                            <span
                                                class="text-xs font-bold px-2 py-0.5 rounded {{ $moyenneSemestre1 >= 10 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $moyenneSemestre1 >= 10 ? 'Admis' : 'Non admis' }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Semestre 2 -->
            <div class="mb-6">
                <h2 class="text-lg font-bold text-foreground mb-3 bg-green-100 dark:bg-green-950/30 p-2.5 rounded">SEMESTRE
                    2</h2>

                @if ($evaluationsSemestre2->isEmpty())
                    <div class="text-center py-4 bg-muted/20 rounded text-sm text-muted-foreground">
                        Aucune note
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-border bg-muted/30">
                                    <th class="px-3 py-2 text-left font-semibold text-foreground">Code</th>
                                    <th class="px-3 py-2 text-left font-semibold text-foreground">Module</th>
                                    <th class="px-3 py-2 text-center font-semibold text-foreground">Coef</th>
                                    <th class="px-3 py-2 text-center font-semibold text-foreground">Note</th>
                                    <th class="px-3 py-2 text-left font-semibold text-foreground">Appréciation</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border">
                                @foreach ($evaluationsSemestre2 as $eval)
                                    <tr class="hover:bg-muted/20">
                                        <td class="px-3 py-2">
                                            <span
                                                class="text-xs font-bold px-2 py-0.5 rounded bg-green-100 text-green-700">
                                                {{ $eval->module->code }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 text-foreground">{{ $eval->module->intitule }}</td>
                                        <td class="px-3 py-2 text-center text-muted-foreground">
                                            {{ $eval->module->coefficient }}</td>
                                        <td
                                            class="px-3 py-2 text-center font-bold {{ $eval->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ number_format($eval->note, 2) }}
                                        </td>
                                        <td class="px-3 py-2">
                                            <span
                                                class="text-xs font-bold px-2 py-0.5 rounded {{ $eval->note >= 10 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $eval->getAppreciation() }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach

                                <!-- Moyenne S2 -->
                                <tr class="bg-green-50 dark:bg-green-950/20 font-bold">
                                    <td colspan="3" class="px-3 py-2 text-right text-foreground">Moyenne S2 :</td>
                                    <td
                                        class="px-3 py-2 text-center {{ $moyenneSemestre2 >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $moyenneSemestre2 ? number_format($moyenneSemestre2, 2) : '-' }}
                                    </td>
                                    <td class="px-3 py-2">
                                        @if ($moyenneSemestre2)
                                            <span
                                                class="text-xs font-bold px-2 py-0.5 rounded {{ $moyenneSemestre2 >= 10 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $moyenneSemestre2 >= 10 ? 'Admis' : 'Non admis' }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Bilan Final -->
            @if ($user->bilanCompetence)
                <div class="border-t border-border pt-4">
                    <h2 class="text-lg font-bold text-foreground mb-3 bg-purple-100 dark:bg-purple-950/30 p-2.5 rounded">
                        BILAN FINAL</h2>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 bg-muted/20 p-4 rounded">
                        <div class="text-center">
                            <p class="text-xs text-muted-foreground mb-1">MOYENNE S1</p>
                            <p class="text-lg font-bold text-blue-600">
                                {{-- {{ number_format($user->bilanCompetence->moy_evaluations, 2) }} --}}
                                {{ $moyenneSemestre1 ? number_format($moyenneSemestre1, 2) : '-' }}
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-muted-foreground mb-1">MOYENNE S2</p>
                            <p class="text-lg font-bold text-purple-600">
                                {{-- {{ number_format($user->bilanCompetence->moy_competences, 2) }} --}}
                                {{ $moyenneSemestre2 ? number_format($moyenneSemestre2, 2) : '-' }}
                            </p>
                        </div>
                        <div class="text-center col-span-2">
                            <p class="text-xs text-muted-foreground mb-1">MOYENNE GÉNÉRALE</p>
                            <p
                                class="text-2xl font-bold {{ $user->bilanCompetence->moyenne_generale >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                {{-- {{ number_format($user->bilanCompetence->moyenne_generale, 2) }}/20 --}}
                                {{ number_format($moyenneGenerale ?? 0, 2) }}/20
                            </p>
                            <span
                                class="text-xs font-bold px-2 py-0.5 rounded inline-block mt-1 {{ $user->bilanCompetence->moyenne_generale >= 10 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $user->bilanCompetence->getMention() }}
                            </span>
                        </div>
                    </div>

                    @if ($user->bilanCompetence->observations)
                        <div class="mt-3 pt-3 border-t border-border">
                            <p class="text-xs font-semibold text-foreground mb-1">Observations :</p>
                            <p class="text-xs text-muted-foreground">{{ $user->bilanCompetence->observations }}</p>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Footer -->
            <div class="mt-6 pt-4 border-t border-border text-right text-xs text-muted-foreground">
                Généré le {{ now()->format('d/m/Y à H:i') }}
            </div>

        </div>

    </div>
@endsection
<style>
    @media print {

        .btn,
        nav,
        footer,
        a[href*="retour"],
        button {
            display: none !important;
        }

        #releve-notes {
            box-shadow: none;
            border: 1px solid #ccc;
        }

        body {
            padding: 0;
        }
    }
</style>
