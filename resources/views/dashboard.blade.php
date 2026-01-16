@extends('layouts.app')

@section('title', 'Tableau de Bord Global')

@section('content')
<div class="py-12">
    <!-- En-tête -->
    <div class="head-title">
        <div class="left">
            <h1>Dashboard</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li class="active">Administration</li>
            </ul>
        </div>
        <!-- Infos de l'administrateur connecté -->
        <div class="user-profile-header">
            @if($user->profile)
                <img src="{{ Storage::url($user->profile) }}" alt="Photo de profil" class="profile-header-avatar">
            @else
                <div class="profile-header-avatar-placeholder">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
            <div class="profile-header-info">
                <h3>{{ $user->name }}</h3>
                <p>{{ $user->email }}</p>
                <span class="role-badge admin">{{ ucfirst($user->role) }}</span>
            </div>
        </div>
    </div>

    <!-- KPIs (Box Info) -->
    <ul class="box-info">
        <li>
            <i class='bx bxs-user'></i>
            <span class="text">
                <h3>{{ $totalStudents }}</h3>
                <p>Étudiants</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-note'></i>
            <span class="text">
                <h3>{{ $totalEvaluations }}</h3>
                <p>Évaluations</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-graduation'></i>
            <span class="text">
                <h3>{{ $totalSpecialites }}</h3>
                <p>Spécialités</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-book'></i>
            <span class="text">
                <h3>{{ $totalModules }}</h3>
                <p>Modules</p>
            </span>
        </li>
    </ul>

    <!-- Section Principale -->
    <div class="table-data">
        <!-- Graphique Linéaire : Évolution des étudiants -->
        <div class="order mb-6">
            <div class="head">
                <h3>Évolution des Étudiants</h3>
                <a href="{{ route('annees.index') }}">Voir tout</a>
            </div>
            <div class="chart-container" style="height: 300px;">
                <canvas id="chartLine"></canvas>
            </div>
        </div>

        <!-- Graphique Barres : Étudiants par Spécialité -->
        <div class="order mb-6">
            <div class="head">
                <h3>Répartition par Spécialité</h3>
                <a href="{{ route('specialites.index') }}">Voir tout</a>
            </div>
            <div class="chart-container" style="height: 300px;">
                <canvas id="chartBar"></canvas>
            </div>
        </div>

        <!-- Tableau : Dernières Évaluations -->
        <div class="order">
            <div class="head">
                <h3>Dernières Évaluations</h3>
                <i class='bx bx-search'></i>
                <i class='bx bx-filter'></i>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Étudiant</th>
                        <th>Module</th>
                        <th>Note</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentEvaluations as $eval)
                    <tr>
                        <td>
                            <div class="flex items-center gap-2">
                                <img src="{{ Storage::url($eval->user->profile ?? '') }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
                                <p>{{ $eval->user->nom }} {{ $eval->user->prenom ?? '' }}</p>
                            </div>
                        </td>
                        <td>{{ $eval->module->code }} - {{ $eval->module->intitule }}</td>
                        <td>
                            <span class="badge {{ $eval->note >= 10 ? 'badge-success' : 'badge-warning' }}">
                                {{ number_format($eval->note, 1) }}
                            </span>
                        </td>
                        <td>{{ $eval->created_at ? $eval->created_at->format('d-m-Y') : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sidebar / Todo List (Statique pour l'exemple) -->
    <div class="todo">
        <div class="head">
            <h3>Tâches Administratives</h3>
            <i class='bx bx-plus'></i>
            <i class='bx bx-dots-vertical-rounded'></i>
        </div>
        <ul class="todo-list">
            <li class="completed">
                <p>Vérifier les inscriptions</p>
                <i class='bx bx-dots-vertical-rounded'></i>
            </li>
            <li class="completed">
                <p>Activer l'année académique</p>
                <i class='bx bx-dots-vertical-rounded'></i>
            </li>
            <li class="not-completed">
                <p>Générer les bilans de compétences</p>
                <i class='bx bx-dots-vertical-rounded'></i>
            </li>
            <li class="completed">
                <p>Exporter les relevés de notes</p>
                <i class='bx bx-dots-vertical-rounded'></i>
            </li>
        </ul>
    </div>
</div>
@endsection


{{-- Import Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Récupération des couleurs (Assurez-vous que vos variables CSS existent)
        const primaryColor = '#ef4444'; // Votre couleur principale (ex: Rouge de votre thème)
        const secondaryColor = '#e2e8f0';
        const textColor = '#64748b';
        const gridColor = '#f1f5f9';

        // 1. Graphique LINÉAIRE (Évolution par année)
        const ctxLine = document.getElementById('chartLine').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: @json($studentsPerYear->pluck('anneeAcademique.libelle')), // Noms des années sur l'axe X
                datasets: [{
                    label: 'Nombre d\'Étudiants',
                    data: @json($studentsPerYear->pluck('total')), // Total étudiants sur l'axe Y
                    borderColor: primaryColor,
                    backgroundColor: 'rgba(239, 68, 68, 0.1)', // Rouge transparent
                    borderWidth: 3,
                    tension: 0.4, // Courbe lisse
                    fill: true,
                    pointBackgroundColor: primaryColor,
                    pointBorderColor: '#fff',
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor },
                        ticks: { color: textColor }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: textColor }
                    }
                }
            }
        });

        // 2. Graphique BARRES (Étudiants par Spécialité)
        const ctxBar = document.getElementById('chartBar').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: @json($studentsPerSpeciality->pluck('intitule')), // Noms des spécialités
                datasets: [{
                    label: 'Étudiants',
                    data: @json($studentsPerSpeciality->pluck('users_count')),
                    backgroundColor: primaryColor,
                    borderRadius: 6,
                    barThickness: 20
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor },
                        ticks: { color: textColor }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: textColor }
                    }
                }
            }
        });
    });
</script>

<style>
    /* Styles spécifiques pour le Dashboard */
    .head-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .left h1 {
        font-size: 24px;
        font-weight: 700;
        color: var(--foreground);
        margin-bottom: 0;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        font-size: 14px;
        color: var(--muted-foreground);
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .breadcrumb li {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .breadcrumb li i {
        font-size: 12px;
    }

    .breadcrumb a {
        text-decoration: none;
        color: var(--muted-foreground);
        transition: color 0.2s;
    }
    
    .breadcrumb a:hover, .breadcrumb a.active {
        color: var(--primary);
    }

    /* En-tête profil administrateur */
    .user-profile-header {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px 20px;
        background: var(--card);
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--border);
    }

    .profile-header-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--primary);
    }

    .profile-header-avatar-placeholder {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--primary);
        color: var(--primary-foreground);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: bold;
        border: 3px solid var(--primary);
    }

    .profile-header-info h3 {
        margin: 0 0 5px 0;
        font-size: 18px;
        font-weight: 600;
        color: var(--foreground);
    }

    .profile-header-info p {
        margin: 0 0 8px 0;
        font-size: 14px;
        color: var(--muted-foreground);
    }

    .role-badge.admin {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Box Info (Stats) */
    .box-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 30px;
    }

    .box-info li {
        display: flex;
        align-items: center;
        padding: 20px;
        background: var(--card);
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .box-info li i {
        font-size: 32px;
        color: var(--primary);
        margin-right: 15px;
    }

    .box-info li h3 {
        font-size: 24px;
        font-weight: 700;
        margin: 0;
        color: var(--foreground);
    }

    .box-info li p {
        font-size: 13px;
        color: var(--muted-foreground);
        margin: 0;
    }

    /* Layout principal */
    .table-data {
        display: grid;
        grid-template-columns: 2.5fr 1fr; /* Tableau prend plus de place que le todo */
        gap: 24px;
    }

    /* Section Ordre (Table + Graphiques) */
    .order .head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .order .head h3 {
        font-size: 18px;
        font-weight: 600;
        color: var(--foreground);
        margin: 0;
    }

    .order .head a {
        font-size: 13px;
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }

    .chart-container {
        position: relative;
        width: 100%;
    }

    /* Table */
    table {
        width: 100%;
        border-collapse: collapse;
        background: var(--card);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    table thead {
        background: var(--secondary);
    }

    table th {
        padding: 12px 15px;
        text-align: left;
        font-size: 13px;
        font-weight: 600;
        color: var(--muted-foreground);
    }

    table td {
        padding: 12px 15px;
        border-bottom: 1px solid var(--border);
        font-size: 14px;
        color: var(--foreground);
    }

    table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }
    .badge-success {
        background: #dcfce7;
        color: #166534;
    }
    .badge-warning {
        background: #fef9c3;
        color: #854d0e;
    }

    /* Todo List */
    .todo .head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .todo .head h3 {
        font-size: 18px;
        font-weight: 600;
        color: var(--foreground);
        margin: 0;
    }

    .todo .head i {
        cursor: pointer;
        font-size: 20px;
        color: var(--muted-foreground);
    }

    .todo-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .todo-list li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        background: var(--card);
        border-radius: 10px;
        margin-bottom: 10px;
        border-left: 4px solid var(--border);
    }

    .todo-list li.completed {
        border-left-color: #22c55e; /* Vert pour fait */
    }

    .todo-list li.completed p {
        text-decoration: line-through;
        color: var(--muted-foreground);
    }

    .todo-list li.not-completed {
        border-left-color: #ef4444; /* Rouge pour à faire */
    }

    .todo-list li p {
        margin: 0;
        font-size: 14px;
        color: var(--foreground);
    }

    /* Responsif */
    @media (max-width: 1024px) {
        .table-data {
            grid-template-columns: 1fr;
        }
        .box-info {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
