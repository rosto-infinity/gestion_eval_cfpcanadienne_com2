<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Relevé de Notes - {{ $user->matricule }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #1f2937;
        }


        .container {
            width: 100%;
            padding: 8px 25px;
        }

        /* ============ EN-TÊTE ============ */



        /* ============ INFORMATIONS ÉTUDIANT ============ */
        .info-section {
            width: 95%;
            background: #f8f9fa;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
        }

        .info-grid {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .info-row {
            display: table-row;
        }

        .info-cell {
            display: table-cell;
            padding: 6px;
            width: 50%;
            vertical-align: top;
        }

        .info-label {
            font-size: 8px;
            color: #6b7280;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 10px;
            font-weight: bold;
            color: #1f2937;
        }

        .badge-code {
            display: inline-block;
            background: #dbeafe;
            color: #1e40af;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }

        /* ============ SECTION TITRE ============ */
        .section-title {
            color: #FF0000;
            font-size: 11px;
            font-weight: bold;
        }

        .section-title.general {
            color: #000;
        }

        /* ============ TABLEAU ============ */
        table {
            width: 95%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 9px;
        }

        thead {
            background: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
        }

        th {
            padding: 8px 5px;
            text-align: center;
            font-size: 8px;
            font-weight: bold;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.2px;
            border-right: 1px solid #e5e7eb;
        }

        th:last-child {
            border-right: none;
           
        }

        th.left {
            text-align: left;
        }

        td {
            padding: 7px 5px;
            border-bottom: 1px solid #f3f4f6;
            border-right: 1px solid #f3f4f6;
        }

        td:last-child {
            border-right: none;
        }

        td.center {
            text-align: center;
        }

        /* ============ COULEURS DES NOTES ============ */
        .note-excellent {
            background: #d4edda;
        }

        .note-good {
            background: #cfe2ff;
        }

        .note-average {
            background: #fff3cd;
        }

        .note-poor {
            background: #f8d7da;
        }

        .row-total {
            background: #e9ecef;
            font-weight: bold;
        }

        /* ============ SECTION RÉSUMÉ ============ */
        .recap-section {
            width: 95%;
            background: white;
            padding: 12px;
            margin: 12px 0;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            page-break-inside: avoid;
        }

        .recap-grid {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .recap-cell {
            display: table-cell;
            text-align: center;
            padding: 10px;
            background: linear-gradient(135deg, #f0f4ff 0%, #f8f9fa 100%);
            border-radius: 4px;
            border: 1px solid #e5e7eb;
            margin-right: 6px;
        }

        .recap-cell:last-child {
            margin-right: 0;
        }

        .recap-label {
            font-size: 8px;
            color: #6b7280;
            margin-bottom: 3px;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.2px;
        }

        .recap-value {
            font-size: 15px;
            font-weight: bold;
            color: #667eea;
        }

        /* ============ SECTION STATISTIQUES ============ */
        .stats-section {
            width: 95%;
            background: white;
            border: 1px solid #e5e7eb;
            page-break-inside: avoid;
        }

        .stats-grid {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .stats-cell {
            display: table-cell;
            text-align: center;
            background: linear-gradient(135deg, #f0fdf4 0%, #f8f9fa 100%);
            border: 1px solid #e5e7eb;
        }

        .stats-cell:last-child {
            margin-right: 0;
        }

        .stats-label {
            font-size: 8px;
            color: #6b7280;
            margin-bottom: 3px;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.2px;
        }

        .stats-value {
            font-size: 16px;
            font-weight: bold;
            color: #10b981;
        }

        /* ============ MESSAGE VIDE ============ */
        .empty-message {
            text-align: center;
            padding: 25px;
            color: #9ca3af;
            font-style: italic;
            background: white;
            border-radius: 5px;
            border: 1px dashed #e5e7eb;
            font-size: 9px;
        }

        .table-content {
            display: grid;
            justify-content: center;
            align-content: center;
        }


        /* ============ PRINT ============ */
        @media print {
            body {
                background: rgb(109, 9, 9);
            }

            .container {
                padding: 10px 20px;
            }

            table {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="container">


        <!-- En-tête Officiel -->
        <table border="0" cellspacing="0" cellpadding="0"
            style="width: 98%; border-bottom: 2px solid #000; font-family: 'Helvetica', sans-serif; font-size: 10px; margin-bottom: 20px;">
            <tr>
               <!-- Colonne de gauche (Français) -->
                    <td style="width: 33%;  line-height: 1; vertical-align: top; padding: 10px;text-align: center;">
                        <p style="font-weight: bold; text-decoration: underline; margin: 0 0 5px 0;">Ministère de l’emploi
                            et de la Formation Professionnelle</p>
                        <p style="font-size: 8px; color: #666; margin: 0 0 5px 0;">*************</p>
                        <p style="margin: 0 0 5px 0;">Centre de Formation Professionnelle la Canadienne</p>
                        <p style="font-size: 8px; color: #666; margin: 0 0 5px 0;">*************</p>
                        <p style="margin: 0;">B.P.: 837 Bafoussam</p>
                        <p style="margin: 0 0 5px 0;">Tel: +237 695 82 92 30 / 671 33 78 29</p>
                        <p style="font-size: 8px; color: #666; margin: 0 0 0 0;">*************</p>
                    </td>

                <!-- Logo Central -->
                <td style="width: 30%; text-align: center; vertical-align: middle;">
                    @php
                        $path = public_path('android-chrome-512x512.png');
                        if (file_exists($path)) {
                            $type = pathinfo($path, PATHINFO_EXTENSION);
                            $data = file_get_contents($path);
                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        }
                    @endphp

                    @if (isset($base64))
                        <img src="{{ $base64 }}" style="height: 80px;">
                    @else
                        <div
                            style="width: 80px; height: 80px; border: 1px solid #ddd; display: inline-block; line-height: 80px;">
                            LOGO
                        </div>
                    @endif
                </td>


                <!-- Bloc Anglais -->
                <td style="width: 33%; line-height: 1; vertical-align: top; text-align: right; padding: 10px; text-align: center;">
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
            <tr>
                <td colspan="3" style="text-align: center; padding:-5px 5px 0 0; font-size: 0.9rem; font-style: italic; margin-top: -15px">
                    Agrée par Arrêté Ministériel N° 000355/MINEFOP/SG/DFOP/SDGSF/CSACD/CBAC
                </td>
            </tr>
        </table>



        <!-- INFORMATIONS ÉTUDIANT -->
        <div class="info-section">
            <!-- Photo et informations principales -->
            <div style="display: flex; gap: 20px; margin-bottom: 20px; align-items: flex-start;">
                <!-- Photo de profil -->
                <div style="text-align: center;">
                    <div style="font-size: 10px; color: #6b7280; margin-bottom: 5px;">Photo</div>
                    @if($user->profile)
                        <img src="{{ Storage::url($user->profile) }}" alt="Photo de profil" 
                             style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb;">
                    @else
                        <div style="width: 60px; height: 60px; border-radius: 50%; background: #f3f4f6; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px; color: #6b7280;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                
                <!-- Informations détaillées -->
                <div style="flex: 1;">
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-cell">
                                <div class="info-label">Matricule</div>
                                <div class="info-value">
                                    <span class="badge-code">{{ $user->matricule }}</span>
                                </div>
                            </div>
                            <div class="info-cell">
                                <div class="info-label">Nom et Prénom</div>
                                <div class="info-value">{{ $user->name }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-cell">
                                <div class="info-label">Sexe</div>
                                <div class="info-value">
                                    @if($user->sexe === 'M') 👨 Masculin
                                    @elseif($user->sexe === 'F') 👩 Féminin
                                    @else 🧑 Autre @endif
                                </div>
                            </div>
                            <div class="info-cell">
                                <div class="info-label">Date de naissance</div>
                                <div class="info-value">{{ $user->date_naissance ? \Carbon\Carbon::parse($user->date_naissance)->format('d/m/Y') : 'Non spécifiée' }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-cell">
                                <div class="info-label">Lieu de naissance</div>
                                <div class="info-value">{{ $user->lieu_naissance ?? 'Non spécifié' }}</div>
                            </div>
                            <div class="info-cell">
                                <div class="info-label">Niveau</div>
                                <div class="info-value">{{ $user->niveau ?? 'Non défini' }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-cell">
                                <div class="info-label">Spécialité</div>
                                <div class="info-value">{{ $user->specialite->intitule ?? 'Non assignée' }}</div>
                            </div>
                            <div class="info-cell">
                                <div class="info-label">Année de Formation</div>
                                <div class="info-value">{{ $user->anneeAcademique->libelle ?? 'Non définie' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEMESTRE 1 -->
        @if ($evaluationsSemestre1->isNotEmpty())
            <div class="section-title">SEMESTRE 1</div>
            <div class="table-content">
                <table>
                    <thead>
                        <tr>
                            <th class="left">Code</th>
                            <th class="left">Module</th>
                            <th class="center">Coef.</th>
                            <th class="center">Note</th>
                            <th class="center">Appréciation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalCoefficients1 = 0;
                            $sommeNotesPonderees1 = 0;
                        @endphp
                        @foreach ($evaluationsSemestre1 as $evaluation)
                            @php
                                $note = $evaluation->note ?? 0;
                                $coefficient = $evaluation->module->coefficient ?? 1;
                                $totalCoefficients1 += $coefficient;
                                $sommeNotesPonderees1 += $note * $coefficient;

                                // Déterminer la couleur de la ligne
                                if ($note >= 16) {
                                    $rowClass = 'note-excellent';
                                } elseif ($note >= 14) {
                                    $rowClass = 'note-good';
                                } elseif ($note >= 10) {
                                    $rowClass = 'note-average';
                                } else {
                                    $rowClass = 'note-poor';
                                }

                                // Appréciation
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
                            <tr class="{{ $rowClass }}">
                                <td>{{ $evaluation->module->code ?? 'N/A' }}</td>
                                <td>{{ $evaluation->module->intitule ?? 'N/A' }}</td>
                                <td class="center">{{ $coefficient }}</td>
                                <td class="center"><strong>{{ number_format($note, 2) }}</strong></td>
                                <td class="center">{{ $appreciation }}</td>
                            </tr>
                        @endforeach
                        <tr class="row-total">
                            <td colspan="3">MOYENNE SEMESTRE 1</td>
                            <td class="center"><strong>{{ number_format($moyenneSemestre1 ?? 0, 2) }}</strong></td>
                            <td class="center">
                                @if ($moyenneSemestre1 >= 10)
                                    Admis
                                @else
                                    Non Admis
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            @else
                <div class="empty-message">Aucune évaluation pour le semestre 1</div>
        @endif

        <!-- SEMESTRE 2 -->
        @if ($evaluationsSemestre2->isNotEmpty())
            <div class="section-title semestre2">SEMESTRE 2</div>
            <table>
                <thead>
                    <tr>
                        <th class="left">Code</th>
                        <th class="left">Module</th>
                        <th class="center">Coef.</th>
                        <th class="center">Note</th>
                        <th class="center">Appréciation</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalCoefficients2 = 0;
                        $sommeNotesPonderees2 = 0;
                    @endphp
                    @foreach ($evaluationsSemestre2 as $evaluation)
                        @php
                            $note = $evaluation->note ?? 0;
                            $coefficient = $evaluation->module->coefficient ?? 1;
                            $totalCoefficients2 += $coefficient;
                            $sommeNotesPonderees2 += $note * $coefficient;

                            if ($note >= 16) {
                                $rowClass = 'note-excellent';
                                $appreciation = 'Très Bien';
                            } elseif ($note >= 14) {
                                $rowClass = 'note-good';
                                $appreciation = 'Bien';
                            } elseif ($note >= 12) {
                                $rowClass = 'note-average';
                                $appreciation = 'Assez Bien';
                            } elseif ($note >= 10) {
                                $rowClass = 'note-average';
                                $appreciation = 'Passable';
                            } else {
                                $rowClass = 'note-poor';
                                $appreciation = 'Insuffisant';
                            }
                        @endphp
                        <tr class="{{ $rowClass }}">
                            <td>{{ $evaluation->module->code ?? 'N/A' }}</td>
                            <td>{{ $evaluation->module->intitule ?? 'N/A' }}</td>
                            <td class="center">{{ $coefficient }}</td>
                            <td class="center"><strong>{{ number_format($note, 2) }}</strong></td>
                            <td class="center">{{ $appreciation }}</td>
                        </tr>
                    @endforeach
                    <tr class="row-total">
                        <td colspan="3">MOYENNE SEMESTRE 2</td>
                        <td class="center"><strong>{{ number_format($moyenneSemestre2 ?? 0, 2) }}</strong></td>
                        <td class="center">
                            @if ($moyenneSemestre2 >= 10)
                                Admis
                            @else
                                Non Admis
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="empty-message">Aucune évaluation pour le semestre 2</div>
        @endif
    </div>
    <!-- RÉSUMÉ GÉNÉRAL -->
    @if ($evaluationsSemestre1->isNotEmpty() || $evaluationsSemestre2->isNotEmpty())
        <div class="section-title general">RÉSUMÉ GÉNÉRAL</div>

        <div class="recap-section">
            <div class="recap-grid">
                <div class="recap-cell">
                    <div class="recap-label">Moyenne S1</div>
                    <div class="recap-value">{{ number_format($moyenneSemestre1 ?? 0, 2) }}/20</div>
                </div>
                <div class="recap-cell">
                    <div class="recap-label">Moyenne S2</div>
                    <div class="recap-value">{{ number_format($moyenneSemestre2 ?? 0, 2) }}/20</div>
                </div>
                <div class="recap-cell">
                    <div class="recap-label">Moyenne Générale</div>
                    <div class="recap-value">{{ number_format($moyenneGenerale ?? 0, 2) }}/20</div>
                </div>
            </div>
        </div>

        <!-- STATISTIQUES -->
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stats-cell">
                    <div class="stats-label">Total Modules</div>
                    <div class="stats-value">{{ $stats['totalModules'] ?? 0 }}</div>
                </div>
                <div class="stats-cell">
                    <div class="stats-label">Modules Validés</div>
                    <div class="stats-value">{{ $stats['modulesValides'] ?? 0 }}</div>
                </div>
                <div class="stats-cell">
                    <div class="stats-label">Modules Échoués</div>
                    <div class="stats-value" style="color: #ef4444;">{{ $stats['modulesEchoues'] ?? 0 }}</div>
                </div>
                <div class="stats-cell">
                    <div class="stats-label">Résultat</div>
                    <div class="stats-value"
                        style="color: {{ ($moyenneGenerale ?? 0) >= 10 ? '#10b981' : '#ef4444' }}">
                        {{ ($moyenneGenerale ?? 0) >= 10 ? 'ADMIS' : 'NON ADMIS' }}
                    </div>
                </div>
            </div>
        </div>
    @endif


    </div>
</body>

</html>
