<x-app-layout title="Tableau de Bord Administrateur">
    <div class="py-12">
        <!-- En-tête Admin -->
        <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-start mb-6 md:mb-8 flex-wrap gap-5">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-foreground mb-0">Dashboard Administrateur</h1>
                <ul class="flex items-center text-muted-foreground list-none p-0 mt-2 mb-0">
                    <li class="flex items-center">
                        <a href="{{ route('dashboard') }}"
                            class="no-underline text-muted-foreground transition-colors duration-200 hover:text-primary">Accueil</a>
                    </li>
                    <li class="flex items-center"><i class='bx bx-chevron-right px-1'></i></li>
                    <li class="flex items-center text-primary">Administration</li>
                </ul>
            </div>
            <div
                class="flex flex-col md:flex-row items-center text-center md:text-left gap-3 md:gap-4 p-4 md:p-5 bg-card rounded-xl shadow border border-border order-first lg:order-none">
                @if ($user->profile)
                    <img src="{{ Storage::url($user->profile) }}" alt="Photo de profil"
                        class="w-16 h-16 rounded-full object-cover border-[3px] border-primary">
                @else
                    <div
                        class="w-16 h-16 rounded-full bg-primary text-primary-foreground flex items-center justify-center text-2xl font-bold border-[3px] border-primary">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h3 class="m-0 mb-1 text-lg font-semibold text-foreground">{{ $user->name }}</h3>
                    <p class="m-0 mb-2 text-sm text-muted-foreground">{{ $user->email }}</p>
                    <span
                        class="bg-gradient-to-br from-[#667eea] to-[#764ba2] text-white px-3 py-1 rounded-full text-xs font-semibold">{{ ucfirst($user->role->value) }}</span>
                </div>
            </div>
        </div>

        <!-- KPIs Globaux -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-card p-4 rounded-xl border border-border/50 shadow-xs flex items-center justify-between transition-all duration-200 hover:border-primary/30">
                <div>
                    <p class="text-[11px] font-semibold uppercase  text-muted-foreground">Étudiants</p>
                    <h3 class="text-xl md:text-2xl font-bold text-foreground mt-1">{{ $totalStudents }}</h3>
                </div>
                <div class="w-9 h-9 rounded-lg bg-indigo-500/10 flex items-center justify-center flex-shrink-0">
                    <i class='bx bxs-group text-base text-indigo-600 dark:text-indigo-400'></i>
                </div>
            </div>
            <div class="bg-card p-4 rounded-xl border border-border/50 shadow-xs flex items-center justify-between transition-all duration-200 hover:border-primary/30">
                <div>
                    <p class="text-[11px] font-semibold uppercase  text-muted-foreground">Évaluations</p>
                    <h3 class="text-xl md:text-2xl font-bold text-foreground mt-1">{{ $totalEvaluations }}</h3>
                </div>
                <div class="w-9 h-9 rounded-lg bg-rose-500/10 flex items-center justify-center flex-shrink-0">
                    <i class='bx bxs-note text-base text-rose-600 dark:text-rose-400'></i>
                </div>
            </div>
            <div class="bg-card p-4 rounded-xl border border-border/50 shadow-xs flex items-center justify-between transition-all duration-200 hover:border-primary/30">
                <div>
                    <p class="text-[11px] font-semibold uppercase  text-muted-foreground">Spécialités</p>
                    <h3 class="text-xl md:text-2xl font-bold text-foreground mt-1">{{ $totalSpecialites }}</h3>
                </div>
                <div class="w-9 h-9 rounded-lg bg-amber-500/10 flex items-center justify-center flex-shrink-0">
                    <i class='bx bxs-book-bookmark text-base text-amber-600 dark:text-amber-400'></i>
                </div>
            </div>
            <div class="bg-card p-4 rounded-xl border border-border/50 shadow-xs flex items-center justify-between transition-all duration-200 hover:border-primary/30">
                <div>
                    <p class="text-[11px] font-semibold uppercase  text-muted-foreground">Modules</p>
                    <h3 class="text-xl md:text-2xl font-bold text-foreground mt-1">{{ $totalModules }}</h3>
                </div>
                <div class="w-9 h-9 rounded-lg bg-teal-500/10 flex items-center justify-center flex-shrink-0">
                    <i class='bx bxs-book text-base text-teal-600 dark:text-teal-400'></i>
                </div>
            </div>
        </div>


        <!-- Statistiques des Rôles -->
        <div class="bg-card p-5 rounded-xl border border-border/50 shadow-xs mb-7">
            <h3 class="text-[11px] font-bold uppercase  text-muted-foreground/85 flex items-center gap-2 mb-4 pb-3 border-b border-border/30">
                <i class='bx bx-shield-quarter text-base text-primary/70'></i> Répartition des Rôles
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-0 divide-border/40 md:divide-x">
                <div class="flex flex-col px-1 md:px-6">
                    <span class="text-[13px] text-muted-foreground font-medium">Super Admin</span>
                    <span class="text-2xl font-bold text-foreground mt-0.5 tracking-tight">{{ $roleStats['superadmin'] }}</span>
                </div>
                <div class="flex flex-col px-1 md:px-6">
                    <span class="text-[13px] text-muted-foreground font-medium">Admin</span>
                    <span class="text-2xl font-bold text-foreground mt-0.5 tracking-tight">{{ $roleStats['admin'] }}</span>
                </div>
                <div class="flex flex-col px-1 md:px-6 mt-3 md:mt-0 pt-3 md:pt-0 border-t md:border-t-0 border-border/30">
                    <span class="text-[13px] text-muted-foreground font-medium">Manager</span>
                    <span class="text-2xl font-bold text-foreground mt-0.5 tracking-tight">{{ $roleStats['manager'] }}</span>
                </div>
                <div class="flex flex-col px-1 md:px-6 mt-3 md:mt-0 pt-3 md:pt-0 border-t md:border-t-0 border-border/30">
                    <span class="text-[13px] text-muted-foreground font-medium">Étudiants</span>
                    <span class="text-2xl font-bold text-foreground mt-0.5 tracking-tight">{{ $roleStats['student'] }}</span>
                </div>
            </div>
        </div>

        <!-- Section Principale -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Graphique Linéaire : Évolution des Étudiants -->
            <div class="lg:col-span-2 bg-card rounded-xl p-6 shadow border border-border mb-6 lg:mb-0">
                <div class="flex flex-col md:flex-row justify-between md:items-center mb-5 gap-2 md:gap-0">
                    <h3 class="m-0 text-lg font-semibold text-foreground">Évolution des Étudiants par Année</h3>
                    <a href="{{ route('users.index') }}"
                        class="text-primary no-underline text-sm font-medium hover:underline">Voir tout</a>
                </div>
                <div class="relative h-[300px]">
                    <canvas id="studentsChart"></canvas>
                </div>
            </div>

            <!-- Graphique Barres : Étudiants par Spécialité -->
            <div class="lg:col-span-1 bg-card rounded-xl p-6 shadow border border-border mb-6 lg:mb-0">
                <div class="flex flex-col md:flex-row justify-between md:items-center mb-5 gap-2 md:gap-0">
                    <h3 class="m-0 text-lg font-semibold text-foreground">Étudiants par Spécialité</h3>
                    <a href="{{ route('specialites.index') }}"
                        class="text-primary no-underline text-sm font-medium hover:underline">Détails</a>
                </div>
                <div class="relative h-[300px]">
                    <canvas id="specialityChart"></canvas>
                </div>
            </div>

           
        </div>
         <!-- Tableau : Activité Récente -->
            <div class="lg:col-span-2 bg-card rounded-xl p-6 mt-7 shadow border border-border">
                <div class="flex flex-col md:flex-row justify-between md:items-center mb-5 gap-2 md:gap-0">
                    <h3 class="m-0 text-lg font-semibold text-foreground">Activité Récente</h3>
                    <a href="{{ route('evaluations.index') }}"
                        class="text-primary no-underline text-sm font-medium hover:underline">Voir tout</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-[13px] md:text-sm">
                        <thead>
                            <tr>
                                <th
                                    class="text-left p-2 md:p-3 border-b border-border font-semibold text-foreground text-xs md:text-sm">
                                    Étudiant</th>
                                <th
                                    class="text-left p-2 md:p-3 border-b border-border font-semibold text-foreground text-xs md:text-sm">
                                    Module</th>
                                <th
                                    class="text-left p-2 md:p-3 border-b border-border font-semibold text-foreground text-xs md:text-sm">
                                    Note</th>
                                <th
                                    class="text-left p-2 md:p-3 border-b border-border font-semibold text-foreground text-xs md:text-sm">
                                    Semestre</th>
                                <th
                                    class="text-left p-2 md:p-3 border-b border-border font-semibold text-foreground text-xs md:text-sm">
                                    Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentEvaluations as $evaluation)
                                <tr class="hover:bg-accent transition-colors duration-150">
                                    <td class="p-2 md:p-3 border-b border-border text-xs md:text-sm text-foreground">
                                        {{ $evaluation->user->name }}</td>
                                    <td class="p-2 md:p-3 border-b border-border text-xs md:text-sm text-foreground">
                                        {{ $evaluation->module->intitule }}</td>
                                    <td class="p-2 md:p-3 border-b border-border text-xs md:text-sm text-foreground">
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-semibold {{ $evaluation->note >= 10 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                            {{ number_format($evaluation->note, 2) }}
                                        </span>
                                    </td>
                                    <td class="p-2 md:p-3 border-b border-border text-xs md:text-sm text-foreground">
                                        S{{ $evaluation->semestre }}</td>
                                    <td class="p-2 md:p-3 border-b border-border text-xs md:text-sm text-foreground">
                                        {{ $evaluation->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center border-b border-border text-muted-foreground">
                                        Aucune évaluation récente</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
    </div>

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
</x-app-layout>
