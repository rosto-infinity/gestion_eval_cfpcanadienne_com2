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
            padding: 12px;
        }

        /* ============ EN-TÊTE ============ */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 18px;
            margin-bottom: 18px;
            border-radius: 5px;
            text-align: center;
        }

        .header h1 {
            font-size: 20px;
            margin-bottom: 6px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .header p {
            font-size: 10px;
            opacity: 0.95;
            margin: 2px 0;
            line-height: 1.4;
        }

        /* ============ INFORMATIONS ÉTUDIANT ============ */
        .info-section {
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
            background: #2196F3;
            color: white;
            padding: 8px 12px;
            font-size: 11px;
            font-weight: bold;
            margin: 12px 0 8px 0;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .section-title.semestre2 {
            background: #FF9800;
        }

        .section-title.general {
            background: #667eea;
        }

        /* ============ TABLEAU ============ */
        table {
            width: 100%;
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
            background: white;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
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
            padding: 10px;
            background: linear-gradient(135deg, #f0fdf4 0%, #f8f9fa 100%);
            border-radius: 4px;
            border: 1px solid #e5e7eb;
            margin-right: 6px;
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

        /* ============ FOOTER ============ */
        .footer {
            margin-top: 18px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 8px;
            color: #9ca3af;
            page-break-inside: avoid;
        }

        .footer p {
            margin: 2px 0;
            line-height: 1.3;
        }

        /* ============ PRINT ============ */
        @media print {
            body {
                background: white;
            }
            .container {
                padding: 8px;
            }
            table {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- EN-TÊTE -->
        <div class="header">
            <h1>📋 RELEVÉ DE NOTES</h1>
            <p><strong>{{ $user->name }}</strong></p>
            <p>Matricule: <strong>{{ $user->matricule }}</strong></p>
        </div>

        <!-- INFORMATIONS ÉTUDIANT -->
        <div class="info-section">
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">Matricule</div>
                        <div class="info-value">
                            <span class="badge-code">{{ $user->matricule }}</span>
                        </div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Nom Complet</div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Spécialité</div>
                        <div class="info-value">{{ $user->specialite->intitule ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">Année Académique</div>
                        <div class="info-value">{{ $user->anneeAcademique->libelle ?? 'N/A' }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Date d'Édition</div>
                        <div class="info-value">{{ now()->format('d/m/Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEMESTRE 1 -->
        @if($evaluationsSemestre1->isNotEmpty())
            <div class="section-title">SEMESTRE 1</div>
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
                    @foreach($evaluationsSemestre1 as $evaluation)
                        @php
                            $note = $evaluation->note ?? 0;
                            $coefficient = $evaluation->module->coefficient ?? 1;
                            $totalCoefficients1 += $coefficient;
                            $sommeNotesPonderees1 += ($note * $coefficient);
                            
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
                            @if($moyenneSemestre1 >= 10)
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
        @if($evaluationsSemestre2->isNotEmpty())
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
                    @foreach($evaluationsSemestre2 as $evaluation)
                        @php
                            $note = $evaluation->note ?? 0;
                            $coefficient = $evaluation->module->coefficient ?? 1;
                            $totalCoefficients2 += $coefficient;
                            $sommeNotesPonderees2 += ($note * $coefficient);
                            
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
                            @if($moyenneSemestre2 >= 10)
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

        <!-- RÉSUMÉ GÉNÉRAL -->
        @if($evaluationsSemestre1->isNotEmpty() || $evaluationsSemestre2->isNotEmpty())
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
                        <div class="stats-value" style="color: {{ ($moyenneGenerale ?? 0) >= 10 ? '#10b981' : '#ef4444' }}">
                            {{ ($moyenneGenerale ?? 0) >= 10 ? 'ADMIS' : 'NON ADMIS' }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- FOOTER -->
        <div class="footer">
            <p><strong>Généré le:</strong> {{ now()->format('d/m/Y à H:i') }}</p>
            <p>Document officiel - Relevé de notes de l'étudiant {{ $user->matricule }}</p>
            <p>Centre de Formation Professionnelle la Canadienne - Bafoussam</p>
        </div>

    </div>
</body>
</html>