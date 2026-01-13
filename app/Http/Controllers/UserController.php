<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\User;
use App\Enums\Niveau;
use Illuminate\View\View;
use App\Models\Specialite;
use Illuminate\Support\Str;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;

use App\Models\AnneeAcademique;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Exports\UsersBySpecialiteExport;
use App\Http\Requests\UpdateUserRequest;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Laravel\Facades\Image;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        // ✅ IMPORTANT : Charger les relations AVANT paginate()
        $query = User::query()
            ->with(['specialite', 'anneeAcademique']);
        // dd($query);
        // Recherche
        if ($search = $request->input('search')) {
            $query->search($search);
        }

        // Filtre par spécialité
        if ($specialiteId = $request->input('specialite_id')) {
            $query->where('specialite_id', $specialiteId);
        }

        // Filtre par année académique
        if ($anneeId = $request->input('annee_id')) {
            $query->where('annee_academique_id', $anneeId);
        }

        // ✅ Paginer APRÈS avoir construit la query
        $users = $query->ordered()->paginate(20);

        $specialites = Specialite::ordered()->get();
        $annees = AnneeAcademique::ordered()->get();
        // dd($specialites, $annees);

        return view('users.index', compact('users', 'specialites', 'annees'));
    }

    public function create(): View
    {
        $specialites = Specialite::ordered()->get();
        $anneesAcademiques = AnneeAcademique::ordered()->get();
        $niveaux = Niveau::grouped();
        $anneeActive = AnneeAcademique::active()->first();

        return view('users.create', compact('specialites', 'anneesAcademiques', 'niveaux', 'anneeActive'));
    }

    /**
     * Stocke un nouvel utilisateur
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();

            // 📸 Traitement de l'image
            if ($request->hasFile('profile')) {
                $validated['profile'] = $this->handleProfileImage($request->file('profile'));
            }

            // 🔐 Hash du mot de passe
            $validated['password'] = Hash::make($validated['password']);

            // 💾 Création de l'utilisateur
            User::create($validated);

            return redirect()
                ->route('users.index')
                ->with('success', 'Étudiant créé avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur UserController@store: '.$e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la création: '.$e->getMessage());
        }
    }

    public function show(User $user): View
    {
        $user->load(['specialite', 'anneeAcademique', 'evaluations.module', 'bilanCompetence']);

        $stats = [
            'total_evaluations' => $user->evaluations()->count(),
            'evaluations_semestre1' => $user->evaluations()->where('semestre', 1)->count(),
            'evaluations_semestre2' => $user->evaluations()->where('semestre', 2)->count(),
            'moyenne_semestre1' => $user->getMoyenneSemestre(1),
            'moyenne_semestre2' => $user->getMoyenneSemestre(2),
            'has_bilan' => $user->bilanCompetence !== null,
        ];

        return view('users.show', compact('user', 'stats'));
    }

    public function edit(User $user): View
    {
        // On récupère les options du rôle via notre Enum (Standard 2025)
        $roles = Role::cases();
        $user->load(['specialite', 'anneeAcademique']);

        $specialites = Specialite::ordered()->get();
        $anneesAcademiques = AnneeAcademique::ordered()->get();
        $anneeActive = AnneeAcademique::active()->first();
        // CORRECTION : Récupérer les cases de l'Enum Niveau
        $niveaux = \App\Enums\Niveau::cases();

        return view('users.edit', compact('user', 'specialites', 'anneesAcademiques', 'niveaux', 'roles', 'anneeActive'));
    }

    /**
     * Met à jour un utilisateur
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        try {
            $validated = $request->validated();

            // 📸 Traitement de la nouvelle image
            if ($request->hasFile('profile')) {
                if ($user->profile && Storage::disk('public')->exists($user->profile)) {
                    Storage::disk('public')->delete($user->profile);
                }
                $validated['profile'] = $this->handleProfileImage($request->file('profile'));
            }

            // 🔐 Mettre à jour le mot de passe si fourni
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            // 💾 Mise à jour
            $user->update($validated);

            return redirect()
                ->route('users.show', $user)
                ->with('success', 'Étudiant mis à jour avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur UserController@update: '.$e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour: '.$e->getMessage());
        }
    }

    public function destroy(User $user): RedirectResponse
    {
        try {
            // --Vérifier si l'utilisateur a des évaluations
            if ($user->evaluations()->exists()) {
                return back()->with('error', 'Impossible de supprimer un étudiant avec des évaluations.');
            }

            // --Vérifier si l'utilisateur a un bilan
            if ($user->bilanCompetence) {
                return back()->with('error', 'Impossible de supprimer un étudiant avec un bilan de compétences.');
            }

            // --Supprimer la photo de profil
            if ($user->profile) {
                Storage::disk('public')->delete($user->profile);
            }

            $user->delete();

            return redirect()
                ->route('users.index')
                ->with('success', 'Étudiant supprimé avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression: '.$e->getMessage());
        }
    }

    /**
     * 📸 Traite et optimise l'image de profil
     *
     * Handles processing and storage of uploaded profile images for users.
     * - Redimensionne l'image à 500x500 pixels
     * - Compresse l'image en JPG avec qualité 85%
     * - Organise les fichiers par date (Y/m)
     * - Génère un nom de fichier unique et sécurisé
     *
     * @param  \Illuminate\Http\UploadedFile  $file  Le fichier uploadé
     * @return string Chemin du fichier stocké (ex: profiles/2025/01/profile_nom_1735862400.jpg)
     *
     * @throws \Exception Si le traitement de l'image échoue
     */
    private function handleProfileImage($file): string
    {
        try {
            // 🎯 Générer un nom unique et sécurisé
            $filename = 'profile_'.$file->getClientOriginalName();
            $filename = Str::slug(pathinfo($filename, PATHINFO_FILENAME))
                .'_'.time()
                .'.'.$file->getClientOriginalExtension();

            // 📁 Créer le dossier s'il n'existe pas (organisation par date)
            $path = 'profiles/'.date('Y/m');
            if (! Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path, 0755, true);
            }

            // 🖼️ Optimiser l'image avec Intervention Image v3
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());

            // Redimensionner à 500x500 (portrait) avec crop
            $image->cover(500, 500);

            // Compresser et sauvegarder
            $fullPath = $path.'/'.$filename;
            $image->toJpeg(85)->save(Storage::disk('public')->path($fullPath));

            return $fullPath;

        } catch (\Exception $e) {
            \Log::error('Erreur lors du traitement de l\'image: '.$e->getMessage());

            throw new \Exception('Erreur lors du traitement de l\'image: '.$e->getMessage());
        }
    }

    /**
     * Exporter tous les utilisateurs en Excel
     */
    public function exportAll(Request $request)
    {
        try {
            $specialiteId = $request->input('specialite_id');
            $anneeId = $request->input('annee_id');
            
            $filename = 'utilisateurs';
            
            if ($specialiteId) {
                $specialite = Specialite::find($specialiteId);
                $filename .= '_'.$specialite->code;
            }
            
            if ($anneeId) {
                $annee = AnneeAcademique::find($anneeId);
                $filename .= '_'.$annee->libelle;
            }
            
            $filename .= '_'.date('Y-m-d_H-i').'.xlsx';

            return Excel::download(
                new UsersExport($specialiteId, $anneeId), 
                $filename
            );

        } catch (\Exception $e) {
            Log::error('Erreur UserController@exportAll: '.$e->getMessage());
            return back()->with('error', 'Erreur lors de l\'exportation: '.$e->getMessage());
        }
    }

    /**
     * Exporter les utilisateurs par spécialité en Excel (plusieurs feuilles)
     */
    public function exportBySpecialite(Request $request)
    {
        try {
            $specialites = Specialite::with(['users' => function($query) use ($request) {
                $query->with(['anneeAcademique']);
                
                if ($anneeId = $request->input('annee_id')) {
                    $query->where('annee_academique_id', $anneeId);
                }
                
                return $query->orderBy('name');
            }])->get();

            $exports = [];
            
            foreach ($specialites as $specialite) {
                if ($specialite->users->isNotEmpty()) {
                    $exports[] = new UsersBySpecialiteExport($specialite->users);
                }
            }

            if (empty($exports)) {
                return back()->with('error', 'Aucun utilisateur trouvé pour l\'exportation.');
            }

            $filename = 'utilisateurs_par_specialite_'.date('Y-m-d_H-i').'.xlsx';

            return Excel::download(
                new \App\Exports\MultiSheetUsersExport($exports),
                $filename
            );

        } catch (\Exception $e) {
            Log::error('Erreur UserController@exportBySpecialite: '.$e->getMessage());
            return back()->with('error', 'Erreur lors de l\'exportation: '.$e->getMessage());
        }
    }

    /**
     * Afficher le formulaire d'importation
     */
    public function import(): View
    {
        return view('users.import');
    }

    /**
     * Traiter l'importation des utilisateurs
     */
    public function importStore(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // 10MB max
            ], [
                'file.required' => 'Veuillez sélectionner un fichier',
                'file.mimes' => 'Le fichier doit être au format Excel (.xlsx, .xls) ou CSV',
                'file.max' => 'Le fichier ne doit pas dépasser 10MB',
            ]);

            $file = $request->file('file');
            
            // Créer l'instance d'import
            $import = new UsersImport();
            
            // Importer le fichier
            Excel::import($import, $file);
            
            // Obtenir le rapport d'importation
            $report = $import->getImportReport();
            
            // Préparer le message de résultat
            $message = "Importation terminée : ";
            $message .= "{$report['success_count']} utilisateur(s) créé(s) avec succès";
            
            if ($report['failure_count'] > 0) {
                $message .= ", {$report['failure_count']} erreur(s)";
            }
            
            if ($report['skipped_count'] > 0) {
                $message .= ", {$report['skipped_count']} ligne(s) ignorées";
            }
            
            // Stocker les erreurs en session pour affichage
            if (!empty($report['errors'])) {
                session(['import_errors' => $report['errors']]);
            }
            
            return redirect()
                ->route('users.index')
                ->with('success', $message)
                ->with('import_report', $report);

        } catch (\Exception $e) {
            Log::error('Erreur UserController@importStore: '.$e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de l\'importation: '.$e->getMessage());
        }
    }

    /**
     * Télécharger le modèle d'importation
     */
    public function importTemplate()
    {
        try {
            // Créer un fichier Excel avec les en-têtes de base
            $headers = [
                'name' => 'Nom et Prénom',
                'email' => 'Email',
                'password' => 'Mot de passe (optionnel)',
                'matricule' => 'Matricule (optionnel - sera généré automatiquement)',
                'sexe' => 'Sexe (M/F/Autre)',
                'niveau' => 'Niveau',
                'specialite' => 'Spécialité',
                'annee_academique' => 'Année Académique',
                'date_naissance' => 'Date de naissance (DD/MM/YYYY)',
                'lieu_naissance' => 'Lieu de naissance',
                'nationalite' => 'Nationalité',
                'telephone' => 'Téléphone',
                'telephone_urgence' => 'Téléphone d\'urgence',
                'adresse' => 'Adresse',
                'piece_identite' => 'Pièce d\'identité',
                'statut' => 'Statut (actif/inactif/suspendu/archive)',
            ];

            return Excel::download(new class($headers) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithStyles {
                protected $headers;

                public function __construct(array $headers)
                {
                    $this->headers = $headers;
                }

                public function array(): array
                {
                    return [$this->headers];
                }

                public function headings(): array
                {
                    return array_values($this->headers);
                }

                public function styles($sheet)
                {
                    return [
                        // Style pour la première ligne (en-têtes)
                        1 => [
                            'font' => [
                                'bold' => true,
                                'size' => 12,
                            ],
                            'alignment' => [
                                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            ],
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['argb' => 'FFE1E5E9'],
                            ],
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    'color' => ['argb' => 'FF000000'],
                                ],
                            ],
                        ],
                    ];
                }
            }, 'modele_import_utilisateurs.xlsx');

        } catch (\Exception $e) {
            Log::error('Erreur UserController@importTemplate: '.$e->getMessage());
            
            return back()->with('error', 'Erreur lors du téléchargement du modèle: '.$e->getMessage());
        }
    }
}
