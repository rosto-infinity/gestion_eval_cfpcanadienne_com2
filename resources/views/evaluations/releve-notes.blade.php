<x-app-layout title="Relevé de notes">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <!-- Actions -->
        <div class="mb-4 flex justify-between items-center no-print">
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
                <a href="{{ route('dashboard') }}"
                    class="text-sm text-primary hover:text-primary/80 inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Tableau de bord
                </a>
            @endif

            <div class="flex gap-2">
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
        </div>

        <!-- Document (Design Identique au PDF) -->
        <div class="bg-white border border-gray-200 shadow-md p-8 id-releve-notes" id="releve-notes">

            <style>
                /* --- STYLES DU PDF PORTÉS POUR LE WEB --- */
                #releve-notes {
                    font-family: 'Helvetica', 'Arial', sans-serif;
                    font-size: 9px;
                    color: #333;
                    line-height: 1.2;
                }

                /* --- COLORS --- */
                #releve-notes .text-red {
                    color: #D32F2F;
                }

                #releve-notes .bg-red-light {
                    background-color: #FEE2E2;
                }

                #releve-notes .border-red {
                    border-color: #D32F2F;
                }

                /* --- LAYOUT --- */
                #releve-notes .header-table {
                    width: 100%;
                    border-bottom: 2px solid #D32F2F;
                    margin-bottom: 10px;
                    padding-bottom: 5px;
                }

                #releve-notes .header-text {
                    text-align: center;
                    font-size: 8px;
                    line-height: 1.1;
                }

                /* --- INFO CARD --- */
                #releve-notes .info-card {
                    border: 1px solid #E5E7EB;
                    border-left: 4px solid #D32F2F;
                    width: 100%;
                    padding: 6px 10px;
                    background-color: #F9FAFB;
                    margin-bottom: 10px;
                    border-radius: 4px;
                }

                #releve-notes .info-table {
                    width: 100%;
                }

                #releve-notes .info-label {
                    font-weight: bold;
                    color: #6B7280;
                    width: 100px;
                }

                #releve-notes .info-value {
                    font-weight: bold;
                    color: #111827;
                }

                /* --- SECTION TITLES --- */
                #releve-notes .section-title {
                    color: #D32F2F;
                    font-size: 10px;
                    font-weight: bold;
                    text-transform: uppercase;
                    border-bottom: 1px solid #D32F2F;
                    padding-bottom: 2px;
                    margin: 10px 0 5px 0;
                    letter-spacing: 0.5px;
                }

                /* --- GRADES TABLE --- */
                #releve-notes table.grades-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 8px;
                }

                #releve-notes table.grades-table th {
                    text-align: left;
                    padding: 5px 6px;
                    font-size: 8px;
                    font-weight: bold;
                    text-transform: uppercase;
                    color: #FFFFFF;
                    background-color: #000000;
                    border-bottom: 1px solid #000;
                }

                #releve-notes table.grades-table td {
                    padding: 4px 6px;
                    border-bottom: 1px solid #E5E7EB;
                    font-size: 9px;
                }

                #releve-notes .row-total {
                    background-color: #FFF1F2;
                    font-weight: bold;
                    border-top: 1px solid #FECACA;
                }

                #releve-notes .row-total td {
                    color: #D32F2F;
                }

                /* --- SUMMARY TABLE --- */
                #releve-notes .summary-container {
                    width: 60%;
                    margin-top: 10px;
                    border: 1px solid #E5E7EB;
                    border-radius: 6px;
                    overflow: hidden;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
                }

                #releve-notes .summary-table {
                    width: 100%;
                    border-collapse: collapse;
                }

                #releve-notes .summary-table th {
                    background-color: #D32F2F;
                    color: #fff;
                    padding: 6px;
                    font-size: 8px;
                    text-transform: uppercase;
                }

                #releve-notes .summary-table td {
                    text-align: center;
                    padding: 6px;
                    font-size: 10px;
                    font-weight: bold;
                    border-right: 1px solid #E5E7EB;
                }

                #releve-notes .summary-table td:last-child {
                    border-right: none;
                }

                #releve-notes .decision-pass {
                    color: #16A34A;
                }

                #releve-notes .decision-fail {
                    color: #DC2626;
                }

                /* --- UTILS --- */
                .text-right {
                    text-align: right;
                }

                .text-center {
                    text-align: center;
                }

                .font-bold {
                    font-weight: bold;
                }

                /* --- PRINT --- */
                @media print {

                    .no-print,
                    nav,
                    header,
                    footer,
                    aside {
                        display: none !important;
                    }

                    body,
                    #releve-notes {
                        padding: 0;
                        margin: 0;
                        box-shadow: none;
                        border: none;
                        background: white;
                        width: 100%;
                    }

                    .max-w-5xl {
                        max-width: none;
                        padding: 0;
                        margin: 0;
                    }
                }
            </style>

            <!-- ENTÊTE -->
            <table class="header-table">
                <tr>
                    <!-- Ministère (Français) -->
                    <td width="38%" class="header-text" style="vertical-align: top; text-align: center;">
                        <div class="text-red font-bold" style="font-size: 8px;">REPUBLIQUE DU CAMEROUN</div>
                        <div style="font-size: 7px; font-style: italic;">Paix - Travail - Patrie</div>
                        <div style="border-top: 1px dotted #D32F2F; margin: 3px 0;"></div>
                        <div class="font-bold" style="font-size: 8px; line-height: 1.1;">Ministère de l’Emploi et de la Formation Professionnelle</div>
                        <div style="border-top: 1px dotted #D32F2F; margin: 3px 0;"></div>
                        <div class="text-red font-bold" style="font-size: 8px; text-transform: uppercase; line-height: 1.1;">Centre de Formation Professionnelle la Canadienne</div>
                        <div style="border-top: 1px dotted #D32F2F; margin: 3px 0;"></div>
                        <div style="font-size: 8px; font-weight: bold;">B.P.: 837 Bafoussam</div>
                        <div style="font-size: 8px; font-weight: bold;">Tél: +237 695 82 92 30 / 671 33 78 29</div>
                    </td>

                    <!-- Logo -->
                    <td width="24%" class="text-center" style="vertical-align: middle; padding: 0 5px;">
                        <img src="{{ asset('android-chrome-512x512.png') }}"
                            style="height: 50px; width: auto; margin: 0 auto; display:block;">
                    </td>

                    <!-- Anglais -->
                    <td width="38%" class="header-text" style="vertical-align: top; text-align: center;">
                        <div class="text-red font-bold" style="font-size: 8px;">REPUBLIC OF CAMEROON</div>
                        <div style="font-size: 7px; font-style: italic;">Peace - Work - Fatherland</div>
                        <div style="border-top: 1px dotted #D32F2F; margin: 3px 0;"></div>
                        <div class="font-bold" style="font-size: 8px; line-height: 1.1;">Ministry of Employment and Vocational Training</div>
                        <div style="border-top: 1px dotted #D32F2F; margin: 3px 0;"></div>
                        <div class="text-red font-bold" style="font-size: 8px; text-transform: uppercase; line-height: 1.1;">Canadian Vocational Training Center</div>
                        <div style="border-top: 1px dotted #D32F2F; margin: 3px 0;"></div>
                        <div style="font-size: 8px; font-weight: bold;">contact@cfpcanadienne.com</div>
                        <div style="font-size: 8px; font-weight: bold;">www.cfpcanadienne.com</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center" style="font-size: 8px; color: #333; padding-top: 5px; font-weight: bold; line-height: 1.1;">
                        <div style="border-top: 1px dotted #D32F2F; margin: 4px 0;"></div>
                        <em>Créé, agréé et renouvelé par Arrêté Ministériel N° 000355/MINEFOP/SG/DFOP/SDGSF/CSACD/CBAC</em>
                    </td>
                </tr>
            </table>

            <div class="text-center" style="margin-bottom: 8px;">
                <h1
                    style="color: #D32F2F; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; margin: 0; border-bottom: 1px solid #D32F2F; display: inline-block; padding-bottom: 2px;">
                    Relevé de Notes
                </h1>
            </div>

            <!-- INFORMATION ÉTUDIANT -->
            <div class="info-card">
                <table class="info-table">
                    <tr>
                        <td width="50%" style="vertical-align: top;">
                            <table style="width: 100%;">
                                <tr>
                                    <td class="info-label">MATRICULE</td>
                                    <td class="info-value">: {{ $user->matricule ?: \App\Models\User::generateMatricule($user->name) }}</td>
                                </tr>
                                <tr>
                                    <td class="info-label">NOM & PRÉNOM</td>
                                    <td class="info-value" style="text-transform: uppercase;">: {{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="info-label">NÉ(E) LE</td>
                                    <td class="info-value">
                                        :
                                        {{ $user->date_naissance ? \Carbon\Carbon::parse($user->date_naissance)->format('d/m/Y') : '-' }}
                                        @if ($user->lieu_naissance)
                                            à {{ $user->lieu_naissance }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="info-label">SEXE</td>
                                    <td class="info-value">:
                                        {{ $user->sexe === 'M' ? 'Masculin' : ($user->sexe === 'F' ? 'Féminin' : 'Autre') }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%" style="vertical-align: top;">
                            <table style="width: 100%;">
                                <tr>
                                    <td class="info-label">NIVEAU</td>
                                    <td class="info-value">: {{ $user->niveau ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="info-label">SPÉCIALITÉ</td>
                                    <td class="info-value" style="text-transform: uppercase;">:
                                        {{ $user->specialite->intitule ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="info-label">ANNÉE</td>
                                    <td class="info-value">: {{ $user->anneeAcademique->libelle ?? '-' }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- SEMESTRE 1 -->
            @if ($evaluationsSemestre1->isNotEmpty())
                <div class="section-title">Semestre 1</div>
                <table class="grades-table">
                    <thead>
                        <tr>
                            <th width="12%">CODE</th>
                            <th width="48%">MODULE</th>
                            <th width="10%" class="text-center">COEF.</th>
                            <th width="10%" class="text-center">NOTE/20</th>
                            <th width="20%" class="text-center">APPRÉCIATION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($evaluationsSemestre1 as $evaluation)
                            @php
                                $note = $evaluation->note ?? 0;
                                if ($note >= 16) {
                                    $appreciation = 'Très Bien';
                                } elseif ($note >= 14) {
                                    $appreciation = 'Bien';
                                } elseif ($note >= 12) {
                                    $appreciation = 'Assez Bien';
                                } elseif ($note >= 10) {
                                    $appreciation = 'Passable';
                                } else {
                                    $appreciation = 'Insuffisant';
                                }
                            @endphp
                            <tr>
                                <td class="font-bold text-red" style="font-size: 8px;">
                                    {{ $evaluation->module->code ?? '-' }}</td>
                                <td>{{ $evaluation->module->intitule ?? '-' }}</td>
                                <td class="text-center">{{ $evaluation->module->coefficient ?? 1 }}</td>
                                <td class="text-center font-bold">{{ number_format($note, 2) }}</td>
                                <td class="text-center" style="font-size: 8px; font-style: italic;">{{ $appreciation }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="row-total">
                            <td colspan="2" class="text-right">MOYENNE SEMESTRIELLE</td>
                            <td class="text-center">-</td>
                            <td class="text-center" style="font-size: 11px;">
                                {{ number_format($moyenneSemestre1 ?? 0, 2) }}</td>
                            <td class="text-center" style="font-size: 9px;">
                                {{ ($moyenneSemestre1 ?? 0) >= 10 ? 'VALIDÉ' : 'NON VALIDÉ' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif

            <!-- SEMESTRE 2 -->
            @if ($evaluationsSemestre2->isNotEmpty())
                <div class="section-title">Semestre 2</div>
                <table class="grades-table">
                    <thead>
                        <tr>
                            <th width="12%">CODE</th>
                            <th width="48%">MODULE</th>
                            <th width="10%" class="text-center">COEF.</th>
                            <th width="10%" class="text-center">NOTE/20</th>
                            <th width="20%" class="text-center">APPRÉCIATION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($evaluationsSemestre2 as $evaluation)
                            @php
                                $note = $evaluation->note ?? 0;
                                if ($note >= 16) {
                                    $appreciation = 'Très Bien';
                                } elseif ($note >= 14) {
                                    $appreciation = 'Bien';
                                } elseif ($note >= 12) {
                                    $appreciation = 'Assez Bien';
                                } elseif ($note >= 10) {
                                    $appreciation = 'Passable';
                                } else {
                                    $appreciation = 'Insuffisant';
                                }
                            @endphp
                            <tr>
                                <td class="font-bold text-red" style="font-size: 8px;">
                                    {{ $evaluation->module->code ?? '-' }}</td>
                                <td>{{ $evaluation->module->intitule ?? '-' }}</td>
                                <td class="text-center">{{ $evaluation->module->coefficient ?? 1 }}</td>
                                <td class="text-center font-bold">{{ number_format($note, 2) }}</td>
                                <td class="text-center" style="font-size: 8px; font-style: italic;">{{ $appreciation }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="row-total">
                            <td colspan="2" class="text-right">MOYENNE SEMESTRIELLE</td>
                            <td class="text-center">-</td>
                            <td class="text-center" style="font-size: 11px;">
                                {{ number_format($moyenneSemestre2 ?? 0, 2) }}</td>
                            <td class="text-center" style="font-size: 9px;">
                                {{ ($moyenneSemestre2 ?? 0) >= 10 ? 'VALIDÉ' : 'NON VALIDÉ' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif

            <!-- RÉSUMÉ & DÉCISION -->
            @if ($evaluationsSemestre1->isNotEmpty() || $evaluationsSemestre2->isNotEmpty())
                <div class="section-title">RÉSULTAT FINAL</div>
                <div class="summary-container">
                    <table class="summary-table">
                        <thead>
                            <tr>
                                <th>Moy. S1</th>
                                <th>Moy. S2</th>
                                <th>Moyenne Générale</th>
                                <th>Décision du Jury</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ number_format($moyenneSemestre1 ?? 0, 2) }}</td>
                                <td>{{ number_format($moyenneSemestre2 ?? 0, 2) }}</td>
                                <td class="text-red"
                                    style="font-size: 12px; border-left: 2px solid #E5E7EB; border-right: 2px solid #E5E7EB;">
                                    {{ number_format($moyenneGenerale ?? 0, 2) }}</td>
                                <td class="{{ ($moyenneGenerale ?? 0) >= 10 ? 'decision-pass' : 'decision-fail' }}">
                                    {{ ($moyenneGenerale ?? 0) >= 10 ? 'ADMIS' : 'NON ADMIS' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- PIED DE PAGE / SIGNATURE -->
            <div class="signature-section">
                <div class="signature-box">
                    <div style="font-style: italic; font-size: 10px; margin-bottom: 5px;">
                        Fait à Bafoussam, le {{ now()->format('d/m/Y') }}
                    </div>
                    <div class="font-bold text-red"
                        style="margin-bottom: 40px; text-transform: uppercase; font-size: 10px;">
                        La Directrice
                    </div>
                    <!-- Espace pour tampon/signature -->
                    <div style="height: 50px;"></div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
