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
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class UsersImport implements SkipsOnError, ToCollection, WithBatchInserts, WithHeadingRow, WithUpserts
{
    use Importable;

    public $errors = [];

    public $successCount = 0;

    public $failureCount = 0;

    public $skippedCount = 0;

    /**
     * Importer les données depuis la collection
     */
    public function collection(Collection $rows): void
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
            } catch (ValidationException $e) {
                // Capturer les erreurs de validation spécifiques
                $errorMessage = $e->validator->errors()->first();
                $this->errors[] = [
                    'row' => $index + 2,
                    'data' => $row->toArray(),
                    'error' => $errorMessage,
                ];
                $this->failureCount++;
            } catch (\Exception $e) {
                // Capturer les autres erreurs
                $this->errors[] = [
                    'row' => $index + 2,
                    'data' => $row->toArray(),
                    'error' => $e->getMessage(),
                ];
                $this->failureCount++;
                Log::error('Import Users - Row '.($index + 2).': '.$e->getMessage());
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
            'password' => Hash::make('Cfpc3231'), // Mot de passe par défaut demandé par le client
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
            'piece_identite' => null,
            'statut' => 'actif',
            'role' => $this->getRoleEnum($data['role'] ?? 'etudiant'),
        ];

        return User::create($userData);
    }

    /**
     * Préparer les données de l'utilisateur
     */
    private function prepareUserData($row, int $rowNumber): array
    {
        // Mapping des colonnes du modèle Excel (slug par Maatwebsite) vers nos attributs
        $name = $row['name'] ?? $row['nom'] ?? $row['nom_et_prenom'] ?? '';
        $email = $row['email'] ?? '';
        // Password retiré du template, on utilise la valeur par défaut définie plus haut
        $password = null;
        $matricule = $row['matricule'] ?? $row['matricule_optionnel_sera_genere_automatiquement'] ?? null;
        $sexe = $row['sexe'] ?? $row['sexe_mfautre'] ?? null;
        $niveau = $row['niveau'] ?? null;
        $specialite = $row['specialite'] ?? $row['specialite_intitule'] ?? null;
        $annee = $row['annee_academique'] ?? $row['annee'] ?? null;

        $dateNaissance = $row['date_naissance'] ?? $row['date_de_naissance_ddmmyyyy'] ?? null;
        // Correction pour les dates Excel (numériques)
        if (is_numeric($dateNaissance)) {
            try {
                // Convertir le numéro de série Excel en objet DateTime
                $dateObject = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateNaissance);
                $dateNaissance = $dateObject->format('Y-m-d');
            } catch (\Exception $e) {
                // Si la conversion échoue, on garde la valeur brute pour la validation
            }
        }

        $lieuNaissance = $row['lieu_naissance'] ?? $row['lieu_de_naissance'] ?? null;
        $telephoneUrgence = $row['telephone_urgence'] ?? $row['telephone_durgence'] ?? null;
        $telephoneUrgence = $row['telephone_urgence'] ?? $row['telephone_durgence'] ?? null;
        // Piece identite et Statut retirés du template
        $pieceIdentite = null;
        $statut = 'actif';

        return [
            'name' => $this->cleanString($name),
            'email' => $this->cleanString($email),
            'password' => $password,
            'matricule' => $this->cleanString($matricule),
            'sexe' => $this->cleanString($sexe),
            'niveau' => $this->cleanString($niveau),
            'specialite' => $this->cleanString($specialite),
            'annee_academique' => $this->cleanString($annee),
            'date_naissance' => $dateNaissance,
            'lieu_naissance' => $this->cleanString($lieuNaissance),
            'nationalite' => $this->cleanString($row['nationalite'] ?? null),
            'telephone' => $this->cleanString($row['telephone'] ?? null),
            'telephone_urgence' => $this->cleanString($telephoneUrgence),
            'adresse' => $this->cleanString($row['adresse'] ?? null),
            'piece_identite' => $this->cleanString($pieceIdentite),
            'statut' => $this->cleanString($statut),
            'role' => $this->cleanString($row['role'] ?? 'etudiant'),
        ];
    }

    /**
     * Valider les données utilisateur
     */
    private function validateUserData(array $data, int $rowNumber): void
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
            'name.required' => "Ligne {$rowNumber}: Le nom est obligatoire. (H: Nom et Prénom)",
            'email.required' => "Ligne {$rowNumber}: L'email est obligatoire.",
            'email.email' => "Ligne {$rowNumber}: L'email doit être une adresse valide.",
            'date_naissance.before' => "Ligne {$rowNumber}: La date de naissance doit être dans le passé.",
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
        if (! $specialiteName) {
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
        if (! $anneeName) {
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
        if (! $niveau) {
            return null;
        }

        // Normaliser le nom du niveau
        $niveau = strtolower(trim($niveau));

        // Mapping des niveaux possibles selon les spécifications
        $niveauMapping = [
            '3ème' => '3eme',
            '3eme' => '3eme',
            'troisième' => '3eme',
            'troisieme' => '3eme',
            'bepc' => 'bepc',
            'première' => 'premiere',
            'premiere' => 'premiere',
            'probatoire' => 'probatoire',
            'terminale' => 'terminale',
            'baccalauréat' => 'bacc',
            'baccalaureat' => 'bacc',
            'bac' => 'bacc',
            'licence' => 'licence',
            'licence 1' => 'licence',
            'licence 2' => 'licence',
            'licence 3' => 'licence',
            'l1' => 'licence',
            'l2' => 'licence',
            'l3' => 'licence',
            // Cas par défaut pour masters -> licence si pas de master, ou gérer l'erreur ?
            // L'enum n'a pas M1/M2, donc on ne peut PAS mapper sur M1/M2.
            // Si l'université gère Master, il faut ajouter Master à l'Enum.
            // Pour l'instant, on mappe ce qu'on peut.
            'cep' => 'cep',
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
        if (! $role) {
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
        if (! $date) {
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
    private function cleanString(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return trim(preg_replace('/\s+/', ' ', (string) $value));
    }

    /**
     * Vérifier si une ligne est vide
     */
    private function isEmptyRow($row): bool
    {
        $requiredFields = ['name', 'email'];

        foreach ($requiredFields as $field) {
            if (! empty($row[$field])) {
                return false;
            }
        }

        return true;
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
     * Gérer les erreurs générales
     */
    public function onError(\Throwable $e): void
    {
        Log::error('Import Users Error: '.$e->getMessage());
        $this->errors[] = [
            'row' => 'Général',
            'error' => $e->getMessage(),
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
