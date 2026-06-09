<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Relevé de Notes - {{ $user->matricule }}</title>
    <style>
        @page {
            margin: 0.8cm 1.2cm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.35;
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
            border-bottom: 2.5px solid #D32F2F;
            margin-bottom: 15px;
            padding-bottom: 8px;
        }

        .header-text {
            text-align: center;
            font-size: 9.5px;
            line-height: 1.2;
        }

        .header-title {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            color: #D32F2F;
        }

        /* --- INFO CARD --- */
        .info-card {
            border: 1px solid #E5E7EB;
            border-left: 4.5px solid #D32F2F;
            width: 100%;
            padding: 10px 14px;
            background-color: #F9FAFB;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .info-table {
            width: 100%;
        }

        .info-label {
            font-weight: bold;
            color: #6B7280;
            width: 120px;
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
            padding-bottom: 2px;
            margin: 2px 0 8px 0;
            letter-spacing: 0.5px;
        }

        /* --- GRADES TABLE --- */
        table.grades-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        table.grades-table th {
            text-align: left;
            padding: 6px 8px;
            font-size: 9.5px;
            font-weight: bold;
            text-transform: uppercase;
            color: #FFFFFF;
            background-color: #000000;
            border-bottom: 1px solid #000;
        }

        table.grades-table td {
            padding: 5px 8px;
            border-bottom: 1px solid #E5E7EB;
            font-size: 10.5px;
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
            width: 75%;
            margin-top: 2px;
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
            padding: 8px 10px;
            font-size: 9.5px;
            text-transform: uppercase;
        }

        .summary-table td {
            text-align: center;
            padding: 8px 10px;
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
            width: 220px;
            text-align: center;
        }

        .signature-line {
            margin-top: 35px;
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

        /* --- WATERMARK --- */
        .watermark {
            position: fixed;
            top: 42%;
            left: 5%;
            width: 90%;
            text-align: center;
            font-size: 85px;
            font-weight: bold;
            color: rgba(220, 220, 220, 0.18);
            transform: rotate(-35deg);
            transform-origin: 50% 50%;
            z-index: -1000;
            text-transform: uppercase;
            letter-spacing: 5px;
        }
    </style>
</head>

<body>
    <div class="watermark">ORIGINAL</div>

    <!-- ENTÊTE -->
    <table class="header-table">
        <tr>
            <!-- Ministère (Français) -->
            <td width="38%" class="header-text" style="vertical-align: top; text-align: center;">
               
                <div class="font-bold" style="font-size: 9.5px; line-height: 1.2;">Ministère de l’Emploi et de la Formation Professionnelle</div>
                <div style="border-top: 1px dotted #D32F2F; margin: 5px 0;"></div>
                <div class="text-red font-bold" style="font-size: 9.5px; text-transform: uppercase; line-height: 1.2;">Centre de Formation Professionnelle la Canadienne</div>
                <div style="border-top: 1px dotted #D32F2F; margin: 5px 0;"></div>
                <div style="font-size: 9.5px; font-weight: bold;">B.P.: 837 Bafoussam</div>
                <div style="font-size: 9.5px; font-weight: bold;">Tél: +237 695 82 92 30 / 671 33 78 29</div>
            </td>

            <!-- Logo -->
            <td width="24%" class="text-center" style="vertical-align: middle; padding: 0 5px;">
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
                    <img src="{{ $base64 }}" style="height: 60px; width: auto; display: block; margin: 0 auto;">
                @else
                    <div
                        style="font-weight: bold; color: #D32F2F; border: 2px solid #D32F2F; padding: 5px; display: inline-block; font-size: 8px;">
                        L O G O</div>
                @endif
            </td>

            <!-- Anglais -->
            <td width="38%" class="header-text" style="vertical-align: top; text-align: center;">
                
                <div class="font-bold" style="font-size: 9.5px; line-height: 1.2;">Ministry of Employment and Vocational Training</div>
                <div style="border-top: 1px dotted #D32F2F; margin: 5px 0;"></div>
                <div class="text-red font-bold" style="font-size: 9.5px; text-transform: uppercase; line-height: 1.2;">Canadian Vocational Training Center</div>
                <div style="border-top: 1px dotted #D32F2F; margin: 5px 0;"></div>
                <div style="font-size: 9.5px; font-weight: bold;">contact@cfpcanadienne.com</div>
                <div style="font-size: 9.5px; font-weight: bold;">www.cfpcanadienne.com</div>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="text-center" style="font-size: 9.5px; color: #333; padding-top: 1px; font-weight: bold; line-height: 1.2;">
                <div style="border-top: 1px dotted #D32F2F; margin: 6px 0;"></div>
                <em>Créé, agréé et renouvelé par Arrêté Ministériel N° 000355/MINEFOP/SG/DFOP/SDGSF/CSACD/CBAC</em>
            </td>
        </tr>
    </table>

    <div class="text-center" style="margin-bottom: 2px;">
        <h1
            style="color: #D32F2F; font-size: 18px; text-transform: uppercase; letter-spacing: 1px; margin: 0; border-bottom: 1px solid #D32F2F; display: inline-block; padding-bottom: 4px;">
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
                        <td class="font-bold text-red" style="font-size: 9.5px;">{{ $evaluation->module->code ?? '-' }}
                        </td>
                        <td>{{ $evaluation->module->intitule ?? '-' }}</td>
                        <td class="text-center">{{ $evaluation->module->coefficient ?? 1 }}</td>
                        <td class="text-center font-bold">{{ number_format($note, 2) }}</td>
                        <td class="text-center" style="font-size: 9.5px; font-style: italic;">{{ $appreciation }}</td>
                    </tr>
                @endforeach
                <tr class="row-total">
                    <td colspan="2" class="text-right">MOYENNE SEMESTRIELLE</td>
                    <td class="text-center">-</td>
                    <td class="text-center" style="font-size: 13px;">{{ number_format($moyenneSemestre1 ?? 0, 2) }}
                    </td>
                    <td class="text-center" style="font-size: 11px;">
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
                        <td class="font-bold text-red" style="font-size: 9.5px;">{{ $evaluation->module->code ?? '-' }}
                        </td>
                        <td>{{ $evaluation->module->intitule ?? '-' }}</td>
                        <td class="text-center">{{ $evaluation->module->coefficient ?? 1 }}</td>
                        <td class="text-center font-bold">{{ number_format($note, 2) }}</td>
                        <td class="text-center" style="font-size: 9.5px; font-style: italic;">{{ $appreciation }}</td>
                    </tr>
                @endforeach
                <tr class="row-total">
                    <td colspan="2" class="text-right">MOYENNE SEMESTRIELLE</td>
                    <td class="text-center">-</td>
                    <td class="text-center" style="font-size: 13px;">{{ number_format($moyenneSemestre2 ?? 0, 2) }}
                    </td>
                    <td class="text-center" style="font-size: 11px;">
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
                                style="font-size: 14px; border-left: 2px solid #E5E7EB; border-right: 2px solid #E5E7EB;">
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
            <div style="font-style: italic; font-size: 11.5px; margin-bottom: 2px;">
                Fait à Bafoussam, le {{ now()->format('d/m/Y') }}
            </div>
            <div class="font-bold text-red" style="margin-bottom: 50px; text-transform: uppercase; font-size: 11.5px;">
                La Directrice
            </div>
            <!-- Espace pour tampon/signature -->
            <div style="height: 70px;"></div>
        </div>
    </div>

</body>

</html>
