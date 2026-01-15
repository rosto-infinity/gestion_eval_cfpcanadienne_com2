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
            color: #000;
            background: #fff;
        }

        .container {
            width: 95%;
            padding: 10px 25px;
        }

        /* ============ INFORMATIONS ÉTUDIANT ============ */
        .info-section {
            width: 95%;
            padding: 10px 0;
            margin-bottom: 15px;
            border: 1px solid #000;
        }

        .info-grid {
            display: table;
            width: 95%;
            table-layout: fixed;
        }

        .info-row {
            display: table-row;
        }

        .info-cell {
            display: table-cell;
            padding: 4px 8px;
            width: 50%;
            vertical-align: top;
        }

        .info-label {
            font-size: 9px;
            color: #000;
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }

        .info-value {
            font-size: 10px;
            display: inline-block;
            font-weight: bold;
        }

        /* ============ SECTION TITRE ============ */
        .section-title {
            color: #000;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        /* ============ TABLEAU ============ */
        table {
            width: 95%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 9px;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
            color: #000;
            vertical-align: middle;
        }

        th {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            background: #fff; /* Force white background */
        }

        td.center {
            text-align: center;
        }

        td.left {
            text-align: left;
        }

        .row-total {
            font-weight: bold;
        }

        /* ============ RÉSUMÉ GÉNÉRAL (Tableau) ============ */
        .summary-table {
            width: 50%; /* Petit tableau comme demandé */
            margin-bottom: 20px;
        }

        /* ============ SIGNATURE ============ */
        .signature-section {
            margin-top: 40px;
            width: 100%;
            page-break-inside: avoid;
        }

        .signature-box {
            float: right;
            width: 40%;
            text-align: center;
        }

        .signature-date {
            margin-bottom: 5px;
            font-style: italic;
        }

        .signature-title {
            font-weight: bold;
            margin-bottom: 10px;
            text-decoration: underline;
        }
        
        /* Clearing float */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        /* ============ PRINT ============ */
        @media print {
            body {
                background: #fff;
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
        <table style="width: 95%; border: none; margin-bottom: 0;">
            <tr style="border: none;">
                <!-- Colonne de gauche (Français) -->
                <td style="width: 33%; border: none; line-height: 1.1; vertical-align: top; text-align: center; padding: 0;">
                    <p style="font-weight: bold; text-decoration: underline; margin: 0 0 2px 0;">Ministère de l’Emploi et de la Formation Professionnelle</p>
                    <p style="font-size: 8px; margin: 0 0 2px 0;">*************</p>
                    <p style="margin: 0 0 2px 0;">Centre de Formation Professionnelle La Canadienne</p>
                    <p style="font-size: 8px; margin: 0 0 2px 0;">*************</p>
                    <p style="margin: 0 0 2px 0;">B.P.: 837 Bafoussam</p>
                    <p style="margin: 0;">Tel: +237 695 82 92 30 / 671 33 78 29</p>
                </td>

                <!-- Logo Central -->
                <td style="width: 34%; border: none; text-align: center; vertical-align: middle; padding: 0;">
                    @php
                        $path = public_path('android-chrome-512x512.png');
                        $base64 = null;
                        if (file_exists($path)) {
                            $type = pathinfo($path, PATHINFO_EXTENSION);
                            $data = file_get_contents($path);
                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        }
                    @endphp

                    @if ($base64)
                        <img src="{{ $base64 }}" style="height: 70px;">
                    @else
                        <div style="font-weight: bold;">[LOGO]</div>
                    @endif
                </td>

                <!-- Bloc Anglais -->
                <td style="width: 33%; border: none; line-height: 1.1; vertical-align: top; text-align: center; padding: 0;">
                    <p style="font-weight: bold; text-decoration: underline; margin: 0 0 2px 0;">Ministry of Employment and Vocational Training</p>
                    <p style="font-size: 8px; margin: 0 0 2px 0;">*************</p>
                    <p style="margin: 0 0 2px 0;">Canadian Vocational Training Center</p>
                    <p style="font-size: 8px; margin: 0 0 2px 0;">*************</p>
                    <p style="margin: 0 0 2px 0;">contact@cfpcanadienne.com</p>
                    <p style="margin: 0;">www.cfpcanadienne.com</p>
                </td>
            </tr>
            <tr style="border: none;">
                <td colspan="3" style="border: none; text-align: center; padding-top: 5px; font-size: 8px; font-style: italic;">
                    Agrée par Arrêté Ministériel N° 000355/MINEFOP/SG/DFOP/SDGSF/CSACD/CBAC
                </td>
            </tr>
        </table>
        
        <div style="border-bottom: 2px solid #000; margin: 5px 0 15px 0;"></div>

        <!-- INFORMATIONS ÉTUDIANT -->
        <div class="info-section">
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-cell">
                        <span class="info-label">Matricule :</span>
                        <span class="info-value">{{ $user->matricule }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Nom et Prénom :</span>
                        <span class="info-value">{{ $user->name }}</span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-cell">
                        <span class="info-label">Sexe :</span>
                        <span class="info-value">
                            @if($user->sexe === 'M') Masculin
                            @elseif($user->sexe === 'F') Féminin
                            @else Autre @endif
                        </span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Né(e) le :</span>
                        <span class="info-value">
                            {{ $user->date_naissance ? \Carbon\Carbon::parse($user->date_naissance)->format('d/m/Y') : '-' }}
                            @if($user->lieu_naissance) à {{ $user->lieu_naissance }} @endif
                        </span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-cell">
                        <span class="info-label">Spécialité :</span>
                        <span class="info-value">{{ $user->specialite->intitule ?? '-' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Niveau :</span>
                        <span class="info-value">{{ $user->niveau ?? '-' }}</span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-cell">
                        <span class="info-label">Année académique :</span>
                        <span class="info-value">{{ $user->anneeAcademique->libelle ?? '-' }}</span>
                    </div>
                    <div class="info-cell"></div>
                </div>
            </div>
        </div>

        <!-- SEMESTRE 1 -->
        @if ($evaluationsSemestre1->isNotEmpty())
            <div class="section-title">SEMESTRE 1</div>
            <table>
                <thead>
                    <tr>
                        <th class="left" style="width: 15%;">Code</th>
                        <th class="left">Module</th>
                        <th class="center" style="width: 10%;">Coef.</th>
                        <th class="center" style="width: 10%;">Note</th>
                        <th class="center" style="width: 15%;">Appréciation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($evaluationsSemestre1 as $evaluation)
                        @php
                            $note = $evaluation->note ?? 0;
                            // Appréciation simple sans couleur
                            if ($note >= 16) $appreciation = 'Très Bien';
                            elseif ($note >= 14) $appreciation = 'Bien';
                            elseif ($note >= 12) $appreciation = 'Assez Bien';
                            elseif ($note >= 10) $appreciation = 'Passable';
                            else $appreciation = 'Insuffisant';
                        @endphp
                        <tr>
                            <td>{{ $evaluation->module->code ?? '-' }}</td>
                            <td>{{ $evaluation->module->intitule ?? '-' }}</td>
                            <td class="center">{{ $evaluation->module->coefficient ?? 1 }}</td>
                            <td class="center">{{ number_format($note, 2) }}</td>
                            <td class="center">{{ $appreciation }}</td>
                        </tr>
                    @endforeach
                    <tr class="row-total">
                        <td colspan="3" style="text-align: right; padding-right: 10px;">MOYENNE SEMESTRE 1</td>
                        <td class="center">{{ number_format($moyenneSemestre1 ?? 0, 2) }}</td>
                        <td class="center">
                            {{ ($moyenneSemestre1 ?? 0) >= 10 ? 'Mod. Validés' : 'Non Validés' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif

        <!-- SEMESTRE 2 -->
        @if ($evaluationsSemestre2->isNotEmpty())
            <div class="section-title">SEMESTRE 2</div>
            <table>
                <thead>
                    <tr>
                        <th class="left" style="width: 15%;">Code</th>
                        <th class="left">Module</th>
                        <th class="center" style="width: 10%;">Coef.</th>
                        <th class="center" style="width: 10%;">Note</th>
                        <th class="center" style="width: 15%;">Appréciation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($evaluationsSemestre2 as $evaluation)
                        @php
                            $note = $evaluation->note ?? 0;
                            if ($note >= 16) $appreciation = 'Très Bien';
                            elseif ($note >= 14) $appreciation = 'Bien';
                            elseif ($note >= 12) $appreciation = 'Assez Bien';
                            elseif ($note >= 10) $appreciation = 'Passable';
                            else $appreciation = 'Insuffisant';
                        @endphp
                        <tr>
                            <td>{{ $evaluation->module->code ?? '-' }}</td>
                            <td>{{ $evaluation->module->intitule ?? '-' }}</td>
                            <td class="center">{{ $evaluation->module->coefficient ?? 1 }}</td>
                            <td class="center">{{ number_format($note, 2) }}</td>
                            <td class="center">{{ $appreciation }}</td>
                        </tr>
                    @endforeach
                    <tr class="row-total">
                        <td colspan="3" style="text-align: right; padding-right: 10px;">MOYENNE SEMESTRE 2</td>
                        <td class="center">{{ number_format($moyenneSemestre2 ?? 0, 2) }}</td>
                        <td class="center">
                            {{ ($moyenneSemestre2 ?? 0) >= 10 ? 'Mod. Validés' : 'Non Validés' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif

        <!-- RÉSUMÉ GÉNÉRAL -->
        @if ($evaluationsSemestre1->isNotEmpty() || $evaluationsSemestre2->isNotEmpty())
            <div class="section-title" style="margin-top: 20px;">RÉSUMÉ GÉNÉRAL</div>
            <table class="summary-table">
                <thead>
                    <tr>
                        <th>Moy S1</th>
                        <th>Moy S2</th>
                        <th>Moyenne Générale</th>
                        <th>Décision</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="center">{{ number_format($moyenneSemestre1 ?? 0, 2) }}</td>
                        <td class="center">{{ number_format($moyenneSemestre2 ?? 0, 2) }}</td>
                        <td class="center" style="font-weight: bold;">{{ number_format($moyenneGenerale ?? 0, 2) }}</td>
                        <td class="center" style="font-weight: bold;">
                            {{ ($moyenneGenerale ?? 0) >= 10 ? 'ADMIS' : 'NON ADMIS' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif

        <!-- SIGNATURE -->
        <div class="signature-section clearfix">
            <div class="signature-box">
                <div class="signature-date">
                    Fait à Bafoussam, le {{ now()->format('d/m/Y') }}
                </div>
                <div class="signature-title">
                    La Directrice du centre
                </div>
            </div>
        </div>

    </div>
</body>
</html>
