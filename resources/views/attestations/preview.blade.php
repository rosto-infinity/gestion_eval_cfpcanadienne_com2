<x-app-layout title="Aperçu Attestation - {{ $item['nom_apprenant'] }}">
    <style>
        .attestation-preview-container {
            position: relative;
            width: 297mm;
            min-width: 297mm;
            height: 210mm;
            min-height: 210mm;
            font-family: 'DejaVu Sans', 'Helvetica', Arial, sans-serif;
            overflow: hidden;
            background-color: #ffffff;
            color: #111;
            box-sizing: border-box;
        }

        .attestation-preview-container * {
            box-sizing: border-box;
        }

        .attestation-preview-container .background-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 297mm;
            height: 210mm;
            z-index: 1;
        }

        .attestation-preview-container .content-layer {
            position: absolute;
            top: 0;
            left: 0;
            width: 297mm;
            height: 210mm;
            z-index: 2;
        }

        /* En-tête officiel en 3 colonnes aligné à droite du ruban graphique */
        .attestation-preview-container .table-header {
            position: absolute;
            top: 18mm;
            left: 64mm;
            right: 38mm;
            width: 195mm;
            border-collapse: collapse;
        }

        .attestation-preview-container .header-col-fr {
            width: 43%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.15;
        }

        .attestation-preview-container .header-col-logo {
            width: 14%;
            text-align: center;
            vertical-align: middle;
            padding: 0 1mm;
        }

        .attestation-preview-container .header-col-logo img {
            max-height: 22mm;
            max-width: 20mm;
            display: block;
            margin: 0 auto;
        }

        .attestation-preview-container .header-col-en {
            width: 43%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.15;
        }

        .attestation-preview-container .header-title-main {
            font-size: 6.8pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .attestation-preview-container .header-motto {
            font-size: 5.8pt;
            font-style: italic;
        }

        .attestation-preview-container .header-sep {
            font-size: 3.5pt;
            letter-spacing: 1px;
            margin: 0;
            line-height: 1;
            color: #555;
        }

        .attestation-preview-container .header-ministry {
            font-size: 6pt;
            font-weight: bold;
        }

        .attestation-preview-container .header-delegation-reg {
            font-size: 5.6pt;
            font-weight: bold;
        }

        .attestation-preview-container .header-delegation-dep {
            font-size: 5.4pt;
            font-weight: bold;
        }

        .attestation-preview-container .header-center-name {
            font-size: 5.8pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .attestation-preview-container .header-contact-info {
            font-size: 5.2pt;
            margin-top: 1px;
            color: #222;
        }

        /* Arrêté principal */
        .attestation-preview-container .box-arrete-principal {
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
        .attestation-preview-container .box-titre-attestation {
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
        .attestation-preview-container .box-visas {
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
        .attestation-preview-container .box-logo-cfp {
            position: absolute;
            top: 89mm;
            left: 40mm;
            width: 44mm;
            text-align: center;
        }

        .attestation-preview-container .box-logo-cfp img {
            max-width: 44mm;
            max-height: 22mm;
            display: block;
            margin: 0 auto;
        }

        /* Sceau Auth droite */
        .attestation-preview-container .box-sceau-auth {
            position: absolute;
            top: 81mm;
            right: 40mm;
            width: 28mm;
            text-align: center;
        }

        .attestation-preview-container .box-sceau-auth img {
            max-width: 28mm;
            max-height: 38mm;
            display: block;
            margin: 0 auto;
        }

        /* Cartouche "Le présent document atteste que" */
        .attestation-preview-container .box-cartouche {
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
        .attestation-preview-container .box-nom-etudiant {
            position: absolute;
            top: 107mm;
            left: 25mm;
            right: 25mm;
            text-align: center;
        }

        .attestation-preview-container .nom-etudiant-texte {
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
        .attestation-preview-container .box-naissance {
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
        .attestation-preview-container .box-corps-formation {
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
        .attestation-preview-container .box-formule-cloture {
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
        .attestation-preview-container .box-signatures {
            position: absolute;
            top: 166mm;
            left: 30mm;
            right: 30mm;
            width: 237mm;
        }

        .attestation-preview-container .table-signatures {
            width: 100%;
            border-collapse: collapse;
        }

        .attestation-preview-container .col-sig-delegue {
            width: 28%;
            text-align: center;
            vertical-align: top;
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .attestation-preview-container .col-sig-impetrant {
            width: 28%;
            text-align: center;
            vertical-align: top;
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .attestation-preview-container .col-sig-direction {
            width: 44%;
            text-align: center;
            vertical-align: top;
            font-size: 11pt;
            font-weight: bold;
            white-space: nowrap;
        }

        .attestation-preview-container .direction-date {
            white-space: nowrap;
            font-size: 11pt;
            font-weight: bold;
        }

        .attestation-preview-container .direction-titre {
            font-size: 11pt;
            font-weight: bold;
            margin-top: 4px;
        }

        /* ==================== STYLES DU VERSO APERÇU (#ff0000) ==================== */
        .attestation-preview-container-verso {
            position: relative;
            width: 297mm;
            min-width: 297mm;
            height: 210mm;
            min-height: 210mm;
            font-family: 'DejaVu Sans', 'Helvetica', Arial, sans-serif;
            overflow: hidden;
            background-color: #ffffff;
            color: #111;
            box-sizing: border-box;
        }

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

        .verso-content-layer {
            position: absolute;
            top: 9mm;
            left: 11mm;
            width: 275mm;
            height: 192mm;
            box-sizing: border-box;
        }

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
    </style>

    <div class="mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6" x-data="{ currentFace: 'recto' }">
        <!-- Barre supérieure -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('attestations.par-specialite', ['specialite_id' => $attestation->specialite_id]) }}"
                    class="text-xs text-muted-foreground hover:text-foreground inline-flex items-center gap-1 mb-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour aux attestations
                </a>
                <h1 class="text-2xl font-bold text-foreground tracking-tight">
                    Aperçu Attestation - {{ $item['nom_apprenant'] }}
                </h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('attestations.pdf', $attestation->id) }}"
                    class="inline-flex items-center px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold text-sm rounded-lg shadow-sm transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Télécharger le PDF officiel (Recto/Verso)
                </a>
            </div>
        </div>

        <!-- SÉLECTEUR DE FACE (RECTO / VERSO) -->
        <div class="flex justify-center">
            <div class="inline-flex p-1 bg-muted rounded-xl shadow-inner border border-border gap-1">
                <button type="button" @click="currentFace = 'recto'"
                    :class="currentFace === 'recto' ? 'bg-background text-foreground shadow-sm font-semibold' : 'text-muted-foreground hover:text-foreground'"
                    class="px-4 py-2 text-xs rounded-lg transition-all flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Recto (Attestation)
                </button>
                <button type="button" @click="currentFace = 'verso'"
                    :class="currentFace === 'verso' ? 'bg-background text-foreground shadow-sm font-semibold' : 'text-muted-foreground hover:text-foreground'"
                    class="px-4 py-2 text-xs rounded-lg transition-all flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Verso (Programme de formation)
                </button>
                <button type="button" @click="currentFace = 'both'"
                    :class="currentFace === 'both' ? 'bg-background text-foreground shadow-sm font-semibold' : 'text-muted-foreground hover:text-foreground'"
                    class="px-4 py-2 text-xs rounded-lg transition-all flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                    </svg>
                    Les deux faces
                </button>
            </div>
        </div>

        <!-- CADRE SIMULANT LE DOCUMENT PAYSAGE A4 -->
        <div class="bg-card rounded-xl border border-border shadow-lg p-4 sm:p-8 overflow-x-auto flex flex-col items-center gap-8">
            <!-- RECTO -->
            <div class="attestation-preview-container shadow-2xl rounded-sm" x-show="currentFace === 'recto' || currentFace === 'both'">

                @if(!empty($backgroundImageBase64))
                    <img src="{{ $backgroundImageBase64 }}" class="background-image" alt="Fond Attestation">
                @endif

                <div class="content-layer">
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

                    <!-- TITRE OFFICIEL SUR UNE SEULE LIGNE SANS ESPACEMENT -->
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
            </div>

            <!-- VERSO -->
            <div class="attestation-preview-container-verso shadow-2xl rounded-sm" x-show="currentFace === 'verso' || currentFace === 'both'">
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
        </div>
    </div>
</x-app-layout>
