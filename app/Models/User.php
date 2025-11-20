<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Niveau;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'matricule',
        'sexe',
        'profile',
        'niveau',
        'specialite_id',
        'annee_academique_id',
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
            'niveau' => Niveau::class,
        ];
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
        return $query->where(function ($q) use ($search) {
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
}
