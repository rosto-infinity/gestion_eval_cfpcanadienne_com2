@extends('layouts.pdf')

@section('title', 'Bilan par Spécialité - ' . ($annee ? $annee->libelle : 'Toutes les années'))

@section('content')
<div class="w-full min-h-screen bg-background p-8">
    <!-- En-tête du document -->
    <div class="mb-8 text-center border-b-2 border-border pb-6">
        <div class="flex items-center justify-center mb-4">
            <div class="bg-primary text-primary-foreground w-12 h-12 rounded-full flex items-center justify-center font-bold text-xl">
                📊
            </div>
        </div>
        <h1 class="text-2xl font-bold text-foreground mb-2">BILAN DES PERFORMANCES ACADÉMIQUES</h1>
        <h2 class="text-xl font-semibold text-primary mb-1">PAR SPÉCIALITÉ</h2>
        @if($annee)
            <p class="text-lg text-foreground font-medium">{{ $annee->libelle }} {{ $annee->annee_debut }}/{{ $annee->annee_fin }}</p>
        @else
            <p class="text-lg text-foreground font-medium">Toutes les années académiques</p>
        @endif
        <p class="text-sm text-muted-foreground mt-2">Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <!-- Statistiques globales -->
    <div class="mb-8">
        <h3 class="text-lg font-bold text-foreground mb-4 text-center">RÉSUMÉ DES STATISTIQUES GLOBALES</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <!-- Spécialités -->
            <div class="border border-border rounded-lg p-4 bg-primary/5">
                <p class="text-sm font-semibold text-primary uppercase tracking-wide mb-1">Spécialités</p>
                <p class="text-2xl font-bold text-foreground">{{ $statsGlobales['total_specialites'] }}</p>
            </div>

            <!-- Total Étudiants -->
            <div class="border border-border rounded-lg p-4 bg-muted/50">
                <p class="text-sm font-semibold text-muted-foreground uppercase tracking-wide mb-1">Total Étudiants</p>
                <p class="text-2xl font-bold text-foreground">{{ $statsGlobales['total_etudiants'] }}</p>
            </div>

            <!-- Taux d'Admission -->
            <div class="border border-border rounded-lg p-4 bg-primary/5">
                <p class="text-sm font-semibold text-primary uppercase tracking-wide mb-1">Taux d'Admission</p>
                <p class="text-2xl font-bold text-primary">{{ number_format($statsGlobales['taux_admission'], 1) }}%</p>
            </div>

            <!-- Moyenne Générale -->
            <div class="border border-border rounded-lg p-4 bg-primary/10">
                <p class="text-sm font-semibold text-primary uppercase tracking-wide mb-1">Moy. Générale</p>
                <p class="text-2xl font-bold text-primary">
                    {{ $statsGlobales['moyenne_generale'] ? number_format($statsGlobales['moyenne_generale'], 2) : '-' }}/20
                </p>
            </div>
            
            <!-- Moyenne Compétences -->
            <div class="border border-border rounded-lg p-4 bg-primary/5">
                <p class="text-sm font-semibold text-primary uppercase tracking-wide mb-1">Moy. Compétences</p>
                <p class="text-2xl font-bold text-primary">
                    {{ $statsGlobales['moy_competences'] ? number_format($statsGlobales['moy_competences'], 2) : '-' }}/20
                </p>
            </div>
        </div>
    </div>

    <!-- Tableau principal -->
    @if($bilanParSpecialite->isEmpty())
        <div class="text-center py-12 bg-muted/30 rounded-lg border-2 border-dashed border-border">
            <p class="text-xl font-semibold text-foreground mb-2">Aucune donnée disponible</p>
            <p class="text-muted-foreground">Aucun bilan trouvé pour les paramètres sélectionnés.</p>
        </div>
    @else
        <div class="mb-8">
            <h3 class="text-lg font-bold text-foreground mb-4 text-center">DÉTAIL PAR SPÉCIALITÉ</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr class="bg-muted/50 border-b-2 border-border">
                            <th class="px-4 py-3 text-left text-sm font-bold text-foreground border-r border-border">Spécialité</th>
                            <th class="px-4 py-3 text-center text-sm font-bold text-foreground border-r border-border bg-primary/5">Étudiants</th>
                            <th class="px-4 py-3 text-center text-sm font-bold text-foreground border-r border-border bg-primary/5">Moy. S1</th>
                            <th class="px-4 py-3 text-center text-sm font-bold text-foreground border-r border-border bg-primary/5">Moy. S2</th>
                            <th class="px-4 py-3 text-center text-sm font-bold text-foreground border-r border-border bg-primary/5">
                                <div>Compétences</div>
                                <div class="text-xs font-normal">(70%)</div>
                            </th>
                            <th class="px-4 py-3 text-center text-sm font-bold text-foreground border-r border-border bg-primary/10">
                                <div>Moy. Gén.</div>
                                <div class="text-xs font-normal">(100%)</div>
                            </th>
                            <th class="px-4 py-3 text-center text-sm font-bold text-foreground border-r border-border bg-muted/50">Admis</th>
                            <th class="px-4 py-3 text-center text-sm font-bold text-foreground border-r border-border bg-muted/50">Non Admis</th>
                            <th class="px-4 py-3 text-center text-sm font-bold text-foreground bg-muted/30">Taux Adm.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bilanParSpecialite as $bilan)
                            <tr class="border-b border-border hover:bg-muted/20">
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-foreground">{{ $bilan->specialite->code }}</div>
                                    <div class="text-xs text-muted-foreground mt-1">{{ Str::limit($bilan->specialite->intitule, 30) }}</div>
                                </td>
                                <td class="px-4 py-3 text-center bg-primary/5 font-semibold text-foreground">{{ $bilan->total_etudiants }}</td>
                                <td class="px-4 py-3 text-center bg-primary/5 font-semibold text-foreground">
                                    {{ $bilan->moy_semestre1 ? number_format($bilan->moy_semestre1, 2) : '-' }}
                                </td>
                                <td class="px-4 py-3 text-center bg-primary/5 font-semibold text-foreground">
                                    {{ $bilan->moy_semestre2 ? number_format($bilan->moy_semestre2, 2) : '-' }}
                                </td>
                                <td class="px-4 py-3 text-center bg-primary/5 font-semibold text-foreground">
                                    {{ $bilan->moy_competences ? number_format($bilan->moy_competences, 2) : '-' }}
                                </td>
                                <td class="px-4 py-3 text-center bg-primary/10 font-bold text-lg text-primary">
                                    {{ $bilan->moyenne_generale ? number_format($bilan->moyenne_generale, 2) : '-' }}
                                </td>
                                <td class="px-4 py-3 text-center bg-muted/50 font-bold text-foreground">{{ $bilan->admis }}</td>
                                <td class="px-4 py-3 text-center bg-muted/50 font-bold text-muted-foreground">{{ $bilan->non_admis }}</td>
                                <td class="px-4 py-3 text-center bg-muted/30">
                                    <div class="font-semibold text-foreground">
                                        {{ number_format($bilan->taux_admission, 1) }}%
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-muted/50 border-t-2 border-border">
                        <tr>
                            <td class="px-4 py-3 font-bold text-right text-foreground" colspan="1">TOTAL</td>
                            <td class="px-4 py-3 text-center font-bold bg-primary/5 text-foreground">{{ $statsGlobales['total_etudiants'] }}</td>
                            <td class="px-4 py-3 text-center font-bold bg-primary/5 text-foreground">
                                {{ $statsGlobales['moy_semestre1'] ? number_format($statsGlobales['moy_semestre1'], 2) : '-' }}
                            </td>
                            <td class="px-4 py-3 text-center font-bold bg-primary/5 text-foreground">
                                {{ $statsGlobales['moy_semestre2'] ? number_format($statsGlobales['moy_semestre2'], 2) : '-' }}
                            </td>
                            <td class="px-4 py-3 text-center font-bold bg-primary/5 text-foreground">
                                {{ $statsGlobales['moy_competences'] ? number_format($statsGlobales['moy_competences'], 2) : '-' }}
                            </td>
                            <td class="px-4 py-3 text-center bg-primary/10 font-bold text-primary">
                                {{ $statsGlobales['moyenne_generale'] ? number_format($statsGlobales['moyenne_generale'], 2) : '-' }}/20
                            </td>
                            <td class="px-4 py-3 text-center bg-muted/50 font-bold text-foreground">
                                {{ $statsGlobales['total_admis'] }}
                            </td>
                            <td class="px-4 py-3 text-center bg-muted/50 font-bold text-muted-foreground">
                                {{ $statsGlobales['total_non_admis'] }}
                            </td>
                            <td class="px-4 py-3 text-center bg-muted/30 font-bold text-foreground">
                                {{ number_format($statsGlobales['taux_admission'], 1) }}%
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Résumé analytique -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-foreground mb-4 text-center">ANALYSE COMPARATIVE</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Meilleures performances -->
                <div class="border border-border rounded-lg p-4 bg-card">
                    <h4 class="font-bold text-foreground mb-3">🏆 MEILLEURES PERFORMANCES</h4>
                    <ul class="space-y-2">
                        @php
                            $topMoyennes = $bilanParSpecialite->sortByDesc('moyenne_generale')->take(3);
                        @endphp
                        
                        @foreach($topMoyennes as $index => $bilan)
                            <li class="flex justify-between items-center border-b border-border pb-2 last:border-b-0">
                                <span class="font-semibold text-primary">{{ $bilan->specialite->code }}</span>
                                <span class="font-bold text-primary">{{ number_format($bilan->moyenne_generale, 2) }}/20</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                <!-- Taux d'admission -->
                <div class="border border-border rounded-lg p-4 bg-card">
                    <h4 class="font-bold text-foreground mb-3">📈 TAUX D'ADMISSION</h4>
                    <ul class="space-y-2">
                        @php
                            $topAdmission = $bilanParSpecialite->sortByDesc('taux_admission')->take(3);
                        @endphp
                        
                        @foreach($topAdmission as $index => $bilan)
                            <li class="flex justify-between items-center border-b border-border pb-2 last:border-b-0">
                                <span class="font-semibold text-primary">{{ $bilan->specialite->code }}</span>
                                <span class="font-bold text-primary">
                                    {{ number_format($bilan->taux_admission, 1) }}%
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Pied de page -->
    <div class="mt-8 pt-6 border-t-2 border-border text-center">
        <p class="text-sm text-muted-foreground mb-2">
            Document confidentiel - Usage interne uniquement
        </p>
        <p class="text-xs text-muted-foreground/70">
            Généré par le système de gestion académique | Page {{ $page ?? 1 }}/{{ $totalPages ?? 1 }}
        </p>
    </div>
</div>
@endsection

@section('styles')
<style>
    @page {
        margin: 2cm;
        size: landscape;
    }
    
    :root {
        --background: #ffffff;
        --foreground: #1a1a1a;
        --primary: #09e540;
        --primary-foreground: #ffffff;
        --secondary: #f5f5f5;
        --secondary-foreground: #1a1a1a;
        --muted: #e5e5e5;
        --muted-foreground: #666666;
        --border: #d0d0d0;
        --card: #fafafa;
        --card-foreground: #1a1a1a;
    }
    
    body {
        font-family: 'DejaVu Sans', 'Helvetica', sans-serif;
        color: var(--foreground);
        line-height: 1.5;
        background-color: var(--background);
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
        font-size: 0.85rem;
    }
    
    th, td {
        border: 1px solid var(--border);
        padding: 8px;
        text-align: left;
    }
    
    th {
        background-color: var(--secondary);
        font-weight: 600;
        color: var(--foreground);
    }
    
    tr:hover {
        background-color: var(--secondary);
    }
    
    /* Variables de couleur */
    .bg-background { background-color: var(--background); }
    .bg-card { background-color: var(--card); }
    .bg-primary { background-color: var(--primary); }
    .bg-primary-foreground { background-color: var(--primary-foreground); }
    .bg-secondary { background-color: var(--secondary); }
    .bg-muted { background-color: var(--muted); }
    .bg-primary\/5 { background-color: rgba(9, 229, 64, 0.05); }
    .bg-primary\/10 { background-color: rgba(9, 229, 64, 0.1); }
    .bg-muted\/20 { background-color: rgba(229, 229, 229, 0.2); }
    .bg-muted\/30 { background-color: rgba(229, 229, 229, 0.3); }
    .bg-muted\/50 { background-color: rgba(229, 229, 229, 0.5); }
    
    .text-foreground { color: var(--foreground); }
    .text-primary { color: var(--primary); }
    .text-primary-foreground { color: var(--primary-foreground); }
    .text-muted-foreground { color: var(--muted-foreground); }
    .text-card-foreground { color: var(--card-foreground); }
    
    .border { border: 1px solid var(--border); }
    .border-b-2 { border-bottom: 2px solid var(--border); }
    .border-t-2 { border-top: 2px solid var(--border); }
    .border-r { border-right: 1px solid var(--border); }
    .border-border { border-color: var(--border); }
    
    .rounded-lg { border-radius: 0.5rem; }
    .rounded-full { border-radius: 9999px; }
    
    .p-4 { padding: 1rem; }
    .p-8 { padding: 2rem; }
    .px-4 { padding-left: 1rem; padding-right: 1rem; }
    .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
    
    .mb-1 { margin-bottom: 0.25rem; }
    .mb-2 { margin-bottom: 0.5rem; }
    .mb-3 { margin-bottom: 0.75rem; }
    .mb-4 { margin-bottom: 1rem; }
    .mb-6 { margin-bottom: 1.5rem; }
    .mb-8 { margin-bottom: 2rem; }
    .mt-1 { margin-top: 0.25rem; }
    .mt-2 { margin-top: 0.5rem; }
    .mt-8 { margin-top: 2rem; }
    .pt-6 { padding-top: 1.5rem; }
    .pb-6 { padding-bottom: 1.5rem; }
    .pb-2 { padding-bottom: 0.5rem; }
    
    .gap-4 { gap: 1rem; }
    .gap-6 { gap: 1.5rem; }
    .space-y-2 > * + * { margin-top: 0.5rem; }
    
    .font-bold { font-weight: 700; }
    .font-semibold { font-weight: 600; }
    .font-medium { font-weight: 500; }
    
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    
    .text-xs { font-size: 0.75rem; }
    .text-sm { font-size: 0.875rem; }
    .text-lg { font-size: 1.125rem; }
    .text-xl { font-size: 1.25rem; }
    .text-2xl { font-size: 1.5rem; }
    
    .w-full { width: 100%; }
    .w-12 { width: 3rem; }
    .h-12 { height: 3rem; }
    .min-h-screen { min-height: 100vh; }
    
    .flex { display: flex; }
    .flex-col { flex-direction: column; }
    .items-center { align-items: center; }
    .items-start { align-items: flex-start; }
    .justify-center { justify-content: center; }
    .justify-between { justify-content: space-between; }
    
    .grid { display: grid; }
    .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
    .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .grid-cols-5 { grid-template-columns: repeat(5, minmax(0, 1fr)); }
    
    .overflow-x-auto { overflow-x: auto; }
    
    .last\:border-b-0:last-child { border-bottom: 0 !important; }
    
    @media print {
        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color-adjust: exact;
        }
        .no-print, .no-print * {
            display: none !important;
        }
        table {
            page-break-inside: avoid;
        }
        tr {
            page-break-inside: avoid;
        }
    }
    
    @media (min-width: 768px) {
        .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .md\:grid-cols-5 { grid-template-columns: repeat(5, minmax(0, 1fr)); }
    }
</style>
@endsection
