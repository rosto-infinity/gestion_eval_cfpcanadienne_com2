<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Attestation(s) de Fin de Formation</title>
    <style>
        @page {
            size: a4 landscape;
            margin: 0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'DejaVu Sans', 'Helvetica', Arial, sans-serif;
            color: #111;
            -webkit-print-color-adjust: exact;
        }

        .page-container {
            position: relative;
            width: 297mm;
            height: 209.5mm;
            overflow: hidden;
            page-break-inside: avoid;
            box-sizing: border-box;
        }

        .page-recto {
            page-break-after: always;
        }

        .page-verso {
            background-color: #ffffff;
            box-sizing: border-box;
            page-break-inside: avoid;
        }

        .page-break-next-student {
            page-break-after: always;
        }

        /* ==================== CADRE ROUGE VERSO (#ff0000) ==================== */
        .verso-cadre-exterieur {
            position: absolute;
            top: 4.5mm;
            left: 5.5mm;
            width: 286mm;
            height: 201mm;
            border: 2.8px solid #ff0000;
            box-sizing: border-box;
        }

        .verso-cadre-interieur {
            position: absolute;
            top: 6.5mm;
            left: 7.5mm;
            width: 282mm;
            height: 197mm;
            border: 1px solid #ff0000;
            box-sizing: border-box;
        }

        /* Coins décoratifs d'angle rouge #ff0000 */
        .verso-corner-tl {
            position: absolute;
            top: -1px;
            left: -1px;
            width: 14px;
            height: 14px;
            border-top: 3.5px solid #ff0000;
            border-left: 3.5px solid #ff0000;
        }

        .verso-corner-tr {
            position: absolute;
            top: -1px;
            right: -1px;
            width: 14px;
            height: 14px;
            border-top: 3.5px solid #ff0000;
            border-right: 3.5px solid #ff0000;
        }

        .verso-corner-bl {
            position: absolute;
            bottom: -1px;
            left: -1px;
            width: 14px;
            height: 14px;
            border-bottom: 3.5px solid #ff0000;
            border-left: 3.5px solid #ff0000;
        }

        .verso-corner-br {
            position: absolute;
            bottom: -1px;
            right: -1px;
            width: 14px;
            height: 14px;
            border-bottom: 3.5px solid #ff0000;
            border-right: 3.5px solid #ff0000;
        }

        /* Couche de contenu du Verso éloignée des bordures */
        .verso-content-layer {
            position: absolute;
            top: 9mm;
            left: 11mm;
            width: 275mm;
            height: 192mm;
            box-sizing: border-box;
        }

        /* Titre Verso */
        .verso-header-block {
            text-align: center;
            margin-bottom: 2mm;
            padding-bottom: 1.5mm;
            border-bottom: 2px solid #ff0000;
        }

        .verso-titre-principal {
            font-size: 14.5pt;
            font-weight: bold;
            color: #ff0000;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            margin-bottom: 1mm;
        }

        .verso-sub-header {
            font-size: 9.5pt;
            color: #222222;
        }

        .verso-specialite-label {
            font-weight: normal;
            color: #555555;
        }

        .verso-specialite-nom {
            font-weight: bold;
            color: #111111;
            text-transform: uppercase;
        }

        .verso-sep {
            margin: 0 4mm;
            color: #ff0000;
            font-weight: bold;
        }

        .verso-volume-label {
            color: #555555;
        }

        .verso-volume-valeur {
            font-weight: bold;
            color: #ff0000;
        }

        /* Tableau des modules agrandi */
        .verso-table-container {
            width: 100%;
        }

        .verso-table-modules {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
        }

        .verso-table-modules.compact-table {
            font-size: 8.5pt;
        }

        .verso-table-modules th {
            background-color: #000000;
            color: #ffffff;
            font-weight: bold;
            font-size: 9pt;
            text-transform: uppercase;
            padding: 5px 8px;
            border: 0.5px solid #000000;
            letter-spacing: 0.3px;
        }

        .compact-table th {
            padding: 3.5px 6px;
            font-size: 8pt;
        }

        .verso-table-modules td {
            padding: 4px 8px;
            border: 0.5px solid #e0e0e0;
            color: #111111;
        }

        .compact-table td {
            padding: 2.5px 6px;
        }

        .verso-row-even {
            background-color: #fff8f8;
        }

        .verso-row-odd {
            background-color: #ffffff;
        }

        .verso-cell-num {
            width: 9%;
            text-align: center;
            font-weight: bold;
            color: #ff0000;
        }

        .verso-cell-titre {
            width: 59%;
            text-align: left;
            font-weight: 500;
        }

        .verso-cell-hebdo {
            width: 16%;
            text-align: center;
        }

        .verso-cell-total {
            width: 16%;
            text-align: center;
            font-weight: bold;
            color: #111111;
        }

        .verso-row-categorie {
            background-color: #ffe6e6;
        }

        .verso-cell-categorie {
            font-weight: bold;
            color: #ff0000;
            font-size: 8.5pt;
            text-transform: uppercase;
            padding: 3px 8px;
            letter-spacing: 0.5px;
            border: 0.5px solid #e0e0e0;
        }

        .verso-row-total-general {
            background-color: #000000;
            color: #ffffff;
            font-weight: bold;
        }

        .verso-cell-total-label {
            text-align: right;
            padding: 5px 10px;
            font-size: 9.5pt;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 0.5px solid #000000;
        }

        .verso-cell-total-value {
            text-align: center;
            padding: 5px 8px;
            font-size: 10pt;
            font-weight: bold;
            color: #ffffff;
            border: 0.5px solid #000000;
        }

        /* Compétences supplémentaires après le tableau */
        .verso-competences-block {
            margin-top: 2mm;
            padding: 2mm 3mm;
            background-color: #fafafa;
            border: 0.5px solid #e5e5e5;
            border-left: 3px solid #ff0000;
            font-size: 7.5pt;
        }

        .verso-competences-titre {
            font-weight: bold;
            color: #ff0000;
            text-transform: uppercase;
            font-size: 7.5pt;
            margin-bottom: 1mm;
            display: inline-block;
            margin-right: 2mm;
        }

        .verso-comp-badge {
            display: inline-block;
            background-color: #ffffff;
            border: 0.5px solid #dddddd;
            border-radius: 3px;
            padding: 1px 5px;
            margin: 1px 3px 1px 0;
            color: #333333;
            font-size: 7.2pt;
        }

        /* Pied de page Verso */
        .verso-footer-block {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            border-top: 1px solid #ffd6d6;
            padding-top: 1.5mm;
        }

        .verso-table-footer {
            width: 100%;
            border-collapse: collapse;
        }

        .verso-col-legal {
            width: 60%;
            vertical-align: top;
            padding-right: 4mm;
        }

        .verso-mention-titre {
            font-size: 6.8pt;
            font-weight: bold;
            color: #ff0000;
            text-transform: uppercase;
            margin-bottom: 0.6mm;
        }

        .verso-mention-texte {
            font-size: 6pt;
            color: #555555;
            line-height: 1.25;
            margin-bottom: 1mm;
        }

        .verso-numero-ref {
            font-size: 6.5pt;
            color: #333333;
        }

        .verso-col-qr {
            width: 12%;
            text-align: center;
            vertical-align: middle;
        }

        .verso-qr-img {
            max-width: 16mm;
            max-height: 16mm;
            display: block;
            margin: 0 auto;
        }

        .verso-qr-legende {
            font-size: 5pt;
            color: #777777;
            margin-top: 0.8mm;
        }

        .verso-col-signature {
            width: 28%;
            text-align: center;
            vertical-align: top;
            padding-left: 2mm;
        }

        .verso-sig-lieu-date {
            font-size: 7pt;
            color: #333333;
            margin-bottom: 0.6mm;
        }

        .verso-sig-titre {
            font-size: 8.5pt;
            font-weight: bold;
            color: #ff0000;
            text-transform: uppercase;
        }

        .verso-sig-espace {
            height: 8mm;
        }

        .verso-sig-cachet {
            font-size: 6pt;
            font-style: italic;
            color: #888888;
        }

        .background-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 297mm;
            height: 210mm;
            z-index: -1000;
        }

        /* En-tête officiel en 3 colonnes aligné à droite du ruban graphique */
        .table-header {
            position: absolute;
            top: 18mm;
            left: 64mm;
            right: 38mm;
            width: 195mm;
            border-collapse: collapse;
        }

        .header-col-fr {
            width: 43%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.15;
        }

        .header-col-logo {
            width: 14%;
            text-align: center;
            vertical-align: middle;
            padding: 0 1mm;
        }

        .header-col-logo img {
            max-height: 22mm;
            max-width: 20mm;
            display: block;
            margin: 0 auto;
        }

        .header-col-en {
            width: 43%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.15;
        }

        .header-title-main {
            font-size: 6.8pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header-motto {
            font-size: 5.8pt;
            font-style: italic;
        }

        .header-sep {
            font-size: 3.5pt;
            letter-spacing: 1px;
            margin: 0;
            line-height: 1;
            color: #555;
        }

        .header-ministry {
            font-size: 6pt;
            font-weight: bold;
        }

        .header-delegation-reg {
            font-size: 5.6pt;
            font-weight: bold;
        }

        .header-delegation-dep {
            font-size: 5.4pt;
            font-weight: bold;
        }

        .header-center-name {
            font-size: 5.8pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header-contact-info {
            font-size: 5.2pt;
            margin-top: 1px;
            color: #222;
        }

        /* Arrêté principal */
        .box-arrete-principal {
            position: absolute;
            top: 54mm;
            left: 20mm;
            right: 20mm;
            text-align: center;
            font-size: 7.5pt;
            font-weight: bold;
            color: #D32F2F;
            line-height: 1.15;
        }

        /* Titre principal - sur une seule ligne garantie, sans espacement des lettres */
        .box-titre-attestation {
            position: absolute;
            top: 61.5mm;
            left: 0;
            right: 0;
            width: 297mm;
            text-align: center;
            font-size: 18.5pt;
            font-weight: 900;
            letter-spacing: 0;
            color: #000;
            text-transform: uppercase;
            font-family: 'DejaVu Sans', 'Helvetica', Arial, sans-serif;
            white-space: nowrap;
            line-height: 1.1;
        }

        /* Visas des arrêtés */
        .box-visas {
            position: absolute;
            top: 72mm;
            left: 28mm;
            right: 28mm;
            text-align: center;
            font-size: 7.3pt;
            line-height: 1.35;
            color: #222;
        }

        /* Logo CFP gauche */
        .box-logo-cfp {
            position: absolute;
            top: 89mm;
            left: 40mm;
            width: 44mm;
            text-align: center;
        }

        .box-logo-cfp img {
            max-width: 44mm;
            max-height: 22mm;
            display: block;
            margin: 0 auto;
        }

        /* Sceau Auth droite */
        .box-sceau-auth {
            position: absolute;
            top: 81mm;
            right: 40mm;
            width: 28mm;
            text-align: center;
        }

        .box-sceau-auth img {
            max-width: 28mm;
            max-height: 38mm;
            display: block;
            margin: 0 auto;
        }

        /* Cartouche "Le présent document atteste que" */
        .box-cartouche {
            position: absolute;
            top: 97mm;
            left: 50mm;
            right: 50mm;
            text-align: center;
        }

        .cartouche-pilule {
            display: inline-block;
            padding: 3px 26px;
            border: 1.5px solid #111;
            border-radius: 14px;
            font-size: 11pt;
            font-style: italic;
            font-weight: bold;
            background-color: #ffffff;
            color: #111;
        }

        /* Nom de l'apprenant */
        .box-nom-etudiant {
            position: absolute;
            top: 107mm;
            left: 25mm;
            right: 25mm;
            text-align: center;
        }

        .nom-etudiant-texte {
            font-size: 23pt;
            font-weight: 900;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            display: inline-block;
            border-bottom: 1.5px solid #000;
            padding-bottom: 2px;
            min-width: 58%;
            line-height: 1.1;
        }

        /* Date et lieu de naissance */
        .box-naissance {
            position: absolute;
            top: 119mm;
            left: 25mm;
            right: 25mm;
            text-align: center;
            font-size: 13.5pt;
            font-style: italic;
            color: #111;
        }

        /* Corps de la formation */
        .box-corps-formation {
            position: absolute;
            top: 129.5mm;
            left: 35mm;
            right: 35mm;
            text-align: center;
            font-size: 13pt;
            line-height: 1.45;
            color: #111;
        }

        .specialite-texte {
            color: #D32F2F;
            font-weight: bold;
        }

        /* Formule de clôture */
        .box-formule-cloture {
            position: absolute;
            top: 147.5mm;
            left: 35mm;
            right: 35mm;
            text-align: center;
            font-size: 12pt;
            font-style: italic;
            color: #222;
            line-height: 1.35;
        }

        /* Signatures (3 colonnes) */
        .box-signatures {
            position: absolute;
            top: 166mm;
            left: 30mm;
            right: 30mm;
            width: 237mm;
        }

        .table-signatures {
            width: 100%;
            border-collapse: collapse;
        }

        .col-sig-delegue {
            width: 28%;
            text-align: center;
            vertical-align: top;
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .col-sig-impetrant {
            width: 28%;
            text-align: center;
            vertical-align: top;
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .col-sig-direction {
            width: 44%;
            text-align: center;
            vertical-align: top;
            font-size: 11pt;
            font-weight: bold;
            white-space: nowrap;
        }

        .direction-date {
            white-space: nowrap;
            font-size: 11pt;
            font-weight: bold;
        }

        .direction-titre {
            font-size: 11pt;
            font-weight: bold;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    @php
        $attestationsList = isset($items) ? $items : [$item];
    @endphp

    @foreach($attestationsList as $index => $item)
        <div class="page-container page-recto">
            <!-- FOND GRAPHIQUE D'EXCELLENCE A4 PAYSAGE -->
            @if(!empty($backgroundImageBase64))
                <img src="{{ $backgroundImageBase64 }}" class="background-image" alt="Fond Attestation">
            @endif

            <!-- EN-TÊTE OFFICIEL 3 COLONNES AVEC LOGO STRICTEMENT AU CENTRE -->
            <table class="table-header">
                <tr>
                    <td class="header-col-fr">
                        <div class="header-title-main">RÉPUBLIQUE DU CAMEROUN</div>
                        <div class="header-motto">Paix – Travail – Patrie</div>
                        <div class="header-sep">*******</div>
                        <div class="header-ministry">MINISTÈRE DE L'EMPLOI ET DE LA FORMATION PROFESSIONNELLE</div>
                        <div class="header-sep">*******</div>
                        <div class="header-delegation-reg">DÉLÉGATION RÉGIONALE DE L'EMPLOI ET DE LA FORMATION PROFESSIONNELLE DE L'OUEST</div>
                        <div class="header-sep">*******</div>
                        <div class="header-delegation-dep">DÉLÉGATION DÉPARTEMENTALE DE L'EMPLOI ET DE LA FORMATION PROFESSIONNELLE DE L'OUEST ET DE LA MIFI</div>
                        <div class="header-sep">*******</div>
                        <div class="header-center-name">CENTRE DE FORMATION PROFESSIONNELLE LA CANADIENNE</div>
                        <div class="header-contact-info">Site : www.cfpcanadienne.com / Email : contact@cfpcanadinne.com</div>
                    </td>
                    <td class="header-col-logo">
                        @if(!empty($minefopLogoBase64))
                            <img src="{{ $minefopLogoBase64 }}" alt="MINEFOP">
                        @endif
                    </td>
                    <td class="header-col-en">
                        <div class="header-title-main">REPUBLIC OF CAMEROON</div>
                        <div class="header-motto">Peace – Work – Fatherland</div>
                        <div class="header-sep">*******</div>
                        <div class="header-ministry">MINISTRY OF EMPLOYMENT AND VOCATIONAL TRAINING</div>
                        <div class="header-sep">*******</div>
                        <div class="header-delegation-reg">WEST REGIONAL DELEGATION OF EMPLOYMENT AND VOCATIONAL TRAINING</div>
                        <div class="header-sep">*******</div>
                        <div class="header-delegation-dep">MIFI DIVISIONAL DELEGATION OF EMPLOYMENT AND VOCATIONAL TRAINING</div>
                        <div class="header-sep">*******</div>
                        <div class="header-center-name">VOCATIONAL TRAINING CENTER LA CANADIENNE</div>
                        <div class="header-contact-info">Site : www.cfpcanadienne.com / Email : contact@cfpcanadinne.com</div>
                    </td>
                </tr>
            </table>

            <!-- ARRÊTÉ PRINCIPAL -->
            <div class="box-arrete-principal">
                {{ $item['arrete_principal'] }}
            </div>

            <!-- TITRE OFFICIEL SUR UNE SEULE LIGNE -->
            <div class="box-titre-attestation">
                ATTESTATION DE FIN DE FORMATION PROFESSIONNELLE
            </div>

            <!-- VISAS DES ARRÊTÉS ADMINISTRATIFS -->
            <div class="box-visas">
                @foreach($item['visas_arretes'] as $visa)
                    <div>{{ $visa }}</div>
                @endforeach
            </div>

            <!-- LOGO CFP LA CANADIENNE À GAUCHE -->
            @if(!empty($cfpLogoBase64))
                <div class="box-logo-cfp">
                    <img src="{{ $cfpLogoBase64 }}" alt="CFP La Canadienne">
                </div>
            @endif

            <!-- SCEAU AUTHENTICITÉ / COCARDE À DROITE -->
            @if(!empty($authSealBase64))
                <div class="box-sceau-auth">
                    <img src="{{ $authSealBase64 }}" alt="Sceau d'authenticité">
                </div>
            @endif

            <!-- CARTOUCHE "Le présent document atteste que" -->
            <div class="box-cartouche">
                <span class="cartouche-pilule">
                    Le présent document atteste que
                </span>
            </div>

            <!-- NOM COMPLET DE L'APPRENANT -->
            <div class="box-nom-etudiant">
                <span class="nom-etudiant-texte">
                    {{ $item['nom_apprenant'] }}
                </span>
            </div>

            <!-- DATE ET LIEU DE NAISSANCE -->
            <div class="box-naissance">
                {{ $item['prefixe_naissance'] }} {{ $item['date_naissance'] }} à {{ $item['lieu_naissance'] }}
            </div>

            <!-- FORMULE DE FORMATION -->
            <div class="box-corps-formation">
                A effectué une formation au sein du <strong>Centre de Formation Professionnelle la Canadienne</strong>
                du <strong>{{ $item['date_debut_formatee'] }}</strong> au <strong>{{ $item['date_fin_formatee'] }}</strong> en <span class="specialite-texte">{{ $item['specialite_libelle'] }}.</span>
            </div>

            <!-- FORMULE DE CLÔTURE -->
            <div class="box-formule-cloture">
                En foi de quoi nous lui délivrons cette attestation de formation pour servir et valoir ce que de droit.
            </div>

            <!-- BLOC DES 3 SIGNATURES (DATE SUR LA MÊME LIGNE) -->
            <div class="box-signatures">
                <table class="table-signatures">
                    <tr>
                        <td class="col-sig-delegue">
                            <div>LE DELEGUE</div>
                        </td>
                        <td class="col-sig-impetrant">
                            <div>L'IMPÉTRANT</div>
                        </td>
                        <td class="col-sig-direction">
                            <div class="direction-date">Fait à {{ $item['lieu_delivrance'] }}, le {{ $item['date_delivrance_formatee'] }}</div>
                            <div class="direction-titre">La Direction</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- PAGE 2 : VERSO (SYNTHÈSE DU PROGRAMME DE FORMATION) -->
        <div class="page-container page-verso {{ !$loop->last ? 'page-break-next-student' : '' }}">
            <!-- CADRE ROUGE EXTÉRIEUR ET COINS DÉCORATIFS -->
            <div class="verso-cadre-exterieur">
                <div class="verso-corner-tl"></div>
                <div class="verso-corner-tr"></div>
                <div class="verso-corner-bl"></div>
                <div class="verso-corner-br"></div>
            </div>
            <!-- CADRE ROUGE INTÉRIEUR -->
            <div class="verso-cadre-interieur"></div>

            <!-- COUCHE DE CONTENU -->
            <div class="verso-content-layer">
                <!-- TITRE DIRECT DU PROGRAMME SANS EN-TÊTE INSTITUTIONNEL -->
                <div class="verso-header-block">
                    <div class="verso-titre-principal">SYNTHÈSE DU PROGRAMME DE FORMATION</div>
                    <div class="verso-sub-header">
                        <span class="verso-specialite-label">Spécialité :</span>
                        <span class="verso-specialite-nom">{{ $item['specialite_libelle'] }}</span>
                        @if(!empty($item['total_heures_programme']))
                            <span class="verso-sep">|</span>
                            <span class="verso-volume-label">Volume horaire global :</span>
                            <span class="verso-volume-valeur">{{ number_format($item['total_heures_programme'], 0, ',', ' ') }} heures</span>
                        @endif
                    </div>
                </div>

                <!-- TABLEAU DES MODULES AGRANDI -->
                <div class="verso-table-container">
                    @php
                        $nbMods = count($item['programme_modules']);
                        $isCompact = $nbMods >= 18;
                    @endphp
                    <table class="verso-table-modules {{ $isCompact ? 'compact-table' : '' }}">
                        <thead>
                            <tr>
                                <th style="width: 9%;">N°</th>
                                <th style="width: 59%;">Titre du module</th>
                                <th style="width: 16%;">Nombre d’heures hebdomadaires</th>
                                <th style="width: 16%;">Nombre d’heures total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $currentCategorie = null; @endphp
                            @forelse($item['programme_modules'] as $mod)
                                @if(!empty($mod->categorie) && $mod->categorie !== $currentCategorie)
                                    @php $currentCategorie = $mod->categorie; @endphp
                                    <tr class="verso-row-categorie">
                                        <td colspan="4" class="verso-cell-categorie">
                                            {{ $currentCategorie }}
                                        </td>
                                    </tr>
                                @endif
                                <tr class="{{ $loop->even ? 'verso-row-even' : 'verso-row-odd' }}">
                                    <td class="verso-cell-num">{{ $mod->numero_module }}</td>
                                    <td class="verso-cell-titre">{{ $mod->titre }}</td>
                                    <td class="verso-cell-hebdo">{{ $mod->heures_hebdomadaires ? $mod->heures_hebdomadaires . ' h' : '-' }}</td>
                                    <td class="verso-cell-total">{{ $mod->heures_total }} h</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 15px; color: #777;">
                                        Aucun module défini pour cette spécialité.
                                    </td>
                                </tr>
                            @endforelse
                            <tr class="verso-row-total-general">
                                <td colspan="3" class="verso-cell-total-label">TOTAL GÉNÉRAL DU PROGRAMME DE FORMATION</td>
                                <td class="verso-cell-total-value">{{ number_format($item['total_heures_programme'], 0, ',', ' ') }} h</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- COMPÉTENCES SUPPLÉMENTAIRES (SI DÉFINIES) -->
                @if(!empty($item['competences']) && count($item['competences']) > 0)
                    <div class="verso-competences-block">
                        <span class="verso-competences-titre">Compétences clés acquises :</span>
                        @foreach($item['competences'] as $comp)
                            <span class="verso-comp-badge">✓ {{ is_array($comp) ? ($comp['intitule'] ?? '') : $comp }}</span>
                        @endforeach
                    </div>
                @endif

                <!-- PIED DE PAGE DU VERSO -->
                <div class="verso-footer-block">
                    <table class="verso-table-footer">
                        <tr>
                            <td class="verso-col-legal">
                                <div class="verso-mention-titre">AUTHENTIFICATION DU CURRICULUM</div>
                                <div class="verso-mention-texte">
                                    La présente synthèse atteste de l'ensemble des modules d'enseignements théoriques, pratiques et professionnels validés par l'apprenant(e) au Centre de Formation Professionnelle La Canadienne, conformément au référentiel de formation homologué par le MINEFOP.
                                </div>
                                <div class="verso-numero-ref">Attestation Réf : <strong>{{ $item['numero_attestation'] }}</strong></div>
                            </td>
                            <td class="verso-col-qr">
                                @if(!empty($item['qr_code']))
                                    <img src="{{ $item['qr_code'] }}" class="verso-qr-img" alt="QR Code">
                                    <div class="verso-qr-legende">Scanner pour vérifier</div>
                                @endif
                            </td>
                            <td class="verso-col-signature">
                                <div class="verso-sig-lieu-date">Fait à {{ $item['lieu_delivrance'] }}, le {{ $item['date_delivrance_formatee'] }}</div>
                                <div class="verso-sig-titre">La Direction</div>
                                <div class="verso-sig-espace"></div>
                                <div class="verso-sig-cachet">(Signature et Cachet)</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</body>
</html>
