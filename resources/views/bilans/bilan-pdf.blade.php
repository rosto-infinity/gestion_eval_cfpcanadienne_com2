<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bilan de Compétences - {{ $bilan->user->matricule }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.6;
            color: #333;
        }
        .container {
            width: 100%;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            text-align: center;
            margin-bottom: 25px;
            border-radius: 8px;
        }
        .header h1 {
            font-size: 26px;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .header p {
            font-size: 13px;
            opacity: 0.95;
        }
        .student-info {
            background: #f8f9fa;
            padding: 20px;
            margin-bottom: 25px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            page-break-inside: avoid;
        }
        .info-grid {
            display: table;
            width: 100%;
        }
        .info-row {
            display: table-row;
        }
        .info-cell {
            display: table-cell;
            padding: 8px;
            width: 50%;
        }
        .info-label {
            font-size: 9px;
            color: #6c757d;
            text-transform: uppercase;
            margin-bottom: 3px;
            font-weight: bold;
        }
        .info-value {
            font-size: 13px;
            font-weight: bold;
            color: #212529;
        }
        .results-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .results-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .result-cell {
            display: table-cell;
            padding: 15px;
            text-align: center;
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            width: 33.33%;
        }
        .result-cell.highlight {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border: 2px solid #28a745;
        }
        .result-cell.danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border: 2px solid #dc3545;
        }
        .result-label {
            font-size: 9px;
            color: #6c757d;
            text-transform: uppercase;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .result-value {
            font-size: 28px;
            font-weight: bold;
            color: #495057;
        }
        .result-value.success {
            color: #28a745;
        }
        .result-value.danger {
            color: #dc3545;
        }
        .section-title {
            background: #495057;
            color: white;
            padding: 10px 15px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .calculation-box {
            background: #f8f9fa;
            padding: 12px;
            margin-bottom: 10px;
            border-left: 4px solid #007bff;
            border-radius: 4px;
        }
        .calculation-box.purple {
            border-left-color: #6f42c1;
        }
        .calculation-box.final {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left-color: #28a745;
            border: 2px solid #28a745;
            padding: 15px;
        }
        .calc-row {
            display: table;
            width: 100%;
            margin-bottom: 5px;
        }
        .calc-label {
            display: table-cell;
            font-size: 10px;
            color: #495057;
            font-weight: 600;
        }
        .calc-value {
            display: table-cell;
            text-align: right;
            font-size: 13px;
            font-weight: bold;
            color: #007bff;
        }
        .calc-value.final {
            font-size: 20px;
            color: #28a745;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        thead {
            background: #f8f9fa;
        }
        th {
            padding: 10px 8px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
            text-transform: uppercase;
        }
        th.center {
            text-align: center;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #dee2e6;
            font-size: 10px;
        }
        td.center {
            text-align: center;
        }
        tr.success {
            background: #d4edda;
        }
        tr.danger {
            background: #f8d7da;
        }
        tr.moyenne-row {
            background: #e9ecef;
            font-weight: bold;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
        }
        .badge-module {
            background: #cfe2ff;
            color: #084298;
        }
        .badge-success {
            background: #d1e7dd;
            color: #0f5132;
        }
        .badge-danger {
            background: #f8d7da;
            color: #842029;
        }
        .note-value {
            font-size: 14px;
            font-weight: bold;
        }
        .note-value.pass {
            color: #28a745;
        }
        .note-value.fail {
            color: #dc3545;
        }
        .empty-message {
            text-align: center;
            padding: 30px;
            color: #6c757d;
            font-style: italic;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .observations-box {
            background: #fff3cd;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #ffc107;
            border-radius: 4px;
            page-break-inside: avoid;
        }
        .observations-title {
            font-size: 11px;
            font-weight: bold;
            color: #856404;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .observations-text {
            font-size: 10px;
            color: #856404;
            line-height: 1.8;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #dee2e6;
            text-align: center;
            font-size: 9px;
            color: #6c757d;
        }
        .mention-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: bold;
            margin-top: 5px;
        }
        .mention-badge.tres-bien {
            background: #d1e7dd;
            color: #0f5132;
        }
        .mention-badge.bien {
            background: #cfe2ff;
            color: #084298;
        }
        .mention-badge.assez-bien {
            background: #fff3cd;
            color: #856404;
        }
        .mention-badge.passable {
            background: #ffecb5;
            color: #664d03;
        }
        .mention-badge.ajourne {
            background: #f8d7da;
            color: #842029;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- En-tête -->
        <div class="header">
            <h1>BILAN DE COMPÉTENCES</h1>
            <p>Année Académique {{ $bilan->anneeAcademique->libelle }}</p>
        </div>

        <!-- Informations de l'étudiant -->
        <div class="student-info">
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">Nom et Prénom</div>
                        <div class="info-value">{{ $bilan->user->name }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Matricule</div>
                        <div class="info-value">{{ $bilan->user->matricule }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">Spécialité</div>
                        <div class="info-value">{{ $bilan->user->specialite->intitule }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Code Spécialité</div>
                        <div class="info-value">{{ $bilan->user->specialite->code }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Résultats principaux -->
        <div class="results-section">
            <div class="results-grid">
                <div class="result-cell purple">
                    <div class="result-label">Moy. Compétences (70%)</div>
                    <div class="result-value">{{ number_format($bilan->moy_competences, 2) }}</div>
                    <div style="font-size: 9px; color: #6c757d; margin-top: 3px;">/20</div>
                </div>
                <div class="result-cell {{ $bilan->moyenne_generale >= 10 ? 'highlight' : 'danger' }}">
                    <div class="result-label">Moyenne Générale</div>
                    <div class="result-value {{ $bilan->moyenne_generale >= 10 ? 'success' : 'danger' }}">
                        {{ number_format($bilan->moyenne_generale, 2) }}
                    </div>
                    <div style="font-size: 9px; color: #6c757d; margin-top: 3px;">/20</div>
                </div>
                <div class="result-cell">
                    <div class="result-label">Mention</div>
                    @php
                        $mention = $bilan->getMention();
                        $mentionClass = match($mention) {
                            'Très Bien' => 'tres-bien',
                            'Bien' => 'bien',
                            'Assez Bien' => 'assez-bien',
                            'Passable' => 'passable',
                            default => 'ajourne'
                        };
                    @endphp
                    <div class="mention-badge {{ $mentionClass }}">{{ $mention }}</div>
                    <div style="font-size: 9px; margin-top: 5px;">
                        @if($bilan->moyenne_generale >= 10)
                            ✅ Admis
                        @else
                            ❌ Ajourné
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Détail du calcul -->
        <div class="section-title">📊 DÉTAIL DU CALCUL</div>

        @php
            $moyS1 = $evaluationsSemestre1->avg('note') ?? 0;
            $moyS2 = $evaluationsSemestre2->avg('note') ?? 0;
            $moyEval = ($moyS1 + $moyS2) / 2;
            $contribEval = $moyEval * 0.30;
            $contribComp = $bilan->moy_competences * 0.70;
        @endphp

        <div class="calculation-box">
            <div class="calc-row">
                <div class="calc-label">Moyenne Évaluations Semestre 1</div>
                <div class="calc-value">{{ number_format($moyS1, 2) }}/20</div>
            </div>
            <div class="calc-row">
                <div class="calc-label" style="font-size: 9px; color: #6c757d;">
                    ({{ $evaluationsSemestre1->count() }} évaluation(s))
                </div>
            </div>
        </div>

        <div class="calculation-box">
            <div class="calc-row">
                <div class="calc-label">Moyenne Évaluations Semestre 2</div>
                <div class="calc-value">{{ number_format($moyS2, 2) }}/20</div>
            </div>
            <div class="calc-row">
                <div class="calc-label" style="font-size: 9px; color: #6c757d;">
                    ({{ $evaluationsSemestre2->count() }} évaluation(s))
                </div>
            </div>
        </div>

        <div class="calculation-box">
            <div class="calc-row">
                <div class="calc-label">Moyenne Générale Évaluations (30%)</div>
                <div class="calc-value">{{ number_format($moyEval, 2) }}/20</div>
            </div>
            <div class="calc-row">
                <div class="calc-label" style="font-size: 9px; color: #6c757d;">
                    Contribution: {{ number_format($contribEval, 2) }} points
                </div>
            </div>
        </div>

        <div class="calculation-box purple">
            <div class="calc-row">
                <div class="calc-label">Moyenne Compétences (70%)</div>
                <div class="calc-value" style="color: #6f42c1;">{{ number_format($bilan->moy_competences, 2) }}/20</div>
            </div>
            <div class="calc-row">
                <div class="calc-label" style="font-size: 9px; color: #6c757d;">
                    Contribution: {{ number_format($contribComp, 2) }} points
                </div>
            </div>
        </div>

        <div class="calculation-box final">
            <div class="calc-row">
                <div class="calc-label" style="font-size: 12px; color: #155724;">MOYENNE GÉNÉRALE FINALE</div>
                <div class="calc-value final">{{ number_format($bilan->moyenne_generale, 2) }}/20</div>
            </div>
        </div>

        <!-- Évaluations Semestre 1 -->
        <div class="section-title">📚 ÉVALUATIONS SEMESTRE 1</div>
        
        @if($evaluationsSemestre1->isEmpty())
        <div class="empty-message">Aucune évaluation pour le semestre 1</div>
        @else
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Intitulé du Module</th>
                    <th class="center">Coef.</th>
                    <th class="center">Note /20</th>
                    <th class="center">Résultat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($evaluationsSemestre1 as $eval)
                <tr class="{{ $eval->note >= 10 ? 'success' : 'danger' }}">
                    <td>
                        <span class="badge badge-module">{{ $eval->module->code }}</span>
                    </td>
                    <td>{{ $eval->module->intitule }}</td>
                    <td class="center">{{ number_format($eval->module->coefficient, 2) }}</td>
                    <td class="center">
                        <span class="note-value {{ $eval->note >= 10 ? 'pass' : 'fail' }}">
                            {{ number_format($eval->note, 2) }}
                        </span>
                    </td>
                    <td class="center">
                        <span class="badge {{ $eval->note >= 10 ? 'badge-success' : 'badge-danger' }}">
                            {{ $eval->note >= 10 ? '✓ Validé' : '✗ Non validé' }}
                        </span>
                    </td>
                </tr>
                @endforeach
                <tr class="moyenne-row">
                    <td colspan="3" style="text-align: right;">MOYENNE SEMESTRE 1:</td>
                    <td class="center">
                        <span class="note-value {{ $moyS1 >= 10 ? 'pass' : 'fail' }}">
                            {{ number_format($moyS1, 2) }}
                        </span>
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        @endif

        <!-- Évaluations Semestre 2 -->
        <div class="section-title" style="background: #007bff;">📚 ÉVALUATIONS SEMESTRE 2</div>
        
        @if($evaluationsSemestre2->isEmpty())
        <div class="empty-message">Aucune évaluation pour le semestre 2</div>
        @else
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Intitulé du Module</th>
                    <th class="center">Coef.</th>
                    <th class="center">Note /20</th>
                    <th class="center">Résultat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($evaluationsSemestre2 as $eval)
                <tr class="{{ $eval->note >= 10 ? 'success' : 'danger' }}">
                    <td>
                        <span class="badge badge-module">{{ $eval->module->code }}</span>
                    </td>
                    <td>{{ $eval->module->intitule }}</td>
                    <td class="center">{{ number_format($eval->module->coefficient, 2) }}</td>
                    <td class="center">
                        <span class="note-value {{ $eval->note >= 10 ? 'pass' : 'fail' }}">
                            {{ number_format($eval->note, 2) }}
                        </span>
                    </td>
                    <td class="center">
                        <span class="badge {{ $eval->note >= 10 ? 'badge-success' : 'badge-danger' }}">
                            {{ $eval->note >= 10 ? '✓ Validé' : '✗ Non validé' }}
                        </span>
                    </td>
                </tr>
                @endforeach
                <tr class="moyenne-row">
                    <td colspan="3" style="text-align: right;">MOYENNE SEMESTRE 2:</td>
                    <td class="center">
                        <span class="note-value {{ $moyS2 >= 10 ? 'pass' : 'fail' }}">
                            {{ number_format($moyS2, 2) }}
                        </span>
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        @endif

        <!-- Observations -->
        @if($bilan->observations)
        <div class="observations-box">
            <div class="observations-title">📝 Observations</div>
            <div class="observations-text">{{ $bilan->observations }}</div>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p><strong>Date d'édition:</strong> {{ now()->format('d/m/Y à H:i') }}</p>
            <p>Ce document est un bilan officiel de compétences de l'étudiant(e)</p>
            <p style="margin-top: 5px;"><strong>Dernière mise à jour:</strong> {{ $bilan->updated_at->format('d/m/Y à H:i') }}</p>
        </div>
    </div>
</body>
</html>