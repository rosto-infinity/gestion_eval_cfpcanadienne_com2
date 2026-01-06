<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Niveau;
use App\Enums\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
        'matricule',
        'sexe',
        'profile',
        'niveau',
        'specialite_id',
        'annee_academique_id',
        'date_naissance',
        'lieu_naissance',
        'nationalite',
        
        // Contact
        'telephone',
        'telephone_urgence',
        'adresse',
        
        // Documents
        'piece_identite',
        
        // Statut
        'statut',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class,
            'niveau' => Niveau::class,
        ];
    }

       public function getLogoUrlAttribute()
    {
        if ($this->profile) {
            return Storage::url($this->profile);
        }
        return null;
    }
    // --- Helpers de rôle (Syntaxe corrigée) ---

    public function isSuperAdmin(): bool
    {
        return $this->role === Role::SUPERADMIN;
    }

    public function isAdmin(): bool
    {
        return $this->role?->isAtLeast(Role::ADMIN) ?? false;
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    // Surcharge de l'autorisation native Laravel
    public function can($ability, $arguments = []): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->role?->hasPermission($ability) || parent::can($ability, $arguments);
    }

    /**
     * Perform actions after the model is booted.
     */
    protected static function booted(): void
    {
        // Assigner le rôle USER par défaut lors de la création
        static::created(function (self $user) {
            if (empty($user->role)) {
                $user->role = Role::USER->value;
                $user->saveQuietly();
            }
        });

        static::updating(function (User $user): void {
            if ($user->isDirty('role')) {

                // $operator = auth()->user();
                $operator = Auth::user();

                if (! $operator || ! $operator->isSuperAdmin()) {
                    Log::warning("Tentative de modification de rôle non autorisée par l'utilisateur ID: ".($operator?->id ?? 'invité'));

                    throw new \Exception('Seul un SuperAdmin peut modifier les rôles.');
                }

                // Protection du dernier SuperAdmin
                if ($user->getOriginal('role') === Role::SUPERADMIN) {
                    $superAdminCount = self::where('role', Role::SUPERADMIN)->count();
                    if ($superAdminCount <= 1) {
                        throw new \Exception('Impossible de modifier le rôle du dernier SuperAdmin.');
                    }
                }
            }
        });
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * ✅ CORRIGÉ : Retourner le nom complet correctement
     */
    public function getFullName(): string
    {
        return $this->name ?? 'N/A';
    }

    /**
     * Get sexe label
     */
    public function getSexeLabel(): string
    {
        return match ($this->sexe) {
            'M' => 'Masculin',
            'F' => 'Féminin',
            default => 'Autre',
        };
    }

    /**
     * Get sexe emoji
     */
    public function getSexeEmoji(): string
    {
        return match ($this->sexe) {
            'M' => '👨',
            'F' => '👩',
            default => '🧑',
        };
    }

    // Relations
    // ✅ RELATIONS - CORRIGÉES AVEC LES NOMS DE TABLES CORRECTS
    /**
     * Relation avec Specialite
     * ⚠️ IMPORTANT : Spécifier le nom de la table correctement
     */
    public function specialite(): BelongsTo
    {
        return $this->belongsTo(Specialite::class, 'specialite_id', 'id');
    }

    /**
     * Relation avec AnneeAcademique
     * ⚠️ IMPORTANT : Spécifier le nom de la table correctement
     */
    public function anneeAcademique(): BelongsTo
    {
        return $this->belongsTo(AnneeAcademique::class, 'annee_academique_id', 'id');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'user_id');
    }

    public function bilanCompetence(): HasOne
    {
        return $this->hasOne(BilanCompetence::class, 'user_id')
            ->where('annee_academique_id', $this->annee_academique_id);
    }

    // Scopes
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('name', 'asc');
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search): void {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('matricule', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }

    public function scopeBySpecialite(Builder $query, int $specialiteId): Builder
    {
        return $query->where('specialite_id', $specialiteId);
    }

    public function scopeByAnneeAcademique(Builder $query, int $anneeId): Builder
    {
        return $query->where('annee_academique_id', $anneeId);
    }

    // Methods
    public function getEvaluationsBySemestre(int $semestre): \Illuminate\Database\Eloquent\Collection
    {
        return $this->evaluations()
            ->where('semestre', $semestre)
            ->where('annee_academique_id', $this->annee_academique_id)
            ->with('module')
            ->get()
            ->sortBy('module.ordre');
    }

    public function getMoyenneSemestre(int $semestre): ?float
    {
        $evaluations = $this->evaluations()
            ->where('semestre', $semestre)
            ->where('annee_academique_id', $this->annee_academique_id)
            ->get();

        if ($evaluations->isEmpty()) {
            return null;
        }

        return round($evaluations->avg('note'), 2);
    }

    /**
     * Générer un matricule automatiquement à partir du nom et de l'année active
     */
    public static function generateMatricule(?string $userName = null): string
    {
        $year = date('Y');
        
        // 🔍 Debug : Vérifier l'année académique
        \Log::info('Génération matricule pour: ' . $userName . ' - Année: ' . $year);
        
        // Obtenir les deux derniers chiffres de l'année active (ex: 2025-2026 → 26)
        $lastTwoDigits = substr($year, -2);
        
        // Générer 3 lettres aléatoires du nom
        $nameLetters = 'XXX'; // Valeur par défaut
        if ($userName) {
            // Nettoyer le nom et convertir en majuscules
            $cleanName = preg_replace('/[^a-zA-Z]/', '', strtoupper($userName));
            
            if (strlen($cleanName) >= 3) {
                // Prendre 3 lettres aléatoires du nom
                $nameLetters = substr(str_shuffle($cleanName), 0, 3);
            } elseif (strlen($cleanName) > 0) {
                // Compléter avec des lettres aléatoires si le nom est trop court
                $remaining = 3 - strlen($cleanName);
                $randomLetters = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $remaining);
                $nameLetters = $cleanName . $randomLetters;
            }
        }
        
        // Compter le nombre d'utilisateurs pour cette année (sans dépendre de la base)
        $count = self::whereNotNull('matricule')
            ->where('matricule', 'like', "CFPC-{$lastTwoDigits}%")
            ->count();
        
        // 🔍 Debug : Vérifier le comptage
        \Log::info('Matricules existants pour ' . $year . ': ' . $count);
        
        $sequence = str_pad((string) ($count + 1), 3, '0', STR_PAD_LEFT);
        
        $matricule = "CFPC-{$lastTwoDigits}{$nameLetters}{$sequence}";
        
        // 🔍 Debug : Matricule généré
        \Log::info('Matricule généré: ' . $matricule);
        
        return $matricule;
    }

    /**
     * Obtenir l'URL de la photo de profil
     */
    public function getProfileUrlAttribute(): ?string
    {
        if (!$this->profile) {
            return null;
        }
        
        return Storage::url($this->profile);
    }

    /**
     * Obtenir la photo de profil par défaut si aucune n'est définie
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        return $this->profile_url ?? "https://ui-avatars.com/api/?name=" . urlencode($this->name) . "&color=7F9CF5&background=EBF4FF";
    }


}
