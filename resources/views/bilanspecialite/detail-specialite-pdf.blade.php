<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail - {{ $specialite->code }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 10px;
            color: #333;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        .header-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .header-title h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header-title p {
            margin: 2px 0;
            font-size: 12px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            background-color: #fff;
        }

        th, td {
            border: 1px solid #eee;
            padding: 6px 4px;
            vertical-align: middle;
        }

        /* En-têtes style "Capture" - Rose pâle et texte foncé */
        th {
            background-color: #fff0f0; /* Rose très pâle */
            color: #000;
            font-weight: 700;
            text-align: center;
        }

        /* Bordures spécifiques pour séparer les sections */
        table, th, td {
            border: 1px solid #e5e7eb;
        }
        
        thead tr {
            border-bottom: 1px solid #fecaca; /* Bordure rouge rosée */
        }
        
        th {
            border-right: 1px solid #fcd5d5;
            border-bottom: 1px solid #fcd5d5;
        }

        /* Colonne N° */
        .col-num {
            width: 30px;
            text-align: center;
            font-weight: bold;
            color: #333;
        }

        /* Colonne Nom & Prénoms */
        .col-name {
            text-align: left;
            min-width: 180px;
        }

        .user-info {
            display: block;
        }
        
        .avatar-circle {
            display: inline-block;
            width: 24px;
            height: 24px;
            line-height: 24px;
            border-radius: 50%;
            background-color: #fecaca;
            color: #ef4444;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            vertical-align: middle;
            margin-right: 6px;
        }

        .user-details {
            display: inline-block;
            vertical-align: middle;
        }

        .user-name {
            display: block;
            font-weight: 800;
            font-size: 10px;
            color: #000;
            text-transform: uppercase;
        }
        
        .user-matricule {
            display: block;
            font-size: 8px;
            color: #888;
            margin-top: 1px;
        }

        /* Cellules de notes (toutes en rouge selon capture) */
        .cell-note {
            text-align: center;
            color: #ef4444; /* Rouge vif */
            font-weight: 600;
            font-size: 10px;
        }

        /* Moyennes avec fond légèrement différent ou texte plus gras */
        .cell-moy {
            background-color: #fffbfb;
            color: #dc2626; /* Rouge un peu plus foncé */
            font-weight: 800;
        }

        /* Note générale */
        .cell-general {
            font-weight: 900;
            color: #dc2626;
            background-color: #fff0f0;
        }

        /* Alternance des lignes (optionnel, subtil) */
        tbody tr:nth-child(even) {
            background-color: #fffafa;
        }

        /* Sous-titre dans le header (en, fr) */
        .th-sub {
            display: block;
            font-size: 7px;
            color: #666;
            font-weight: normal;
            margin-top: 2px;
            text-transform: none;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 8px;
            color: #999;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }

    </style>
</head>
<body>

    <div class="header-title">
        <h1>Bilan des évaluations et compétences</h1>
        <p>{{ $specialite->intitule }} ({{ $specialite->code }})</p>
        @if(isset($annee))
            <p>Année académique : {{ $annee->libelle }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="3" style="width: 40px;">
                    N°
                </th>
                <th rowspan="3" style="text-align: left; padding-left: 10px;">
                    Nom et prénoms
                    <span class="th-sub">Names and first names</span>
                </th>
                <th colspan="12">
                    Évaluations semestrielles (30%)
                </th>
                <th rowspan="3" style="width: 80px;">
                    Bilan des compétences<br>(70%)
                </th>
                <th rowspan="3" style="width: 60px;">
                    Moy. Gén.<br>(100%)
                </th>
            </tr>
            <tr>
                <!-- Semestre 1 -->
                <th colspan="6">Semestre 1 (M1–M5)</th>
                <!-- Semestre 2 -->
                <th colspan="6">Semestre 2 (M6–M10)</th>
            </tr>
            <tr>
                <!-- M1-M5 + Moy -->
                <th style="width: 30px;">M1</th>
                <th style="width: 30px;">M2</th>
                <th style="width: 30px;">M3</th>
                <th style="width: 30px;">M4</th>
                <th style="width: 30px;">M5</th>
                <th style="width: 40px; background-color: #ffeaea;">Moy. S1</th>
                
                <!-- M6-M10 + Moy -->
                <th style="width: 30px;">M6</th>
                <th style="width: 30px;">M7</th>
                <th style="width: 30px;">M8</th>
                <th style="width: 30px;">M9</th>
                <th style="width: 30px;">M10</th>
                <th style="width: 40px; background-color: #ffeaea;">Moy. S2</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bilans as $index => $bilan)
            @php
                $user = $bilan->user;
                $evaluations = $user->evaluations;

                // Préparation des notes pour éviter les requêtes dans la boucle
                $evalS1 = $evaluations->filter(fn ($e) => in_array($e->module->code, ['M1', 'M2', 'M3', 'M4', 'M5']))->keyBy('module.code');
                $evalS2 = $evaluations->filter(fn ($e) => in_array($e->module->code, ['M6', 'M7', 'M8', 'M9', 'M10']))->keyBy('module.code');
                
                $initial = substr($user->name, 0, 1);
            @endphp
            <tr>
                <td class="col-num">{{ $index + 1 }}</td>
                <td class="col-name">
                    <div class="user-info">
                        <div class="avatar-circle">{{ strtoupper($initial) }}</div>
                        <div class="user-details">
                            <span class="user-name">{{ strtoupper($user->name) }}</span>
                            <span class="user-matricule">{{ $user->matricule ?? 'N/A' }}</span>
                        </div>
                    </div>
                </td>

                {{-- Semestre 1 (M1-M5) --}}
                @for($i = 1; $i <= 5; $i++)
                    @php
                        $eval = $evalS1->get("M{$i}");
                        $note = $eval?->note;
                    @endphp
                    <td class="cell-note">
                        {{ $note !== null ? number_format($note, 0) : '-' }}
                    </td>
                @endfor
                
                {{-- Moy S1 --}}
                <td class="cell-note cell-moy">
                    {{ $bilan->moy_eval_semestre1 > 0 ? number_format($bilan->moy_eval_semestre1, 2) : '-' }}
                </td>

                {{-- Semestre 2 (M6-M10) --}}
                @for($i = 6; $i <= 10; $i++)
                    @php
                        $eval = $evalS2->get("M{$i}");
                        $note = $eval?->note;
                    @endphp
                    <td class="cell-note">
                        {{ $note !== null ? number_format($note, 0) : '-' }}
                    </td>
                @endfor

                {{-- Moy S2 --}}
                <td class="cell-note cell-moy">
                    {{ $bilan->moy_eval_semestre2 > 0 ? number_format($bilan->moy_eval_semestre2, 2) : '-' }}
                </td>

                {{-- Bilan Compétences --}}
                <td class="cell-note cell-moy">
                    {{ $bilan->moy_competences > 0 ? number_format($bilan->moy_competences, 2) : '-' }}
                </td>

                {{-- Moyenne Générale --}}
                <td class="cell-note cell-general">
                    {{ $bilan->moyenne_generale > 0 ? number_format($bilan->moyenne_generale, 2) : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="16" style="text-align: center; padding: 20px; color: #999;">
                    Aucun étudiant trouvé pour cette spécialité.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Page générée le {{ now()->format('d/m/Y à H:i') }} | {{ config('app.name') }}
    </div>

</body>
</html>