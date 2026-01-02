<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail - {{ $specialite->code }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 9px;
            color: #000; /* Noir pur */
            line-height: 1.3;
            background: #fff; /* Blanc pur */
        }

        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        /* ———————— En-tête ———————— */
        .header {
            padding-top: 20px;
            text-align: center;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #ccc; /* Gris neutre, pas de bleu */
        }

        .header h1 {
            font-size: 16px;
            font-weight: bold;
            color: #000;
            margin-bottom: 3px;
        }

        .header p {
            font-size: 10px;
            color: #444;
            margin: 1px 0;
        }

        /* ———————— Tableau principal ———————— */
        .table-container {
            padding: 30px;
            width: 95%;
            margin-bottom: 15px;
           
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }

        table th,
        table td {
            border: 1px solid #ddd; /* Trait fin gris clair */
            padding: 4px 3px;
            text-align: center;
        }

        table th {
            background-color: #f8f8f8;
            font-weight: bold;
            text-transform: uppercase;
            color: #000;
            font-size: 8px;
        }

        table td {
            color: #000;
        }

        .col-num { width: 20px; font-weight: bold; }
        .col-name { text-align: left; min-width: 120px; font-weight: 500; }
        .col-matricule { width: 60px; font-size: 7px; }

        /* ———————— Couleurs de notes (sobres) ———————— */
        /* On garde les indications, mais en noir/rouge léger */
        .note-excellent { background-color: #f0fff4; color: #000; font-weight: bold; }
        .note-bon        { background-color: #f0f9ff; color: #000; font-weight: bold; }
        .note-moyen      { background-color: #fffbeb; color: #000; font-weight: bold; }
        .note-faible     { background-color: #fff5f5; color: #c00; font-weight: bold; } /* rouge léger */

        /* ———————— Colonnes de moyennes (fond très clair + rouge pour échec) ———————— */
        table td[style*="background-color:"] {
            background-color: #fafafa !important;
            font-weight: bold;
        }

        /* MOY GEN en rouge si < 10 */
        .moy-gen-echec {
            color: #c00; /* rouge léger */
        }

        /* ———————— Légende ———————— */
        .legend {
            margin-top: 12px;
            padding: 8px 10px;
            background-color: #fafafa;
            border-left: 2px solid #c00; /* rouge discret */
            font-size: 8px;
            line-height: 1.4;
        }

        .legend h3 {
            font-size: 10px;
            margin-bottom: 4px;
            color: #000;
            font-weight: bold;
        }

        .legend ul {
            padding-left: 14px;
            color: #333;
        }

        .legend li {
            margin-bottom: 2px;
        }

        /* ———————— Pied de page ———————— */
        .footer {
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 7px;
            color: #666;
        }

        /* ———————— Impressions ———————— */
        @media print {
            body { margin: 0; padding: 0; }
            table { page-break-inside: avoid; }
            thead { display: table-header-group; }
        }
    </style>
</head>
<body>

    <!-- En-tête -->
    <div class="header">
        <h1>DÉTAIL DE LA SPÉCIALITÉ</h1>
        <p><strong>{{ $specialite->code }}</strong> - {{ $specialite->intitule }}</p>
        @if($annee)
        <p>Année académique : {{ $annee->libelle }}</p>
        @endif
        <p>Généré le : {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <!-- Tableau des étudiants -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th class="col-num">N°</th>
                    <th class="col-name">Nom et Prénoms</th>
                    <th class="col-matricule">Matricule</th>
                    <th colspan="5">Semestre 1 (M1–M5)</th>
                    <th>Moy S1</th>
                    <th colspan="5">Semestre 2 (M6–M10)</th>
                    <th>Moy S2</th>
                    <th>Compétences</th>
                    <th>MOY GEN</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bilans as $index => $bilan)
                @php
                    $user = $bilan->user;
                    // Les évaluations viennent du contrôleur, déjà triées par M1..M10
                    $evaluations = $user->evaluations;

                    $evalS1 = $evaluations->filter(fn ($e) => in_array($e->module->code, ['M1', 'M2', 'M3', 'M4', 'M5']))->keyBy('module.code');
                    $evalS2 = $evaluations->filter(fn ($e) => in_array($e->module->code, ['M6', 'M7', 'M8', 'M9', 'M10']))->keyBy('module.code');

                    $isAdmis = isset($bilan->moyenne_generale) && $bilan->moyenne_generale >= 10;
                @endphp
                <tr>
                    <td class="col-num">{{ $index + 1 }}</td>
                    <td class="col-name">{{ strtoupper($user->name) }}</td>
                    <td class="col-matricule">{{ $user->matricule }}</td>

                    <!-- Semestre 1 -->
                    @for($i = 1; $i <= 5; $i++)
                        @php
                            $eval = $evalS1->get("M{$i}");
                            $note = $eval?->note ?? null;
                            $class = '';
                            if ($note !== null) {
                                if ($note >= 10) $class = 'note-excellent';
                                elseif ($note >= 8) $class = 'note-bon';
                                elseif ($note >= 6) $class = 'note-moyen';
                                else $class = 'note-faible';
                            }
                        @endphp
                        <td class="{{ $class }}">{{ $note ? number_format($note, 0) : '-' }}</td>
                    @endfor

                    <td>{{ $bilan->moy_eval_semestre1 > 0 ? number_format($bilan->moy_eval_semestre1, 2) : '-' }}</td>

                    <!-- Semestre 2 -->
                    @for($i = 6; $i <= 10; $i++)
                        @php
                            $eval = $evalS2->get("M{$i}");
                            $note = $eval?->note ?? null;
                            $class = '';
                            if ($note !== null) {
                                if ($note >= 10) $class = 'note-excellent';
                                elseif ($note >= 8) $class = 'note-bon';
                                elseif ($note >= 6) $class = 'note-moyen';
                                else $class = 'note-faible';
                            }
                        @endphp
                        <td class="{{ $class }}">{{ $note ? number_format($note, 0) : '-' }}</td>
                    @endfor

                    <td>{{ $bilan->moy_eval_semestre2 > 0 ? number_format($bilan->moy_eval_semestre2, 2) : '-' }}</td>
                    <td>{{ $bilan->moy_competences > 0 ? number_format($bilan->moy_competences, 2) : '-' }}</td>

                    @php
                        $moyGen = $bilan->moyenne_generale;
                        $moyGenStr = $moyGen > 0 ? number_format($moyGen, 2) : '-';
                        $isEchec = $moyGen > 0 && $moyGen < 10;
                    @endphp
                    <td class="{{ $isEchec ? 'moy-gen-echec' : '' }}">{{ $moyGenStr }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="18" style="text-align: center; padding: 15px; color: #888;">
                        Aucun étudiant inscrit
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Légende -->
    <div class="legend">
        <h3> Légende</h3>
        <ul>
            <li><strong>Moy S1</strong> : Moyenne des modules M1 à M5</li>
            <li><strong>Moy S2</strong> : Moyenne des modules M6 à M10</li>
            <li><strong>Compétences</strong> : Évaluation pratique (70 %)</li>
            <li><strong>MOY GEN</strong> : [(Moy S1 + Moy S2) / 2 × 30 %] + [Compétences × 70 %]</li>
            <li><strong>Admission</strong> : MOY GEN ≥ 10/20</li>
        </ul>
    </div>

    <!-- Pied de page -->
    <div class="footer">
        <p>Document généré automatiquement – Données confidentielles</p>
        <p>{{ config('app.name') }} – {{ now()->format('d/m/Y H:i') }}</p>
    </div>

</body>
</html>