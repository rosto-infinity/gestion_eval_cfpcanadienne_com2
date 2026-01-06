<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Module;
use App\Models\Specialite;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // 1. Statistiques pour les "Box Info" (Haut de page)
        $totalStudents = User::count();
        $totalEvaluations = Evaluation::count();
        $totalSpecialites = Specialite::count();
        $totalModules = Module::count();

        // 2. Données pour le Graphique Linéaire (Évolution par année)
        // On récupère le nombre d'étudiants par année académique
        $studentsPerYear = User::select('annee_academique_id', DB::raw('count(*) as total'))
            ->with('anneeAcademique:id,libelle') // Charge le nom de l'année
            ->groupBy('annee_academique_id')
            ->orderBy('annee_academique_id')
            ->get();

        // 3. Données pour le Graphique Barres (Étudiants par Spécialité)
        $studentsPerSpeciality = Specialite::withCount('users')
            ->orderBy('users_count', 'desc')
            ->get();

        // 4. Données pour le tableau "Table Data" (Activité récente)
        // On récupère les dernières évaluations
        $recentEvaluations = Evaluation::with(['user', 'module'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalStudents',
            'totalEvaluations',
            'totalSpecialites',
            'totalModules',
            'studentsPerYear',
            'studentsPerSpeciality',
            'recentEvaluations'
        ));
    }
}
