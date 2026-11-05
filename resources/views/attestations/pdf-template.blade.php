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
        }

        .page-break {
            page-break-after: always;
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
        <div class="page-container {{ !$loop->last ? 'page-break' : '' }}">
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
    @endforeach
</body>
</html>
