<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau Récapitulatif - {{ $annee ? $annee->libelle : 'Toutes années' }}</title>
    <style>
        /* ============ GLOBAL & PAGE SETTINGS ============ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #000000; /* Noir pur */
            background: #ffffff;
        }

        @page {
            size: A4 landscape;
            margin: 10mm 15mm; /* Marges ajustées pour l'impression */
        }

        .container {
            padding: 20px;
            width: 95%;
            max-width: 98%;
        }

        /* ============ EN-TÊTE MINIMALISTE ============ */
        .header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #dc2626; /* Ligne rouge */
        }

        .header h1 {
            font-size: 24px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 5px;
            color: #000;
        }

        .header-subtitle {
            font-size: 11px;
            color: #6b7280; /* Gris moyen */
            font-weight: 400;
        }

        .header-right {
            float: right;
            text-align: right;
            font-size: 10px;
            color: #6b7280;
        }

        .header-right strong {
            display: block;
            font-size: 12px;
            color: #000;
            margin-top: 2px;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

       .stats-table {
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
    border-collapse: collapse;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    font-size: 14px;
    color: #333;
}

.stats-table th,
.stats-table td {
    padding: 10px 12px;
    text-align: center;
    border: 1px solid #e0e0e0; /* Trait fin et subtil */
}

.stats-table th {
    font-weight: 600;
    background-color: #fafafa;
    color: #555;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stats-table td.highlight {
    font-weight: 600;
    color: #2e7d32; /* Vert discret pour mise en valeur */
}

        /* ============ TABLEAU ============ */
        .table-wrapper {
            padding: 20px;
            width: 95%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px; /* Police plus petite pour tenir sur une page */
            color: #000;
        }

        thead {
            background-color: #dc2626; /* Fond Rouge */
            color: #fff;
        }

        th {
            padding: 8px 4px;
            text-align: center;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 9px;
            letter-spacing: 0.5px;
            border-right: 1px solid rgba(255,255,255,0.2);
        }

        th:last-child {
            border-right: none;
        }

        th.text-left {
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: #f9fafb; /* Gris très clair pour Zebra striping */
        }

        td {
            padding: 6px 4px;
            border-right: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        td:last-child {
            border-right: none;
        }

        td.text-center {
            text-align: center;
        }
        
        td.text-left {
            text-align: left;
        }

        /* Styles pour les rangs (Pas de couleurs dorées, juste gras) */
        .rank {
            font-weight: bold;
            font-size: 10px;
        }
        
        .rank-1, .rank-2, .rank-3 {
            text-decoration: underline;
            text-decoration-color: #dc2626;
        }

        /* Styles pour les mentions (Texte simple) */
        .mention-admis {
            font-weight: bold;
            color: #000;
        }

        .mention-ajourne {
            font-weight: bold;
            color: #000;
            text-decoration: underline;
            text-decoration-style: double;
        }

        /* Bordure rouge pour la note finale si < 10 */
        .fail-border {
            border: 1px solid #dc2626;
        }
.summary-table {
    width: 100%;
    max-width: 800px;
    margin: 16px auto 0;
    border-collapse: collapse;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    font-size: 14px;
    color: #333;
}

.summary-table th,
.summary-table td {
    padding: 10px 12px;
    text-align: center;
    border: 1px solid #e0e0e0; /* Trait fin et élégant */
}

.summary-table th {
    font-weight: 600;
    background-color: #fafafa;
    color: #555;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Optionnel : ajouter un léger fond pour distinguer le titre si tu veux garder "Répartition des Résultats" */
        /* ============ FOOTER ============ */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #000;
            text-align: center;
            font-size: 8px;
            color: #6b7280;
        }
        
        .footer strong {
            color: #000;
        }

       

    </style>
</head>
<body>
    <div class="container">

        <!-- EN-TÊTE -->
        <div class="header">
            <div class="header-right">
                <p>Résultats Officiels</p>
                <strong>{{ now()->format('d/m/Y') }}</strong>
            </div>
            <h1>Tableau Récapitulatif</h1>
            <p class="header-subtitle">
                Année de Formation Professionnelle : <strong>{{ $annee ? $annee->libelle : 'Toutes' }}</strong>
                @if($specialite)
                    | Spécialité : <strong>{{ $specialite->intitule }}</strong>
                @endif
            </p>
            <div class="clearfix"></div>
        </div>

        <!-- STATS BAR (Minimaliste) -->
     <table class="stats-table">
    <thead>
        <tr>
            <th>Total Apprenants</th>
            <th>Taux de Réussite</th>
            <th>Moyenne Promotion</th>
            <th>Meilleure Moyenne</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $stats['total'] }}</td>
            <td class="highlight">
                {{ $stats['total'] > 0 ? number_format(($stats['admis'] / $stats['total']) * 100, 1) : 0 }}%
            </td>
            <td>{{ $stats['moyenne_generale'] ? number_format($stats['moyenne_generale'], 2) : '-' }}</td>
            <td>{{ $stats['meilleure_moyenne'] ?? '-' }}</td>
        </tr>
    </tbody>
</table>

        <!-- TABLEAU PRINCIPAL -->
        @if($bilans->isEmpty())
            <div style="text-align: center; padding: 50px; border: 1px solid #ddd; margin-top: 20px;">
                <p>Aucun résultat à afficher</p>
            </div>
        @else
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 5%">Rang</th>
                            <th class="text-left" style="width: 12%">Matricule</th>
                            <th class="text-left" style="width: 25%">Nom & Prénom</th>
                            <th style="width: 10%">Spé.</th>
                            <th style="width: 7%">S1</th>
                            <th style="width: 7%">S2</th>
                            <th style="width: 7%">Éval</th>
                            <th style="width: 7%">Comp</th>
                            <th style="width: 10%">Moy. Gén.</th>
                            <th style="width: 10%">Décision</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bilans as $index => $bilan)
                        <tr>
                            <!-- Rang -->
                            <td class="text-center">
                                @if($index < 3)
                                    <span class="rank rank-{{ $index + 1 }}">{{ $index + 1 }}</span>
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </td>

                            <!-- Matricule -->
                            <td>{{ $bilan->user->matricule }}</td>

                            <!-- Nom -->
                            <td class="text-left">
                                <strong>{{ strtoupper($bilan->user->name) }}</strong>
                            </td>

                            <!-- Spécialité -->
                            <td class="text-center">{{ $bilan->user->specialite->code }}</td>

                            <!-- Notes -->
                            <td class="text-center">{{ $bilan->moy_eval_semestre1 ? number_format($bilan->moy_eval_semestre1, 2) : '-' }}</td>
                            <td class="text-center">{{ $bilan->moy_eval_semestre2 ? number_format($bilan->moy_eval_semestre2, 2) : '-' }}</td>
                            <td class="text-center">{{ $bilan->moy_evaluations ? number_format($bilan->moy_evaluations, 2) : '-' }}</td>
                            <td class="text-center">{{ $bilan->moy_competences ? number_format($bilan->moy_competences, 2) : '-' }}</td>

                            <!-- Moyenne Générale -->
                            <td class="text-center">
                                <span class="{{ $bilan->moyenne_generale < 10 ? 'fail-border' : '' }} block px-1">
                                    {{ number_format($bilan->moyenne_generale, 2) }}
                                </span>
                            </td>

                            <!-- Décision -->
                            <td class="text-center">
                                @if($bilan->isAdmis())
                                    <span class="mention-admis">{{ $bilan->getMention() }}</span>
                                @else
                                    <span class="mention-ajourne">{{ $bilan->getMention() }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- RÉSUMÉ EN BAS DE PAGE -->
           <table class="summary-table">
    <thead>
        <tr>
            <th>Admis (≥10)</th>
            <th>Ajournés (&lt;10)</th>
            <th>Mention Très Bien</th>
            <th>Mention Bien</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $stats['admis'] }}</td>
            <td>{{ $stats['total'] - $stats['admis'] }}</td>
            <td>{{ $bilans->filter(fn($b) => $b->moyenne_generale >= 16)->count() }}</td>
            <td>{{ $bilans->filter(fn($b) => $b->moyenne_generale >= 14 && $b->moyenne_generale < 16)->count() }}</td>
        </tr>
    </tbody>
</table>
        @endif

        <!-- FOOTER -->
        <div class="footer">
            <p><strong>Généré automatiquement le :</strong> {{ now()->format('d/m/Y à H:i') }}</p>
            <p>Document officiel | CFPC Canadienne - Système de Gestion</p>
            @if($annee)
                <p><strong>Période concernée :</strong> {{ $annee->date_debut->format('d/m/Y') }} au {{ $annee->date_fin->format('d/m/Y') }}</p>
            @endif
        </div>

    </div>
</body>
</html>