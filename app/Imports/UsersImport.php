<?php

declare(strict_types=1);

namespace App\Imports;

use App\Enums\Niveau;
use App\Enums\Role;
use App\Models\AnneeAcademique;
use App\Models\Specialite;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Validators\Failure;

class UsersImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure, WithBatchInserts, WithUpserts
{
    use Importable;

    public $errors = [];
    public $successCount = 0;
    public $failureCount = 0;
    public $skippedCount = 0;

    /**
     * Importer les données depuis la collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            try {
                // Ignorer les lignes vides
                if ($this->isEmptyRow($row)) {
                    $this->skippedCount++;
                    continue;
                }

                // Valider et créer l'utilisateur
                $this->createUserFromRow($row, $index + 2); // +2 car ligne 1 = en-tête
                $this->successCount++;

            } catch (\Exception $e) {
                $this->errors[] = [
                    'row' => $index + 2,
                    'data' => $row->toArray(),
                    'error' => $e->getMessage()
                ];
                $this->failureCount++;
                Log::error("Import Users - Row " . ($index + 2) . ": " . $e->getMessage());
            }
        }
    }

    /**
     * Créer un utilisateur à partir d'une ligne Excel
     */
    private function createUserFromRow($row, int $rowNumber)
    {
        // Nettoyer et préparer les données
        $data = $this->prepareUserData($row, $rowNumber);

        // Validation des données
        $this->validateUserData($data, $rowNumber);

        // Gérer les relations
        $specialite = $this->getSpecialite($data['specialite'] ?? null);
        $anneeAcademique = $this->getAnneeAcademique($data['annee_academique'] ?? null);

        // Générer le matricule automatiquement si non fourni
        $matricule = $data['matricule'] ?? User::generateMatricule($data['name']);

        // Vérifier l'unicité du matricule
        if ($matricule && User::where('matricule', $matricule)->exists()) {
            throw new \Exception("Le matricule '{$matricule}' existe déjà");
        }

        // Vérifier l'unicité de l'email
        if ($data['email'] && User::where('email', $data['email'])->exists()) {
            throw new \Exception("L'email '{$data['email']}' existe déjà");
        }

        // Créer l'utilisateur
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'] ?? 'password123'), // Mot de passe par défaut
            'matricule' => $matricule,
            'sexe' => $data['sexe'] ?? null,
            'niveau' => $this->getNiveauEnum($data['niveau'] ?? null),
            'specialite_id' => $specialite?->id,
            'annee_academique_id' => $anneeAcademique?->id,
            'date_naissance' => $this->parseDate($data['date_naissance'] ?? null),
            'lieu_naissance' => $data['lieu_naissance'] ?? null,
            'nationalite' => $data['nationalite'] ?? null,
            'telephone' => $data['telephone'] ?? null,
            'telephone_urgence' => $data['telephone_urgence'] ?? null,
            'adresse' => $data['adresse'] ?? null,
            'piece_identite' => $data['piece_identite'] ?? null,
            'statut' => $data['statut'] ?? 'actif',
            'role' => $this->getRoleEnum($data['role'] ?? 'etudiant'),
        ];

        return User::create($userData);
    }

    /**
     * Préparer les données de l'utilisateur
     */
    private function prepareUserData($row, int $rowNumber): array
    {
        return [
            'name' => $this->cleanString($row['name'] ?? $row['nom'] ?? ''),
            'email' => $this->cleanString($row['email'] ?? ''),
            'password' => $row['password'] ?? null,
            'matricule' => $this->cleanString($row['matricule'] ?? null),
            'sexe' => $this->cleanString($row['sexe'] ?? null),
            'niveau' => $this->cleanString($row['niveau'] ?? null),
            'specialite' => $this->cleanString($row['specialite'] ?? $row['specialite_intitule'] ?? null),
            'annee_academique' => $this->cleanString($row['annee_academique'] ?? $row['annee'] ?? null),
            'date_naissance' => $row['date_naissance'] ?? null,
            'lieu_naissance' => $this->cleanString($row['lieu_naissance'] ?? null),
            'nationalite' => $this->cleanString($row['nationalite'] ?? null),
            'telephone' => $this->cleanString($row['telephone'] ?? null),
            'telephone_urgence' => $this->cleanString($row['telephone_urgence'] ?? null),
            'adresse' => $this->cleanString($row['adresse'] ?? null),
            'piece_identite' => $this->cleanString($row['piece_identite'] ?? null),
            'statut' => $this->cleanString($row['statut'] ?? 'actif'),
            'role' => $this->cleanString($row['role'] ?? 'etudiant'),
        ];
    }

    /**
     * Valider les données utilisateur
     */
    private function validateUserData(array $data, int $rowNumber)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'sexe' => 'nullable|in:M,F,Autre',
            'niveau' => 'nullable|string',
            'date_naissance' => 'nullable|date|before:today',
            'telephone' => 'nullable|string|max:20',
            'telephone_urgence' => 'nullable|string|max:20',
            'statut' => 'nullable|in:actif,inactif,suspendu,archive',
            'role' => 'nullable|string',
        ], [
            'name.required' => "Ligne {$rowNumber}: Le nom est obligatoire",
            'email.required' => "Ligne {$rowNumber}: L'email est obligatoire",
            'email.email' => "Ligne {$rowNumber}: L'email doit être valide",
            'date_naissance.before' => "Ligne {$rowNumber}: La date de naissance doit être dans le passé",
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Obtenir la spécialité par nom ou code
     */
    private function getSpecialite(?string $specialiteName): ?Specialite
    {
        if (!$specialiteName) {
            return null;
        }

        return Specialite::where('intitule', 'like', "%{$specialiteName}%")
            ->orWhere('code', 'like', "%{$specialiteName}%")
            ->first();
    }

    /**
     * Obtenir l'année académique par libellé
     */
    private function getAnneeAcademique(?string $anneeName): ?AnneeAcademique
    {
        if (!$anneeName) {
            return null;
        }

        return AnneeAcademique::where('libelle', 'like', "%{$anneeName}%")
            ->first();
    }

    /**
     * Convertir le niveau en enum
     */
    private function getNiveauEnum(?string $niveau): ?Niveau
    {
        if (!$niveau) {
            return null;
        }

        // Normaliser le nom du niveau
        $niveau = strtolower(trim($niveau));
        
        // Mapping des niveaux possibles selon les spécifications
        $niveauMapping = [
            '3ème' => 'L1',
            '3eme' => 'L1',
            'troisième' => 'L1',
            'troisieme' => 'L1',
            'bepc' => 'L1',
            'première' => 'L2',
            'premiere' => 'L2',
            'probatoire' => 'L2',
            'terminale' => 'L3',
            'baccalauréat' => 'L3',
            'baccalaureat' => 'L3',
            'bac' => 'L3',
            'licence' => 'M1',
            'ce' => 'M2',
            
            // Anciens mappings pour compatibilité
            'l1' => 'L1',
            'l2' => 'L2',
            'l3' => 'L3',
            'm1' => 'M1',
            'm2' => 'M2',
            'licence 1' => 'L1',
            'licence 2' => 'L2',
            'licence 3' => 'L3',
            'master 1' => 'M1',
            'master 2' => 'M2',
            '1ere année' => 'L1',
            '2eme année' => 'L2',
            '3eme année' => 'L3',
            '4eme année' => 'M1',
            '5eme année' => 'M2',
        ];

        $normalizedNiveau = $niveauMapping[$niveau] ?? strtoupper($niveau);

        try {
            // Utiliser from() au lieu de value()
            return Niveau::from($normalizedNiveau);
        } catch (\ValueError $e) {
            // Si le niveau n'est pas un enum valide, on peut le stocker comme texte
            // ou retourner null selon les besoins
            return null;
        }
    }

    /**
     * Convertir le rôle en enum
     */
    private function getRoleEnum(?string $role): Role
    {
        if (!$role) {
            return Role::USER; // Par défaut USER au lieu de ETUDIANT
        }

        $role = strtolower(trim($role));
        
        $roleMapping = [
            'user' => 'USER',
            'utilisateur' => 'USER',
            'etudiant' => 'USER', // ETUDIANT n'existe pas, on utilise USER
            'admin' => 'ADMIN',
            'administrateur' => 'ADMIN',
            'manager' => 'MANAGER',
            'gestionnaire' => 'MANAGER',
            'superadmin' => 'SUPERADMIN',
            'super admin' => 'SUPERADMIN',
            'super-admin' => 'SUPERADMIN',
            'super administrateur' => 'SUPERADMIN',
        ];

        $normalizedRole = $roleMapping[$role] ?? strtoupper($role);

        try {
            // Utiliser fromString() au lieu de from()
            return Role::fromString($normalizedRole) ?? Role::USER;
        } catch (\ValueError $e) {
            return Role::USER;
        }
    }

    /**
     * Parser une date
     */
    private function parseDate(?string $date): ?\DateTime
    {
        if (!$date) {
            return null;
        }

        try {
            return new \DateTime($date);
        } catch (\Exception $e) {
            // Essayer différents formats
            $formats = ['d/m/Y', 'Y-m-d', 'd-m-Y', 'm/d/Y'];
            
            foreach ($formats as $format) {
                $dateObj = \DateTime::createFromFormat($format, $date);
                if ($dateObj) {
                    return $dateObj;
                }
            }
            
            throw new \Exception("Format de date invalide: {$date}");
        }
    }

    /**
     * Nettoyer une chaîne de caractères
     */
    private function cleanString(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return trim(preg_replace('/\s+/', ' ', $value));
    }

    /**
     * Vérifier si une ligne est vide
     */
    private function isEmptyRow($row): bool
    {
        $requiredFields = ['name', 'email'];
        
        foreach ($requiredFields as $field) {
            if (!empty($row[$field])) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Validation des en-têtes
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
        ];
    }

    /**
     * Taille du batch pour l'insertion
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Champs uniques pour l'upsert
     */
    public function uniqueBy()
    {
        return ['email'];
    }

    /**
     * Gérer les erreurs de validation
     */
    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->errors[] = [
                'row' => $failure->row(),
                'attribute' => $failure->attribute(),
                'errors' => $failure->errors(),
                'values' => $failure->values()
            ];
            $this->failureCount++;
        }
    }

    /**
     * Gérer les erreurs générales
     */
    public function onError(\Throwable $e)
    {
        Log::error("Import Users Error: " . $e->getMessage());
        $this->errors[] = [
            'row' => 'Général',
            'error' => $e->getMessage()
        ];
        $this->failureCount++;
    }

    /**
     * Obtenir le rapport d'importation
     */
    public function getImportReport(): array
    {
        return [
            'success_count' => $this->successCount,
            'failure_count' => $this->failureCount,
            'skipped_count' => $this->skippedCount,
            'total_processed' => $this->successCount + $this->failureCount + $this->skippedCount,
            'errors' => $this->errors,
        ];
    }
}
