<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau Récapitulatif - {{ $annee ? $annee->libelle : 'Toutes années' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9px;
            line-height: 1.4;
            color: #333;
        }
        .container {
            width: 100%;
            padding: 15px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .header h1 {
            font-size: 22px;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .header p {
            font-size: 12px;
            opacity: 0.95;
        }
        .info-section {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
            border-radius: 5px;
        }
        .info-title {
            font-size: 11px;
            font-weight: bold;
            color: #495057;
            margin-bottom: 10px;
            text-transform: uppercase;
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
            width: 20%;
            text-align: center;
            background: white;
            border-radius: 5px;
        }
        .info-label {
            font-size: 8px;
            color: #6c757d;
            margin-bottom: 3px;
        }
        .info-value {
            font-size: 16px;
            font-weight: bold;
            color: #212529;
        }
        .info-value.success {
            color: #28a745;
        }
        .info-value.primary {
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        thead {
            background: #495057;
            color: white;
        }
        th {
            padding: 8px 4px;
            text-align: center;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #343a40;
        }
        th.left {
            text-align: left;
        }
        td {
            padding: 6px 4px;
            border: 1px solid #dee2e6;
            font-size: 8px;
        }
        td.center {
            text-align: center;
        }
        tr.podium {
            background: #fff3cd;
        }
        tr:hover {
            background: #f8f9fa;
        }
        .rank {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
            font-weight: bold;
            font-size: 10px;
        }
        .rank.gold {
            background: #ffd700;
            color: #000;
        }
        .rank.silver {
            background: #c0c0c0;
            color: #000;
        }
        .rank.bronze {
            background: #cd7f32;
            color: #fff;
        }
        .rank.normal {
            background: #e9ecef;
            color: #495057;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 7px;
            font-weight: bold;
        }
        .badge-info {
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
            font-size: 10px;
            font-weight: bold;
        }
        .note-value.pass {
            color: #28a745;
        }
        .note-value.fail {
            color: #dc3545;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #dee2e6;
            text-align: center;
            font-size: 8px;
            color: #6c757d;
        }
        .stats-summary {
            background: #e3f2fd;
            padding: 12px;
            margin-top: 15px;
            border-radius: 5px;
            border-left: 4px solid #2196f3;
        }
        .stats-summary p {
            font-size: 9px;
            margin-bottom: 3px;
            color: #1976d2;
        }
        .stats-summary strong {
            color: #0d47a1;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- En-tête -->
        <div class="header">
            <h1>🏆 TABLEAU RÉCAPITULATIF DES RÉSULTATS</h1>
            <p>Année Académique: {{ $annee ? $annee->libelle : 'Toutes' }}
            @if($specialite) - Spécialité: {{ $specialite->intitule }} @endif
            </p>
        </div>

        <!-- Statistiques -->
        <div class="info-section">
            <div class="info-title">📊 Statistiques Générales</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">Total étudiants</div>
                        <div class="info-value">{{ $stats['total'] }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Admis</div>
                        <div class="info-value success">{{ $stats['admis'] }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Moy. générale</div>
                        <div class="info-value primary">
                            {{ $stats['moyenne_generale'] ? number_format($stats['moyenne_generale'], 2) : '-' }}
                        </div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Meilleure note</div>
                        <div class="info-value success">
                            {{ $stats['meilleure_moyenne'] ? number_format($stats['meilleure_moyenne'], 2) : '-' }}
                        </div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Note la + basse</div>
                        <div class="info-value" style="color: #dc3545;">
                            {{ $stats['moyenne_la_plus_basse'] ? number_format($stats['moyenne_la_plus_basse'], 2) : '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des résultats -->
        @if($bilans->isEmpty())
        <div style="text-align: center; padding: 30px; color: #6c757d; font-style: italic;">
            Aucun résultat à afficher
        </div>
        @else
        <table>
            <thead>
                <tr>
                    <th style="width: 30px;">Rang</th>
                    <th class="left" style="width: 80px;">Matricule</th>
                    <th class="left" style="width: 150px;">Nom et Prénom</th>
                    <th style="width: 60px;">Spé.</th>
                    <th style="width: 40px;">S1</th>
                    <th style="width: 40px;">S2</th>
                    <th style="width: 50px;">Éval<br/>(30%)</th>
                    <th style="width: 50px;">Comp<br/>(70%)</th>
                    <th style="width: 50px;">Moy.<br/>Gén.</th>
                    <th style="width: 70px;">Mention</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bilans as $index => $bilan)
                <tr class="{{ $index < 3 ? 'podium' : '' }}">
                    <td class="center">
                        @if($index === 0)
                        <span class="rank gold">1</span>
                        @elseif($index === 1)
                        <span class="rank silver">2</span>
                        @elseif($index === 2)
                        <span class="rank bronze">3</span>
                        @else
                        <span class="rank normal">{{ $index + 1 }}</span>
                        @endif
                    </td>
                    <td>{{ $bilan->user->matricule }}</td>
                    <td>{{ $bilan->user->name }}</td>
                    <td class="center">
                        <span class="badge badge-info">{{ $bilan->user->specialite->code }}</span>
                    </td>
                    <td class="center">{{ $bilan->moy_eval_semestre1 ? number_format($bilan->moy_eval_semestre1, 2) : '-' }}</td>
                    <td class="center">{{ $bilan->moy_eval_semestre2 ? number_format($bilan->moy_eval_semestre2, 2) : '-' }}</td>
                    <td class="center">{{ $bilan->moy_evaluations ? number_format($bilan->moy_evaluations, 2) : '-' }}</td>
                    <td class="center">{{ $bilan->moy_competences ? number_format($bilan->moy_competences, 2) : '-' }}</td>
                    <td class="center">
                        <span class="note-value {{ $bilan->moyenne_generale >= 10 ? 'pass' : 'fail' }}">
                            {{ number_format($bilan->moyenne_generale, 2) }}
                        </span>
                    </td>
                    <td class="center">
                        <span class="badge {{ $bilan->isAdmis() ? 'badge-success' : 'badge-danger' }}">
                            {{ $bilan->getMention() }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Résumé des résultats -->
        <div class="stats-summary">
            <p><strong>Résumé:</strong></p>
            <p>• Total d'étudiants: <strong>{{ $stats['total'] }}</strong></p>
            <p>• Étudiants admis: <strong>{{ $stats['admis'] }}</strong> ({{ $stats['total'] > 0 ? number_format(($stats['admis'] / $stats['total']) * 100, 1) : 0 }}%)</p>
            <p>• Étudiants ajournés: <strong>{{ $stats['total'] - $stats['admis'] }}</strong> ({{ $stats['total'] > 0 ? number_format((($stats['total'] - $stats['admis']) / $stats['total']) * 100, 1) : 0 }}%)</p>
            <p>• Moyenne générale de la promotion: <strong>{{ $stats['moyenne_generale'] ? number_format($stats['moyenne_generale'], 2) : '-' }}/20</strong></p>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p><strong>Document généré le:</strong> {{ now()->format('d/m/Y à H:i') }}</p>
            <p>Ce document présente le classement officiel des étudiants par ordre de mérite</p>
            @if($annee)
            <p><strong>Année académique:</strong> {{ $annee->libelle }} ({{ $annee->date_debut->format('d/m/Y') }} - {{ $annee->date_fin->format('d/m/Y') }})</p>
            @endif
        </div>
    </div>
</body>
</html>