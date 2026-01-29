<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Relevé de Notes - {{ $user->matricule }}</title>
    <style>
        @page {
            margin: 0.5cm 1cm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.3;
        }

        /* --- COLORS --- */
        .text-red {
            color: #D32F2F;
        }

        .bg-red-light {
            background-color: #FEE2E2;
        }

        .border-red {
            border-color: #D32F2F;
        }

        /* --- LAYOUT --- */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #D32F2F;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .header-text {
            text-align: center;
            font-size: 9px;
            line-height: 1.2;
        }

        .header-title {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            color: #D32F2F;
        }

        /* --- INFO CARD --- */
        .info-card {
            border: 1px solid #E5E7EB;
            border-left: 4px solid #D32F2F;
            width: 100%;
            padding: 10px 15px;
            background-color: #F9FAFB;
            margin-bottom: 25px;
            border-radius: 4px;
        }

        .info-table {
            width: 100%;
        }

        .info-label {
            font-weight: bold;
            color: #6B7280;
            width: 110px;
        }

        .info-value {
            font-weight: bold;
            color: #111827;
        }

        /* --- SECTION TITLES --- */
        .section-title {
            color: #D32F2F;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #D32F2F;
            padding-bottom: 4px;
            margin: 20px 0 10px 0;
            letter-spacing: 0.5px;
        }

        /* --- GRADES TABLE --- */
        table.grades-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table.grades-table th {
            text-align: left;
            padding: 8px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            color: #FFFFFF;
            background-color: #000000;
            border-bottom: 1px solid #000;
        }

        table.grades-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #E5E7EB;
            font-size: 10px;
        }

        table.grades-table tr:last-child td {
            border-bottom: none;
        }

        .row-total {
            background-color: #FFF1F2;
            font-weight: bold;
            border-top: 1px solid #FECACA;
        }

        .row-total td {
            color: #D32F2F;
        }

        /* --- SUMMARY TABLE --- */
        .summary-container {
            width: 60%;
            margin-top: 20px;
            border: 1px solid #E5E7EB;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table th {
            background-color: #D32F2F;
            color: #fff;
            padding: 8px;
            font-size: 9px;
            text-transform: uppercase;
        }

        .summary-table td {
            text-align: center;
            padding: 10px;
            font-size: 11px;
            font-weight: bold;
            border-right: 1px solid #E5E7EB;
        }

        .summary-table td:last-child {
            border-right: none;
        }

        .decision-pass {
            color: #16A34A;
        }

        .decision-fail {
            color: #DC2626;
        }

        /* --- SIGNATURE --- */
        .signature-section {
            margin-top: 30px;
            text-align: right;
            page-break-inside: avoid;
        }

        .signature-box {
            display: inline-block;
            width: 200px;
            text-align: center;
        }

        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #9CA3AF;
            width: 100%;
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

        .uppercase {
            text-transform: uppercase;
        }
    </style>
</head>

<body>

    <!-- ENTÊTE -->
    <table class="header-table">
        <tr>
            <!-- Ministère -->
            <td width="30%" class="header-text" style="vertical-align: top;">
                <div class="text-red font-bold">REPUBLIQUE DU CAMEROUN</div>
                <div style="font-size: 8px;">Paix - Travail - Patrie</div>
                <div style="margin-top: 5px;" class="font-bold">Ministère de l’Emploi et de la Formation Professionnelle
                </div>
            </td>

            <!-- Logo -->
            <td width="40%" class="text-center" style="vertical-align: middle;">
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
                    <img src="{{ $base64 }}" style="height: 60px; width: auto;">
                @else
                    <div
                        style="font-weight: bold; color: #D32F2F; border: 2px solid #D32F2F; padding: 5px; display: inline-block;">
                        L O G O</div>
                @endif
                <div class="text-red font-bold" style="font-size: 11px; margin-top: 5px; text-transform: uppercase;">
                    Centre de Formation Professionnelle La Canadienne
                </div>
            </td>

            <!-- Anglais -->
            <td width="30%" class="header-text" style="vertical-align: top;">
                <div class="text-red font-bold">REPUBLIC OF CAMEROON</div>
                <div style="font-size: 8px;">Peace - Work - Fatherland</div>
                <div style="margin-top: 5px;" class="font-bold">Ministry of Employment and Vocational Training</div>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="text-center" style="font-size: 8px; color: #666; padding-top: 8px;">
                <em>Agrée par Arrêté Ministériel N° 000355/MINEFOP/SG/DFOP/SDGSF/CSACD/CBAC</em> | Tél: +237 695 82 92
                30 / 671 33 78 29
            </td>
        </tr>
    </table>

    <div class="text-center" style="margin-bottom: 20px;">
        <h1
            style="color: #D32F2F; font-size: 18px; text-transform: uppercase; letter-spacing: 1px; margin: 0; border-bottom: 1px solid #D32F2F; display: inline-block; padding-bottom: 2px;">
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
                            <td class="info-value">: {{ $user->matricule }}</td>
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
                        <td class="font-bold text-red" style="font-size: 8px;">{{ $evaluation->module->code ?? '-' }}
                        </td>
                        <td>{{ $evaluation->module->intitule ?? '-' }}</td>
                        <td class="text-center">{{ $evaluation->module->coefficient ?? 1 }}</td>
                        <td class="text-center font-bold">{{ number_format($note, 2) }}</td>
                        <td class="text-center" style="font-size: 8px; font-style: italic;">{{ $appreciation }}</td>
                    </tr>
                @endforeach
                <tr class="row-total">
                    <td colspan="2" class="text-right">MOYENNE SEMESTRIELLE</td>
                    <td class="text-center">-</td>
                    <td class="text-center" style="font-size: 11px;">{{ number_format($moyenneSemestre1 ?? 0, 2) }}
                    </td>
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
                        <td class="font-bold text-red" style="font-size: 8px;">{{ $evaluation->module->code ?? '-' }}
                        </td>
                        <td>{{ $evaluation->module->intitule ?? '-' }}</td>
                        <td class="text-center">{{ $evaluation->module->coefficient ?? 1 }}</td>
                        <td class="text-center font-bold">{{ number_format($note, 2) }}</td>
                        <td class="text-center" style="font-size: 8px; font-style: italic;">{{ $appreciation }}</td>
                    </tr>
                @endforeach
                <tr class="row-total">
                    <td colspan="2" class="text-right">MOYENNE SEMESTRIELLE</td>
                    <td class="text-center">-</td>
                    <td class="text-center" style="font-size: 11px;">{{ number_format($moyenneSemestre2 ?? 0, 2) }}
                    </td>
                    <td class="text-center" style="font-size: 9px;">
                        {{ ($moyenneSemestre2 ?? 0) >= 10 ? 'VALIDÉ' : 'NON VALIDÉ' }}
                    </td>
                </tr>
            </tbody>
        </table>
    @endif

    <!-- RÉSUMÉ & DÉCISION -->
    @if ($evaluationsSemestre1->isNotEmpty() || $evaluationsSemestre2->isNotEmpty())
        <div style="page-break-inside: avoid;">
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
        </div>
    @endif

    <!-- PIED DE PAGE / SIGNATURE -->
    <div class="signature-section">
        <div class="signature-box">
            <div style="font-style: italic; font-size: 10px; margin-bottom: 5px;">
                Fait à Bafoussam, le {{ now()->format('d/m/Y') }}
            </div>
            <div class="font-bold text-red" style="margin-bottom: 40px; text-transform: uppercase; font-size: 10px;">
                La Directrice
            </div>
            <!-- Espace pour tampon/signature -->
            <div style="height: 50px;"></div>
        </div>
    </div>

</body>

</html>
