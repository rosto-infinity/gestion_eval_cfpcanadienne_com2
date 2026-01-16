@extends('layouts.app')

@section('title', 'Tableau de Bord Administrateur')

@section('content')
<div class="py-12">
    <!-- En-tête Admin -->
    <div class="head-title">
        <div class="left">
            <h1>Dashboard Administrateur</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">Accueil</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li class="active">Administration</li>
            </ul>
        </div>
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
                <span class="role-badge admin">{{ ucfirst($user->role->value) }}</span>
            </div>
        </div>
    </div>

    <!-- KPIs Globaux -->
    <ul class="box-info">
        <li>
            <i class='bx bxs-group'></i>
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
            <i class='bx bxs-book-bookmark'></i>
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

    <!-- Statistiques des Rôles -->
    <div class="order mb-6">
        <div class="head">
            <h3>Répartition des Rôles</h3>
        </div>
        <div class="role-stats-grid">
            <div class="role-stat-card">
                <div class="role-icon superadmin">👑</div>
                <div class="role-info">
                    <h4>Super Admin</h4>
                    <p>{{ $roleStats['superadmin'] }}</p>
                </div>
            </div>
            <div class="role-stat-card">
                <div class="role-icon admin">🛡️</div>
                <div class="role-info">
                    <h4>Admin</h4>
                    <p>{{ $roleStats['admin'] }}</p>
                </div>
            </div>
            <div class="role-stat-card">
                <div class="role-icon manager">📋</div>
                <div class="role-info">
                    <h4>Manager</h4>
                    <p>{{ $roleStats['manager'] }}</p>
                </div>
            </div>
            <div class="role-stat-card">
                <div class="role-icon student">🎓</div>
                <div class="role-info">
                    <h4>Étudiants</h4>
                    <p>{{ $roleStats['student'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Principale -->
    <div class="table-data">
        <!-- Graphique Linéaire : Évolution des Étudiants -->
        <div class="order mb-6">
            <div class="head">
                <h3>Évolution des Étudiants par Année</h3>
                <a href="{{ route('users.index') }}">Voir tout</a>
            </div>
            <div class="chart-container" style="height: 300px;">
                <canvas id="studentsChart"></canvas>
            </div>
        </div>

        <!-- Graphique Barres : Étudiants par Spécialité -->
        <div class="order mb-6">
            <div class="head">
                <h3>Étudiants par Spécialité</h3>
                <a href="{{ route('specialites.index') }}">Détails</a>
            </div>
            <div class="chart-container" style="height: 300px;">
                <canvas id="specialityChart"></canvas>
            </div>
        </div>

        <!-- Tableau : Activité Récente -->
        <div class="order">
            <div class="head">
                <h3>Activité Récente</h3>
                <a href="{{ route('evaluations.index') }}">Voir tout</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Étudiant</th>
                        <th>Module</th>
                        <th>Note</th>
                        <th>Semestre</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentEvaluations as $evaluation)
                        <tr>
                            <td>{{ $evaluation->user->name }}</td>
                            <td>{{ $evaluation->module->intitule }}</td>
                            <td>
                                <span class="note-badge {{ $evaluation->note >= 10 ? 'success' : 'danger' }}">
                                    {{ number_format($evaluation->note, 2) }}
                                </span>
                            </td>
                            <td>S{{ $evaluation->semestre }}</td>
                            <td>{{ $evaluation->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Aucune évaluation récente</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
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
    border: 1px solid var(--border);
    transition: transform 0.2s, box-shadow 0.2s;
}

.box-info li:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 12px -1px rgba(0, 0, 0, 0.15);
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
    grid-template-columns: 2fr 1fr;
    gap: 24px;
}

.order {
    background: var(--card);
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--border);
}

.order .head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.order .head h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: var(--foreground);
}

.order .head a {
    color: var(--primary);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

.order .head a:hover {
    text-decoration: underline;
}

.chart-container {
    position: relative;
    height: 300px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th {
    text-align: left;
    padding: 12px;
    border-bottom: 1px solid var(--border);
    font-weight: 600;
    color: var(--foreground);
    font-size: 14px;
}

table td {
    padding: 12px;
    border-bottom: 1px solid var(--border);
    font-size: 14px;
    color: var(--foreground);
}

table tr:hover {
    background: var(--accent);
}

.text-center {
    text-align: center;
}

/* Styles spécifiques au dashboard admin */
.head-title {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
}

.head-title .left h1 {
    font-size: 28px;
    font-weight: 700;
    color: var(--foreground);
    margin-bottom: 0;
}

.head-title .left .breadcrumb {
    display: flex;
    align-items: center;
    color: var(--muted-foreground);
    list-style: none;
    padding: 0;
    margin: 8px 0 0 0;
}

.head-title .left .breadcrumb li {
    display: flex;
    align-items: center;
}

.head-title .left .breadcrumb a {
    text-decoration: none;
    color: var(--muted-foreground);
    transition: color 0.2s;
}

.head-title .left .breadcrumb a:hover, .head-title .left .breadcrumb li.active {
    color: var(--primary);
}

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

.role-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.role-stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: transform 0.2s, box-shadow 0.2s;
}

.role-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

.role-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.role-icon.superadmin {
    background: linear-gradient(135deg, #ff6b6b, #c92a2a);
}

.role-icon.admin {
    background: linear-gradient(135deg, #4dabf7, #1864ab);
}

.role-icon.manager {
    background: linear-gradient(135deg, #69db7c, #2f9e44);
}

.role-icon.student {
    background: linear-gradient(135deg, #ffd43b, #fab005);
}

.role-info h4 {
    margin: 0 0 0.25rem 0;
    font-size: 0.875rem;
    color: #64748b;
}

.role-info p {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
}

.note-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 600;
}

.note-badge.success {
    background: #d4edda;
    color: #155724;
}

.note-badge.danger {
    background: #f8d7da;
    color: #721c24;
}

/* Responsive */
@media (max-width: 1024px) {
    .table-data {
        grid-template-columns: 1fr;
    }
    
    .role-stats-grid {
        grid-template-columns: 1fr;
    }
    
    .head-title {
        flex-direction: column;
        align-items: stretch;
    }
    
    .user-profile-header {
        order: -1;
    }
}

@media (max-width: 768px) {
    .role-stats-grid {
        grid-template-columns: 1fr;
    }
    
    .role-stat-card {
        padding: 1rem;
    }
    
    .role-icon {
        width: 40px;
        height: 40px;
        font-size: 1.25rem;
    }
    
    .head-title {
        margin-bottom: 20px;
    }
    
    .head-title .left h1 {
        font-size: 24px;
    }
    
    .user-profile-header {
        flex-direction: column;
        text-align: center;
        gap: 12px;
    }
    
    .profile-header-info {
        text-align: center;
    }
    
    .order .head {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    table {
        font-size: 13px;
    }
    
    table th, table td {
        padding: 8px 10px;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Graphique Linéaire : Évolution des Étudiants
const studentsCtx = document.getElementById('studentsChart').getContext('2d');
new Chart(studentsCtx, {
    type: 'line',
    data: {
        labels: @json($studentsPerYear->pluck('anneeAcademique.libelle')),
        datasets: [{
            label: 'Nombre d\'étudiants',
            data: @json($studentsPerYear->pluck('total')),
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Graphique Barres : Étudiants par Spécialité
const specialityCtx = document.getElementById('specialityChart').getContext('2d');
new Chart(specialityCtx, {
    type: 'bar',
    data: {
        labels: @json($studentsPerSpeciality->pluck('intitule')),
        datasets: [{
            label: 'Nombre d\'étudiants',
            data: @json($studentsPerSpeciality->pluck('users_count')),
            backgroundColor: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>
@endsection
