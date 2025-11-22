<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relevé de Notes - {{ $user->matricule }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
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
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 10px;
        }
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .header p {
            font-size: 14px;
            opacity: 0.9;
        }
        .info-section {
            background: #f8f9fa;
            padding: 20px;
            margin-bottom: 30px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
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
            font-size: 10px;
            color: #6c757d;
            margin-bottom: 3px;
        }
        .info-value {
            font-size: 14px;
            font-weight: bold;
            color: #212529;
        }
        .semestre-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .semestre-title {
            background: #4CAF50;
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .semestre-title.s2 {
            background: #2196F3;
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
            padding: 12px 8px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
            text-transform: uppercase;
        }
        th.center {
            text-align: center;
        }
        td {
            padding: 10px 8px;
            border-bottom: 1px solid #dee2e6;
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
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-module {
            background: #e3f2fd;
            color: #1976d2;
        }
        .badge-module.s2 {
            background: #e8f5e9;
            color: #388e3c;
        }
        .note-value {
            font-size: 16px;
            font-weight: bold;
        }
        .note-value.pass {
            color: #28a745;
        }
        .note-value.fail {
            color: #dc3545;
        }
        .badge-appreciation {
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 9px;
        }
        .badge-excellent {
            background: #d4edda;
            color: #155724;
        }
        .badge-tres-bien {
            background: #cce5ff;
            color: #004085;
        }
        .badge-bien {
            background: #d1ecf1;
            color: #0c5460;
        }
        .badge-assez-bien {
            background: #fff3cd;
            color: #856404;
        }
        .badge-passable {
            background: #f8d7da;
            color: #721c24;
        }
        .badge-insuffisant {
            background: #f8d7da;
            color: #721c24;
        }
        .moyenne-row {
            background: #e9ecef;
            font-weight: bold;
        }
        .recap-section {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 20px;
            margin-top: 30px;
            border-radius: 8px;
            page-break-inside: avoid;
        }
        .recap-grid {
            display: table;
            width: 100%;
        }
        .recap-cell {
            display: table-cell;
            text-align: center;
            padding: 15px;
            background: white;
            margin: 0 5px;
            border-radius: 8px;
            width: 33.33%;
        }
        .recap-label {
            font-size: 10px;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .recap-value {
            font-size: 20px;
            font-weight: bold;
            color: #495057;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
            text-align: center;
            font-size: 10px;
            color: #6c757d;
        }
        .empty-message {
            text-align: center;
            padding: 40px;
            color: #6c757d;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- En-tête -->
        <div class="header">
            <h1>RELEVÉ DE NOTES</h1>
            <p>Année Académique {{ $user->anneeAcademique->libelle }}</p>
        </div>

        <!-- Informations de l'étudiant -->
        <div class="info-section">
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">Nom et Prénom</div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Matricule</div>
                        <div class="info-value">{{ $user->matricule }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">Spécialité</div>
                        <div class="info-value">{{ $user->specialite->intitule }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Code Spécialité</div>
                        <div class="info-value">{{ $user->specialite->code }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Semestre 1 -->
        <div class="semestre-section">
            <div class="semestre-title">SEMESTRE 1</div>
            
            @if($evaluationsSemestre1->isEmpty())
            <div class="empty-message">Aucune évaluation pour le semestre 1</div>
            @else
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Intitulé du Module</th>
                        <th class="center">Coeff.</th>
                        <th class="center">Note /20</th>
                        <th>Appréciation</th>
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
                        <td>
                            <span class="badge-appreciation 
                                @if($eval->note >= 16) badge-excellent
                                @elseif($eval->note >= 14) badge-tres-bien
                                @elseif($eval->note >= 12) badge-bien
                                @elseif($eval->note >= 10) badge-assez-bien
                                @else badge-insuffisant
                                @endif">
                                {{ $eval->getAppreciation() }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                    @if($moyenneSemestre1)
                    <tr class="moyenne-row">
                        <td colspan="3" style="text-align: right;">MOYENNE SEMESTRE 1:</td>
                        <td class="center">
                            <span class="note-value {{ $moyenneSemestre1 >= 10 ? 'pass' : 'fail' }}">
                                {{ number_format($moyenneSemestre1, 2) }}
                            </span>
                        </td>
                        <td></td>
                    </tr>
                    @endif
                </tbody>
            </table>
            @endif
        </div>

        <!-- Semestre 2 -->
        <div class="semestre-section">
            <div class="semestre-title s2">SEMESTRE 2</div>
            
            @if($evaluationsSemestre2->isEmpty())
            <div class="empty-message">Aucune évaluation pour le semestre 2</div>
            @else
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Intitulé du Module</th>
                        <th class="center">Coeff.</th>
                        <th class="center">Note /20</th>
                        <th>Appréciation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evaluationsSemestre2 as $eval)
                    <tr class="{{ $eval->note >= 10 ? 'success' : 'danger' }}">
                        <td>
                            <span class="badge badge-module s2">{{ $eval->module->code }}</span>
                        </td>
                        <td>{{ $eval->module->intitule }}</td>
                        <td class="center">{{ number_format($eval->module->coefficient, 2) }}</td>
                        <td class="center">
                            <span class="note-value {{ $eval->note >= 10 ? 'pass' : 'fail' }}">
                                {{ number_format($eval->note, 2) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-appreciation 
                                @if($eval->note >= 16) badge-excellent
                                @elseif($eval->note >= 14) badge-tres-bien
                                @elseif($eval->note >= 12) badge-bien
                                @elseif($eval->note >= 10) badge-assez-bien
                                @else badge-insuffisant
                                @endif">
                                {{ $eval->getAppreciation() }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                    @if($moyenneSemestre2)
                    <tr class="moyenne-row">
                        <td colspan="3" style="text-align: right;">MOYENNE SEMESTRE 2:</td>
                        <td class="center">
                            <span class="note-value {{ $moyenneSemestre2 >= 10 ? 'pass' : 'fail' }}">
                                {{ number_format($moyenneSemestre2, 2) }}
                            </span>
                        </td>
                        <td></td>
                    </tr>
                    @endif
                </tbody>
            </table>
            @endif
        </div>

        <!-- Récapitulatif -->
        @if($moyenneSemestre1 && $moyenneSemestre2)
        <div class="recap-section">
            <div class="recap-grid">
                <div class="recap-cell">
                    <div class="recap-label">Moyenne Semestre 1</div>
                    <div class="recap-value">{{ number_format($moyenneSemestre1, 2) }}/20</div>
                </div>
                <div class="recap-cell">
                    <div class="recap-label">Moyenne Semestre 2</div>
                    <div class="recap-value">{{ number_format($moyenneSemestre2, 2) }}/20</div>
                </div>
                <div class="recap-cell">
                    <div class="recap-label">Moyenne Annuelle</div>
                    <div class="recap-value">{{ number_format(($moyenneSemestre1 + $moyenneSemestre2) / 2, 2) }}/20</div>
                </div>
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Date d'édition: {{ now()->format('d/m/Y à H:i') }}</p>
            <p>Ce document est un relevé officiel des notes de l'étudiant(e)</p>
        </div>
    </div>
</body>
</html>