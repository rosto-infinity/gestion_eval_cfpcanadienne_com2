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
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #1f2937;
        }

        .container {
            width: 100%;
            padding: 15px;
        }

        /* ============ EN-TÊTE ============ */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .header-left h1 {
            font-size: 22px;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .header-left p {
            font-size: 11px;
            line-height: 1.5;
            opacity: 0.95;
        }

        .header-right {
            text-align: right;
            font-size: 10px;
            opacity: 0.9;
        }

        .header-right strong {
            display: block;
            font-size: 12px;
            margin-top: 5px;
        }

        /* ============ STATISTIQUES ============ */
        .stats-grid {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .stat-card {
            flex: 1;
            min-width: 150px;
            background: white;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #e5e7eb;
            text-align: center;
        }

        .stat-card.primary {
            border-color: #667eea;
            background: #f0f4ff;
        }

        .stat-card.success {
            border-color: #10b981;
            background: #f0fdf4;
        }

        .stat-card.danger {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .stat-label {
            font-size: 8px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 4px;
            letter-spacing: 0.3px;
        }

        .stat-value {
            font-size: 18px;
            font-weight: bold;
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
            font-size: 8px;
            color: #9ca3af;
        }

        /* ============ TABLEAU ============ */
        .table-wrapper {
            background: white;
            border-radius: 5px;
            border: 1px solid #e5e7eb;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .table-header {
            background: #f3f4f6;
            padding: 12px 15px;
            border-bottom: 2px solid #d1d5db;
        }

        .table-header h3 {
            font-size: 12px;
            font-weight: bold;
            color: #1f2937;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }

        thead {
            background: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
        }

        th {
            padding: 10px 6px;
            text-align: center;
            font-size: 8px;
            font-weight: bold;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-right: 1px solid #e5e7eb;
        }

        th:last-child {
            border-right: none;
        }

        th.left {
            text-align: left;
            border-right: 1px solid #e5e7eb;
        }

        td {
            padding: 9px 6px;
            border-bottom: 1px solid #f3f4f6;
            border-right: 1px solid #f3f4f6;
        }

        td:last-child {
            border-right: none;
        }

        td.center {
            text-align: center;
        }

        /* ============ LIGNES DU TABLEAU ============ */
        tbody tr {
            page-break-inside: avoid;
        }

        tbody tr.podium-1 {
            background: #fef3c7;
            border-left: 3px solid #fbbf24;
        }

        tbody tr.podium-2 {
            background: #e0f2fe;
            border-left: 3px solid #0ea5e9;
        }

        tbody tr.podium-3 {
            background: #fee2e2;
            border-left: 3px solid #f87171;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        /* ============ RANG ============ */
        .rank {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            font-weight: bold;
            font-size: 9px;
            color: white;
        }

        .rank.gold {
            background: #fbbf24;
        }

        .rank.silver {
            background: #d1d5db;
            color: #374151;
        }

        .rank.bronze {
            background: #f97316;
        }

        .rank.normal {
            background: #e5e7eb;
            color: #6b7280;
        }

        /* ============ BADGES ============ */
        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.2px;
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
            font-weight: bold;
            padding: 2px 5px;
            border-radius: 3px;
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
            border-radius: 5px;
            border: 1px solid #e5e7eb;
            padding: 15px;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .summary-title {
            font-size: 11px;
            font-weight: bold;
            color: #1f2937;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 12px;
            padding-bottom: 8px;
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
            padding: 8px;
            background: #f9fafb;
            border-radius: 4px;
        }

        .summary-label {
            font-size: 9px;
            color: #6b7280;
            font-weight: 500;
        }

        .summary-value {
            font-size: 10px;
            font-weight: bold;
            color: #1f2937;
        }

        .summary-value.highlight {
            color: #667eea;
        }

        /* ============ FOOTER ============ */
        .footer {
            margin-top: 20px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 8px;
            color: #9ca3af;
            page-break-inside: avoid;
        }

        .footer p {
            margin: 2px 0;
        }

        /* ============ EMPTY STATE ============ */
        .empty-state {
            text-align: center;
            padding: 30px;
            color: #9ca3af;
            font-style: italic;
            background: white;
            border-radius: 5px;
            border: 1px dashed #e5e7eb;
        }

        /* ============ PRINT ============ */
        @media print {
            body {
                background: white;
            }
            .container {
                padding: 10px;
            }
            .table-wrapper {
                page-break-inside: avoid;
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
                        <strong>Année:</strong> {{ $annee ? $annee->libelle : 'Toutes' }}
                        @if($specialite)
                            <br/><strong>Spécialité:</strong> {{ $specialite->intitule }}
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
                            <th style="width: 30px;">Rang</th>
                            <th class="left" style="width: 60px;">Matricule</th>
                            <th class="left" style="width: 130px;">Nom et Prénom</th>
                            <th style="width: 35px;">Spé.</th>
                            <th style="width: 35px;">S1</th>
                            <th style="width: 35px;">S2</th>
                            <th style="width: 40px;">Éval</th>
                            <th style="width: 40px;">Comp</th>
                            <th style="width: 45px;">Moy. Gén.</th>
                            <th style="width: 60px;">Mention</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bilans as $index => $bilan)
                            <tr class="
                                @if($index === 0) podium-1 
                                @elseif($index === 1) podium-2 
                                @elseif($index === 2) podium-3 
                                @endif
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
                                <td class="center">{{ $bilan->user->matricule }}</td>
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
                        <span class="summary-value highlight">
                            {{ $stats['admis'] }} 
                            ({{ $stats['total'] > 0 ? number_format(($stats['admis'] / $stats['total']) * 100, 1) : 0 }}%)
                        </span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Étudiants ajournés</span>
                        <span class="summary-value">
                            {{ $stats['total'] - $stats['admis'] }} 
                            ({{ $stats['total'] > 0 ? number_format((($stats['total'] - $stats['admis']) / $stats['total']) * 100, 1) : 0 }}%)
                        </span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Moyenne de la promotion</span>
                        <span class="summary-value highlight">
                            {{ $stats['moyenne_generale'] ? number_format($stats['moyenne_generale'], 2) : '-' }}/20
                        </span>
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
