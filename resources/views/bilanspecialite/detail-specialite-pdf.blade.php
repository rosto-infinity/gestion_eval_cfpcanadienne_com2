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
            font-family: 'Arial', sans-serif;
            font-size: 9px;
            color: #333;
            line-height: 1.3;
        }

        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        /* En-tête */
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 3px solid #1e40af;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 16px;
            color: #1e40af;
            margin-bottom: 3px;
        }

        .header p {
            font-size: 10px;
            color: #666;
            margin: 1px 0;
        }

        /* Statistiques */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
            margin-bottom: 15px;
        }

        .stat-box {
            border: 2px solid #e5e7eb;
            border-radius: 4px;
            padding: 6px;
            text-align: center;
            background-color: #f9fafb;
        }

        .stat-box label {
            display: block;
            font-size: 8px;
            font-weight: bold;
            color: #666;
            margin-bottom: 2px;
            text-transform: uppercase;
        }

        .stat-box .value {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
        }

        .stat-box.total { background-color: #dbeafe; border-color: #0284c7; }
        .stat-box.total .value { color: #0284c7; }

        .stat-box.admis { background-color: #dcfce7; border-color: #16a34a; }
        .stat-box.admis .value { color: #16a34a; }

        .stat-box.non-admis { background-color: #fee2e2; border-color: #dc2626; }
        .stat-box.non-admis .value { color: #dc2626; }

        .stat-box.taux { background-color: #f3e8ff; border-color: #a855f7; }
        .stat-box.taux .value { color: #a855f7; }

        .stat-box.moy { background-color: #fef3c7; border-color: #b45309; }
        .stat-box.moy .value { color: #b45309; }

        /* Tableau */
        .table-container {
            margin-bottom: 15px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background-color: #f3f4f6;
        }

        table th {
            border: 1px solid #d1d5db;
            padding: 4px 3px;
            text-align: center;
            font-weight: bold;
            font-size: 8px;
            text-transform: uppercase;
            color: #374151;
        }

        table td {
            border: 1px solid #e5e7eb;
            padding: 4px 3px;
            text-align: center;
            font-size: 8px;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .col-num { width: 25px; font-weight: bold; }
        .col-name { text-align: left; min-width: 120px; font-weight: 500; }
        .col-matricule { width: 60px; font-size: 7px; }

        /* Couleurs de notes */
        .note-excellent { background-color: #dcfce7; color: #166534; font-weight: bold; }
        .note-bon { background-color: #dbeafe; color: #0c4a6e; font-weight: bold; }
        .note-moyen { background-color: #fef3c7; color: #92400e; font-weight: bold; }
        .note-faible { background-color: #fee2e2; color: #991b1b; font-weight: bold; }

        /* Légende */
        .legend {
            margin-top: 10px;
            padding: 8px;
            background-color: #f0fdf4;
            border-left: 3px solid #16a34a;
            font-size: 8px;
            line-height: 1.4;
        }

        .legend h3 {
            font-size: 10px;
            margin-bottom: 5px;
            color: #15803d;
        }

        .legend ul {
            list-style-position: inside;
            color: #166534;
        }

        .legend li {
            margin-bottom: 2px;
        }

        /* Pied de page */
        .footer {
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 7px;
            color: #999;
        }

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

    <!-- Statistiques -->
    {{-- <div class="stats-container">
        <div class="stat-box total">
            <label>Total Étudiants</label>
            <div class="value">{{ $statsGlobales['total_etudiants'] }}</div>
        </div>
        <div class="stat-box admis">
            <label>Admis</label>
            <div class="value">{{ $statsGlobales['total_admis'] }}</div>
        </div>
        <div class="stat-box non-admis">
            <label>Non Admis</label>
            <div class="value">{{ $statsGlobales['total_non_admis'] }}</div>
        </div>
        <div class="stat-box taux">
            <label>Taux Admission</label>
            <div class="value">{{ number_format($statsGlobales['taux_admission'], 1) }}%</div>
        </div>
        <div class="stat-box moy">
            <label>Moy Générale</label>
            <div class="value">{{ number_format($statsGlobales['moyenne_generale'], 2) }}</div>
        </div>
    </div> --}}

    <!-- Tableau des étudiants -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th class="col-num">N°</th>
                    <th class="col-name">Nom et Prénoms</th>
                    <th class="col-matricule">Matricule</th>
                    <th colspan="5" style="background-color: #dbeafe;">Semestre 1 (M1-M5)</th>
                    <th style="background-color: #dbeafe;">Moy S1</th>
                    <th colspan="5" style="background-color: #e0e7ff;">Semestre 2 (M6-M10)</th>
                    <th style="background-color: #e0e7ff;">Moy S2</th>
                    <th style="background-color: #f0fdf4;">Compétences</th>
                    <th style="background-color: #fef3c7; font-weight: bold;">MOY GEN</th>
                </tr>
            </thead>
            <tbody>
                @forelse($etudiants as $index => $data)
                @php
                    $etudiant = $data->etudiant;
                    $evalS1 = $data->evaluations_s1->keyBy('module.code');
                    $evalS2 = $data->evaluations_s2->keyBy('module.code');
                @endphp
                <tr>
                    <td class="col-num">{{ $index + 1 }}</td>
                    <td class="col-name">{{ strtoupper($etudiant->name) }}</td>
                    <td class="col-matricule">{{ $etudiant->matricule }}</td>

                    <!-- Semestre 1 -->
                    @for($i = 1; $i <= 5; $i++)
                    @php
                        $eval = $evalS1->get("M{$i}");
                        $note = $eval?->note ?? null;
                        $class = $note ? ($note >= 10 ? 'note-excellent' : ($note >= 8 ? 'note-bon' : ($note >= 6 ? 'note-moyen' : 'note-faible'))) : '';
                    @endphp
                    <td class="{{ $class }}">{{ $note ? number_format($note, 0) : '-' }}</td>
                    @endfor

                    <td style="background-color: #dbeafe; font-weight: bold;">
                        {{ $data->moy_semestre1 > 0 ? number_format($data->moy_semestre1, 2) : '-' }}
                    </td>

                    <!-- Semestre 2 -->
                    @for($i = 6; $i <= 10; $i++)
                    @php
                        $eval = $evalS2->get("M{$i}");
                        $note = $eval?->note ?? null;
                        $class = $note ? ($note >= 10 ? 'note-excellent' : ($note >= 8 ? 'note-bon' : ($note >= 6 ? 'note-moyen' : 'note-faible'))) : '';
                    @endphp
                    <td class="{{ $class }}">{{ $note ? number_format($note, 0) : '-' }}</td>
                    @endfor

                    <td style="background-color: #e0e7ff; font-weight: bold;">
                        {{ $data->moy_semestre2 > 0 ? number_format($data->moy_semestre2, 2) : '-' }}
                    </td>

                    <td style="background-color: #f0fdf4; font-weight: bold;">
                        {{ $data->moy_competences > 0 ? number_format($data->moy_competences, 2) : '-' }}
                    </td>

                    <td style="background-color: #fef3c7; font-weight: bold; {{ $data->moyenne_generale >= 10 ? 'color: #166534;' : 'color: #991b1b;' }}">
                        {{ $data->moyenne_generale > 0 ? number_format($data->moyenne_generale, 2) : '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="18" style="text-align: center; padding: 15px; color: #999;">
                        Aucun étudiant inscrit
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Légende -->
    <div class="legend">
        <h3>💡 Légende</h3>
        <ul>
            <li><strong>Moy S1 :</strong> Moyenne des modules M1 à M5 (Semestre 1)</li>
            <li><strong>Moy S2 :</strong> Moyenne des modules M6 à M10 (Semestre 2)</li>
            <li><strong>Compétences :</strong> Évaluation pratique des compétences (70%)</li>
            <li><strong>MOY GEN :</strong> [(Moy S1 + Moy S2) / 2 × 30%] + [Compétences × 70%]</li>
            <li><strong>Critère admission :</strong> Moyenne générale ≥ 10/20</li>
        </ul>
    </div>

    <!-- Pied de page -->
    <div class="footer">
        <p>Document généré automatiquement - Données confidentielles</p>
        <p>{{ config('app.name') }} - {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
