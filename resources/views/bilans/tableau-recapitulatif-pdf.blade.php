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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
            font-size: 9px;
            line-height: 1.5;
            color: #1f2937;
            background: #f9fafb;
        }

        .container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        /* ============ EN-TÊTE ============ */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            margin-bottom: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(102, 126, 234, 0.15);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left h1 {
            font-size: 24px;
            margin-bottom: 8px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .header-left p {
            font-size: 12px;
            opacity: 0.9;
            line-height: 1.6;
        }

        .header-right {
            text-align: right;
            font-size: 11px;
            opacity: 0.85;
        }

        .header-right strong {
            display: block;
            font-size: 13px;
            margin-top: 5px;
            opacity: 1;
        }

        /* ============ STATISTIQUES ============ */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
        }

        .stat-card.primary {
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            border-color: #667eea;
        }

        .stat-card.success {
            background: linear-gradient(135deg, #10b98115 0%, #059669 100%);
            border-color: #10b981;
        }

        .stat-card.danger {
            background: linear-gradient(135deg, #ef444415 0%, #dc262615 100%);
            border-color: #ef4444;
        }

        .stat-label {
            font-size: 8px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .stat-value {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .stat-card.primary .stat-value {
            color: #667eea;
        }

        .stat-card.success .stat-value {
            color: #10b981;
        }

        .stat-card.danger .stat-value {
            color: #ef4444;
        }

        .stat-subtext {
            font-size: 7px;
            color: #9ca3af;
        }

        /* ============ TABLEAU ============ */
        .table-wrapper {
            background: white;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .table-header {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            padding: 12px 16px;
            border-bottom: 2px solid #d1d5db;
        }

        .table-header h3 {
            font-size: 12px;
            font-weight: 700;
            color: #1f2937;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
        }

        th {
            padding: 10px 8px;
            text-align: center;
            font-size: 8px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: #f9fafb;
        }

        th.left {
            text-align: left;
        }

        td {
            padding: 10px 8px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 8.5px;
            color: #374151;
        }

        td.center {
            text-align: center;
        }

        /* ============ LIGNES DU TABLEAU ============ */
        tbody tr {
            transition: background-color 0.2s ease;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        tbody tr.podium-1 {
            background: linear-gradient(90deg, #fef3c7 0%, #fef08a 100%);
            border-left: 4px solid #fbbf24;
        }

        tbody tr.podium-2 {
            background: linear-gradient(90deg, #f0f9ff 0%, #e0f2fe 100%);
            border-left: 4px solid #0ea5e9;
        }

        tbody tr.podium-3 {
            background: linear-gradient(90deg, #fef2f2 0%, #fee2e2 100%);
            border-left: 4px solid #f87171;
        }

        /* ============ RANG ============ */
        .rank {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            font-weight: 700;
            font-size: 10px;
            color: white;
        }

        .rank.gold {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            box-shadow: 0 2px 4px rgba(251, 191, 36, 0.3);
        }

        .rank.silver {
            background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
            color: #374151;
            box-shadow: 0 2px 4px rgba(209, 213, 219, 0.3);
        }

        .rank.bronze {
            background: linear-gradient(135deg, #fb923c 0%, #f97316 100%);
            box-shadow: 0 2px 4px rgba(249, 115, 22, 0.3);
        }

        .rank.normal {
            background: #e5e7eb;
            color: #6b7280;
        }

        /* ============ BADGES ============ */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 7px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-code {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-mention {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-mention.fail {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-mention.warning {
            background: #fef3c7;
            color: #92400e;
        }

        /* ============ NOTES ============ */
        .note-value {
            font-size: 9px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
        }

        .note-value.pass {
            background: #dcfce7;
            color: #15803d;
        }

        .note-value.fail {
            background: #fee2e2;
            color: #991b1b;
        }

        .note-value.warning {
            background: #fef3c7;
            color: #92400e;
        }

        /* ============ RÉSUMÉ ============ */
        .summary-section {
            background: white;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            padding: 20px;
            margin-bottom: 20px;
        }

        .summary-title {
            font-size: 11px;
            font-weight: 700;
            color: #1f2937;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-label {
            font-size: 8px;
            color: #6b7280;
        }

        .summary-value {
            font-size: 10px;
            font-weight: 700;
            color: #1f2937;
        }

        .summary-value.highlight {
            color: #667eea;
        }

        /* ============ FOOTER ============ */
        .footer {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 7px;
            color: #9ca3af;
        }

        .footer p {
            margin: 3px 0;
        }

        .footer strong {
            color: #6b7280;
        }

        /* ============ EMPTY STATE ============ */
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #9ca3af;
            font-style: italic;
            background: white;
            border-radius: 10px;
            border: 1px dashed #e5e7eb;
        }

        /* ============ RESPONSIVE ============ */
        @media print {
            body {
                background: white;
            }
            .container {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- EN-TÊTE -->
        <div class="header">
            <div class="header-content">
                <div class="header-left">
                    <h1>🏆 Tableau Récapitulatif</h1>
                    <p>
                        Année: <strong>{{ $annee ? $annee->libelle : 'Toutes' }}</strong>
                        @if($specialite)
                        <br/>Spécialité: <strong>{{ $specialite->intitule }}</strong>
                        @endif
                    </p>
                </div>
                <div class="header-right">
                    <p>Résultats Officiels</p>
                    <strong>{{ now()->format('d/m/Y') }}</strong>
                </div>
            </div>
        </div>

        <!-- STATISTIQUES -->
        <div class="stats-grid">
            <div class="stat-card primary">
                <div class="stat-label">📊 Total</div>
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-subtext">Étudiants</div>
            </div>

            <div class="stat-card success">
                <div class="stat-label">✓ Admis</div>
                <div class="stat-value">{{ $stats['admis'] }}</div>
                <div class="stat-subtext">
                    {{ $stats['total'] > 0 ? number_format(($stats['admis'] / $stats['total']) * 100, 1) : 0 }}%
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-label">📈 Moyenne</div>
                <div class="stat-value">{{ $stats['moyenne_generale'] ? number_format($stats['moyenne_generale'], 2) : '-' }}</div>
                <div class="stat-subtext">Générale</div>
            </div>

            <div class="stat-card success">
                <div class="stat-label">🎯 Meilleure</div>
                <div class="stat-value">{{ $stats['meilleure_moyenne'] ? number_format($stats['meilleure_moyenne'], 2) : '-' }}</div>
                <div class="stat-subtext">Note</div>
            </div>

            <div class="stat-card danger">
                <div class="stat-label">⬇️ Plus basse</div>
                <div class="stat-value">{{ $stats['moyenne_la_plus_basse'] ? number_format($stats['moyenne_la_plus_basse'], 2) : '-' }}</div>
                <div class="stat-subtext">Note</div>
            </div>
        </div>

        <!-- TABLEAU -->
        @if($bilans->isEmpty())
        <div class="empty-state">
            <p>Aucun résultat à afficher</p>
        </div>
        @else
        <div class="table-wrapper">
            <div class="table-header">
                <h3>📋 Classement des Étudiants</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 35px;">Rang</th>
                        <th class="left" style="width: 70px;">Matricule</th>
                        <th class="left" style="width: 140px;">Nom et Prénom</th>
                        <th style="width: 50px;">Spé.</th>
                        <th style="width: 40px;">S1</th>
                        <th style="width: 40px;">S2</th>
                        <th style="width: 45px;">Éval<br/>(30%)</th>
                        <th style="width: 45px;">Comp<br/>(70%)</th>
                        <th style="width: 50px;">Moy.<br/>Gén.</th>
                        <th style="width: 65px;">Mention</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bilans as $index => $bilan)
                    <tr class="
                        @if($index === 0) podium-1 @elseif($index === 1) podium-2 @elseif($index === 2) podium-3 @endif
                    ">
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
                            <span class="badge badge-code">{{ $bilan->user->specialite->code }}</span>
                        </td>
                        <td class="center">
                            {{ $bilan->moy_eval_semestre1 ? number_format($bilan->moy_eval_semestre1, 2) : '-' }}
                        </td>
                        <td class="center">
                            {{ $bilan->moy_eval_semestre2 ? number_format($bilan->moy_eval_semestre2, 2) : '-' }}
                        </td>
                        <td class="center">
                            {{ $bilan->moy_evaluations ? number_format($bilan->moy_evaluations, 2) : '-' }}
                        </td>
                        <td class="center">
                            {{ $bilan->moy_competences ? number_format($bilan->moy_competences, 2) : '-' }}
                        </td>
                        <td class="center">
                            <span class="note-value 
                                @if($bilan->moyenne_generale >= 14) pass
                                @elseif($bilan->moyenne_generale >= 10) warning
                                @else fail
                                @endif
                            ">
                                {{ number_format($bilan->moyenne_generale, 2) }}
                            </span>
                        </td>
                        <td class="center">
                            <span class="badge badge-mention {{ $bilan->isAdmis() ? '' : 'fail' }}">
                                {{ $bilan->getMention() }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- RÉSUMÉ -->
        <div class="summary-section">
            <div class="summary-title">📊 Résumé des Résultats</div>
            <div class="summary-grid">
                <div class="summary-item">
                    <span class="summary-label">Total d'étudiants</span>
                    <span class="summary-value">{{ $stats['total'] }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Étudiants admis</span>
                    <span class="summary-value highlight">{{ $stats['admis'] }} ({{ $stats['total'] > 0 ? number_format(($stats['admis'] / $stats['total']) * 100, 1) : 0 }}%)</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Étudiants ajournés</span>
                    <span class="summary-value">{{ $stats['total'] - $stats['admis'] }} ({{ $stats['total'] > 0 ? number_format((($stats['total'] - $stats['admis']) / $stats['total']) * 100, 1) : 0 }}%)</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Moyenne de la promotion</span>
                    <span class="summary-value highlight">{{ $stats['moyenne_generale'] ? number_format($stats['moyenne_generale'], 2) : '-' }}/20</span>
                </div>
            </div>
        </div>
        @endif

        <!-- FOOTER -->
        <div class="footer">
            <p><strong>Généré le:</strong> {{ now()->format('d/m/Y à H:i') }}</p>
            <p>Document officiel - Classement par ordre de mérite</p>
            @if($annee)
            <p><strong>Période:</strong> {{ $annee->date_debut->format('d/m/Y') }} - {{ $annee->date_fin->format('d/m/Y') }}</p>
            @endif
        </div>

    </div>
</body>
</html>
