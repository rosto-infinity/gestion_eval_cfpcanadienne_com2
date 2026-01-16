<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Evaluation;
use App\Models\Module;
use App\Models\Specialite;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        
        // Vérifier si l'utilisateur est un administrateur
        $isAdmin = in_array($user->role->value, [
            Role::SUPERADMIN->value,
            Role::ADMIN->value,
            Role::MANAGER->value
        ]);

        if ($isAdmin) {
            return $this->adminDashboard($user);
        } else {
            return $this->studentDashboard($user);
        }
    }

    private function adminDashboard(User $user): View
    {
        // 1. Statistiques globales (uniquement les étudiants)
        $totalStudents = User::studentsOnly()->count();
        $totalEvaluations = Evaluation::count();
        $totalSpecialites = Specialite::count();
        $totalModules = Module::count();

        // 2. Données pour le Graphique Linéaire (Évolution par année académique)
        $studentsPerYear = User::studentsOnly()
            ->select('annee_academique_id', DB::raw('count(*) as total'))
            ->with('anneeAcademique:id,libelle')
            ->groupBy('annee_academique_id')
            ->orderBy('annee_academique_id')
            ->get();

        // 3. Données pour le Graphique Barres (Étudiants par Spécialité)
        $studentsPerSpeciality = Specialite::withCount(['users' => function ($query) {
            $query->studentsOnly();
        }])
            ->orderBy('users_count', 'desc')
            ->get();

        // 4. Données pour le tableau "Activité récente" (Dernières évaluations)
        $recentEvaluations = Evaluation::with(['user', 'module', 'specialite', 'anneeAcademique'])
            ->latest()
            ->take(10)
            ->get();

        // 5. Statistiques des rôles
        $roleStats = [
            'superadmin' => User::where('role', Role::SUPERADMIN->value)->count(),
            'admin' => User::where('role', Role::ADMIN->value)->count(),
            'manager' => User::where('role', Role::MANAGER->value)->count(),
            'student' => User::studentsOnly()->count(),
        ];

        return view('dashboard.admin', compact(
            'user',
            'totalStudents',
            'totalEvaluations',
            'totalSpecialites',
            'totalModules',
            'studentsPerYear',
            'studentsPerSpeciality',
            'recentEvaluations',
            'roleStats'
        ));
    }

    private function studentDashboard(User $user): View
    {
        // 1. Statistiques personnelles de l'utilisateur
        $userEvaluations = Evaluation::where('user_id', $user->id)
            ->with(['module', 'specialite', 'anneeAcademique'])
            ->get();
        
        $totalEvaluations = $userEvaluations->count();
        $moyenneGenerale = $userEvaluations->avg('note');
        $modulesCount = $userEvaluations->pluck('module_id')->unique()->count();
        
        // 2. Données pour le Graphique Linéaire (Évolution des notes par semestre)
        $notesBySemestre = Evaluation::select('semestre', DB::raw('avg(note) as moyenne, count(*) as count'))
            ->where('user_id', $user->id)
            ->where('annee_academique_id', $user->annee_academique_id ?? 1)
            ->groupBy('semestre')
            ->orderBy('semestre')
            ->get();

        // 3. Données pour le Graphique Barres (Répartition des notes par module)
        $notesByModule = Evaluation::with('module:id,intitule')
            ->select('module_id', DB::raw('avg(note) as moyenne'))
            ->where('user_id', $user->id)
            ->where('annee_academique_id', $user->annee_academique_id ?? 1)
            ->groupBy('module_id')
            ->orderBy('moyenne', 'desc')
            ->take(8) // Limiter à 8 modules pour la lisibilité
            ->get();

        // 4. Données pour le tableau (Dernières évaluations de l'utilisateur)
        $recentEvaluations = Evaluation::with(['module', 'specialite', 'anneeAcademique'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // 5. Modules par semestre pour l'affichage détaillé
        $modulesSemestre1 = $userEvaluations->filter(fn($eval) => $eval->semestre === 1);
        $modulesSemestre2 = $userEvaluations->filter(fn($eval) => $eval->semestre === 2);
        
        $moyenneSemestre1 = $modulesSemestre1->avg('note');
        $moyenneSemestre2 = $modulesSemestre2->avg('note');

        return view('dashboard.student', compact(
            'user',
            'totalEvaluations',
            'moyenneGenerale',
            'modulesCount',
            'notesBySemestre',
            'notesByModule',
            'recentEvaluations',
            'modulesSemestre1',
            'modulesSemestre2',
            'moyenneSemestre1',
            'moyenneSemestre2'
        ));
    }
}
