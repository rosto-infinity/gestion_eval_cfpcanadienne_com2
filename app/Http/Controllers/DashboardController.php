<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Resources\DashboardStatsResource;
use App\Models\Evaluation;
use App\Models\Module;
use App\Models\Specialite;
use App\Models\User;
use Illuminate\Support\Facades\Concurrency;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = auth()->user();
        $isAdmin = in_array($user->role->value, [
            Role::SUPERADMIN->value,
            Role::ADMIN->value,
            Role::MANAGER->value,
        ]);

        return $isAdmin
            ? $this->adminDashboard($user)
            : $this->studentDashboard($user);
    }

    private function adminDashboard(User $user): View
    {
        [$totalStudents, $totalEvaluations, $totalSpecialites, $totalModules, $studentsPerYear, $studentsPerSpeciality, $recentEvaluations, $roleStats] = Concurrency::run([
            fn () => User::studentsOnly()->count(),
            fn () => Evaluation::count(),
            fn () => Specialite::count(),
            fn () => Module::count(),
            fn () => User::studentsOnly()
                ->select('annee_academique_id', DB::raw('count(*) as total'))
                ->with('anneeAcademique:id,libelle')
                ->groupBy('annee_academique_id')
                ->orderBy('annee_academique_id')
                ->get(),
            fn () => Specialite::withCount(['users' => function ($query): void {
                $query->studentsOnly();
            }])
                ->orderBy('users_count', 'desc')
                ->get(),
            fn () => Evaluation::with(['user', 'module', 'specialite', 'anneeAcademique'])
                ->latest()
                ->take(10)
                ->get(),
            fn () => [
                'superadmin' => User::where('role', Role::SUPERADMIN->value)->count(),
                'admin' => User::where('role', Role::ADMIN->value)->count(),
                'manager' => User::where('role', Role::MANAGER->value)->count(),
                'student' => User::studentsOnly()->count(),
            ],
        ]);

        $stats = new DashboardStatsResource((object) [
            'total_students' => $totalStudents,
            'total_evaluations' => $totalEvaluations,
            'total_specialites' => $totalSpecialites,
            'total_modules' => $totalModules,
        ]);

        return view('dashboard.admin', compact(
            'user',
            'stats',
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
        $anneeId = $user->annee_academique_id ?? 1;

        [$userEvaluations, $notesBySemestre, $notesByModule, $recentEvaluations] = Concurrency::run([
            fn () => Evaluation::where('user_id', $user->id)
                ->with(['module', 'specialite', 'anneeAcademique'])
                ->get(),
            fn () => Evaluation::select('semestre', DB::raw('avg(note) as moyenne, count(*) as count'))
                ->where('user_id', $user->id)
                ->where('annee_academique_id', $anneeId)
                ->groupBy('semestre')
                ->orderBy('semestre')
                ->get(),
            fn () => Evaluation::with('module:id,intitule')
                ->select('module_id', DB::raw('avg(note) as moyenne'))
                ->where('user_id', $user->id)
                ->where('annee_academique_id', $anneeId)
                ->groupBy('module_id')
                ->orderBy('moyenne', 'desc')
                ->take(8)
                ->get(),
            fn () => Evaluation::with(['module', 'specialite', 'anneeAcademique'])
                ->where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get(),
        ]);

        $totalEvaluations = $userEvaluations->count();
        $moyenneGenerale = $userEvaluations->avg('note');
        $modulesCount = $userEvaluations->pluck('module_id')->unique()->count();
        $modulesSemestre1 = $userEvaluations->filter(fn ($eval) => $eval->semestre === 1);
        $modulesSemestre2 = $userEvaluations->filter(fn ($eval) => $eval->semestre === 2);
        $moyenneSemestre1 = $modulesSemestre1->avg('note');
        $moyenneSemestre2 = $modulesSemestre2->avg('note');

        $stats = new DashboardStatsResource((object) [
            'total_evaluations' => $totalEvaluations,
            'moyenne_generale' => $moyenneGenerale ? round((float) $moyenneGenerale, 2) : null,
            'modules_count' => $modulesCount,
        ]);

        return view('dashboard.student', compact(
            'user',
            'stats',
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
