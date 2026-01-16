@extends('layouts.app')

@section('title', 'Mon Tableau de Bord')

@section('content')
<div class="py-12">
    <!-- En-tête Étudiant -->
    <div class="head-title">
        <div class="left">
            <h1>Mon Dashboard</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">Accueil</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li class="active">Mes Résultats</li>
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
                @if($user->specialite)
                    <span class="speciality-badge">{{ $user->specialite->intitule }}</span>
                @endif
            </div>
        </div>
    </div>

    <!-- KPIs Personnels -->
    <ul class="box-info">
        <li>
            <i class='bx bxs-chart-line'></i>
            <span class="text">
                <h3>{{ number_format($moyenneGenerale ?? 0, 2) }}</h3>
                <p>Moyenne Générale</p>
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
            <i class='bx bxs-book'></i>
            <span class="text">
                <h3>{{ $modulesCount }}</h3>
                <p>Modules</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-trophy'></i>
            <span class="text">
                <h3>{{ $recentEvaluations->where('note', '>=', 10)->count() }}/{{ $totalEvaluations }}</h3>
                <p>Validées</p>
            </span>
        </li>
    </ul>

    <!-- Section Principale -->
    <div class="table-data">
        <!-- Graphique Linéaire : Évolution par Semestre -->
        <div class="order mb-6">
            <div class="head">
                <h3>Évolution par Semestre</h3>
                <a href="{{ route('evaluations.releve-notes', $user->id) }}">Voir tout</a>
            </div>
            <div class="chart-container" style="height: 300px;">
                <canvas id="chartLine"></canvas>
            </div>
        </div>

        <!-- Graphique Barres : Mes Notes par Module -->
        <div class="order mb-6">
            <div class="head">
                <h3>Mes Notes par Module</h3>
                <a href="{{ route('evaluations.releve-notes', $user->id) }}">Détails</a>
            </div>
            <div class="chart-container" style="height: 300px;">
                <canvas id="chartBar"></canvas>
            </div>
        </div>

        <!-- Tableau : Mes Dernières Évaluations -->
        <div class="order">
            <div class="head">
                <h3>Mes Dernières Évaluations</h3>
                <a href="{{ route('evaluations.releve-notes', $user->id) }}">Voir tout</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Module</th>
                        <th>Note</th>
                        <th>Semestre</th>
                        <th>Appréciation</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentEvaluations as $evaluation)
                        <tr>
                            <td>{{ $evaluation->module->intitule }}</td>
                            <td>
                                <span class="note-badge {{ $evaluation->note >= 10 ? 'success' : 'danger' }}">
                                    {{ number_format($evaluation->note, 2) }}
                                </span>
                            </td>
                            <td>S{{ $evaluation->semestre }}</td>
                            <td>{{ $evaluation->getAppreciation() }}</td>
                            <td>{{ $evaluation->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Aucune évaluation pour le moment</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Sidebar : Mes Résultats par Semestre -->
        <div class="todo">
            <div class="head">
                <h3>Mes Résultats par Semestre</h3>
                <div class="semester-tabs">
                    <button class="semester-tab active" data-semester="1">Semestre 1</button>
                    <button class="semester-tab" data-semester="2">Semestre 2</button>
                </div>
            </div>
            
            <!-- Semestre 1 -->
            <div class="semester-content" id="semester1">
                <div class="semester-header">
                    <h4>Semestre 1</h4>
                    <span class="moyenne-badge">Moyenne: {{ number_format($moyenneSemestre1 ?? 0, 2) }}</span>
                </div>
                <ul class="todo-list">
                    @forelse($modulesSemestre1 as $evaluation)
                        <li class="completed">
                            <div class="module-info">
                                <span>{{ $evaluation->module->intitule }}</span>
                                <span class="note">{{ number_format($evaluation->note, 2) }}/20</span>
                            </div>
                        </li>
                    @empty
                        <li class="no-data">
                            <span>Aucune évaluation pour le semestre 1</span>
                        </li>
                    @endforelse
                </ul>
            </div>
            
            <!-- Semestre 2 -->
            <div class="semester-content" id="semester2" style="display: none;">
                <div class="semester-header">
                    <h4>Semestre 2</h4>
                    <span class="moyenne-badge">Moyenne: {{ number_format($moyenneSemestre2 ?? 0, 2) }}</span>
                </div>
                <ul class="todo-list">
                    @forelse($modulesSemestre2 as $evaluation)
                        <li class="completed">
                            <div class="module-info">
                                <span>{{ $evaluation->module->intitule }}</span>
                                <span class="note">{{ number_format($evaluation->note, 2) }}/20</span>
                            </div>
                        </li>
                    @empty
                        <li class="no-data">
                            <span>Aucune évaluation pour le semestre 2</span>
                        </li>
                    @endforelse
                </ul>
            </div>

            <!-- Actions Rapides -->
            <div class="quick-actions">
                <a href="{{ route('evaluations.releve-notes', $user->id) }}" class="btn-primary">
                    <i class='bx bx-file'></i> Relevé de Notes
                </a>
                <a href="{{ route('profile.edit') }}" class="btn-secondary">
                    <i class='bx bx-user'></i> Mon Profil
                </a>
            </div>
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

.todo {
    background: var(--card);
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--border);
}

.todo .head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.todo .head h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: var(--foreground);
}

.todo-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.todo-list li {
    display: flex;
    align-items: center;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 8px;
    background: var(--accent);
}

.todo-list li.completed {
    background: #f0f9ff;
}

/* Styles spécifiques au dashboard étudiant */
.user-profile-header {
    display: flex;
    align-items: center;
    gap: 1rem;
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
    background: linear-gradient(135deg, var(--primary), var(--primary-hover));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    font-weight: bold;
}

.profile-header-info h3 {
    margin: 0 0 0.25rem 0;
    font-size: 1.25rem;
    color: #1e293b;
}

.profile-header-info p {
    margin: 0 0 0.5rem 0;
    color: #64748b;
    font-size: 0.875rem;
}

.speciality-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
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

/* Styles pour les onglets de semestre */
.semester-tabs {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.semester-tab {
    padding: 0.5rem 1rem;
    border: none;
    background: #f1f5f9;
    color: #64748b;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.875rem;
    font-weight: 500;
}

.semester-tab.active {
    background: var(--primary);
    color: white;
}

.semester-tab:hover:not(.active) {
    background: #e2e8f0;
}

.semester-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 8px;
}

.semester-header h4 {
    margin: 0;
    color: #1e293b;
    font-size: 1rem;
}

.moyenne-badge {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.module-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.module-info .note {
    font-weight: 600;
    color: var(--primary);
}

.todo-list .no-data {
    padding: 1rem;
    text-align: center;
    color: #64748b;
    font-style: italic;
}

/* Actions rapides */
.quick-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}

.btn-primary, .btn-secondary {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-hover);
    color: white;
}

.btn-secondary {
    background: #f1f5f9;
    color: #64748b;
}

.btn-secondary:hover {
    background: #e2e8f0;
    color: #475569;
}

/* Responsive */
@media (max-width: 1024px) {
    .table-data {
        grid-template-columns: 1fr;
    }
    
    .todo {
        order: -1;
    }
}

@media (max-width: 768px) {
    .user-profile-header {
        flex-direction: column;
        text-align: center;
    }
    
    .profile-header-info {
        text-align: center;
    }
    
    .semester-tabs {
        flex-direction: column;
    }
    
    .quick-actions {
        flex-direction: row;
    }
    
    .quick-actions a {
        flex: 1;
        justify-content: center;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Graphique Linéaire : Évolution par Semestre
const lineCtx = document.getElementById('chartLine').getContext('2d');
new Chart(lineCtx, {
    type: 'line',
    data: {
        labels: @json($notesBySemestre->pluck('semestre')->map(fn($s) => "Semestre $s")),
        datasets: [{
            label: 'Moyenne par semestre',
            data: @json($notesBySemestre->pluck('moyenne')),
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
                max: 20
            }
        }
    }
});

// Graphique Barres : Notes par Module
const barCtx = document.getElementById('chartBar').getContext('2d');
new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: @json($notesByModule->pluck('module.intitule')),
        datasets: [{
            label: 'Mes notes',
            data: @json($notesByModule->pluck('moyenne')),
            backgroundColor: [
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)',
                'rgba(199, 199, 199, 0.8)',
                'rgba(83, 102, 255, 0.8)',
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(199, 199, 199, 1)',
                'rgba(83, 102, 255, 1)',
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
                max: 20
            }
        }
    }
});

// Gestion des onglets de semestre
document.querySelectorAll('.semester-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        // Retirer la classe active de tous les onglets
        document.querySelectorAll('.semester-tab').forEach(t => t.classList.remove('active'));
        // Ajouter la classe active à l'onglet cliqué
        this.classList.add('active');
        
        // Cacher tous les contenus
        document.querySelectorAll('.semester-content').forEach(content => {
            content.style.display = 'none';
        });
        
        // Afficher le contenu correspondant
        const semester = this.dataset.semester;
        document.getElementById('semester' + semester).style.display = 'block';
    });
});
</script>
@endsection
