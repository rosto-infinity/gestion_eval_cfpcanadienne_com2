<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Attestation extends Model
{
    use HasFactory;

    protected $table = 'attestations';

    protected $fillable = [
        'user_id',
        'annee_academique_id',
        'specialite_id',
        'specialite_personnalisee',
        'specialite_libelle',
        'date_debut',
        'date_fin',
        'lieu_delivrance',
        'date_delivrance',
        'numero_attestation',
        'token',
        'arrete_principal',
        'visas_arretes',
        'competences_supplementaires',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'date_debut' => 'date',
            'date_fin' => 'date',
            'date_delivrance' => 'date',
            'visas_arretes' => 'array',
            'competences_supplementaires' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function anneeAcademique(): BelongsTo
    {
        return $this->belongsTo(AnneeAcademique::class);
    }

    public function specialite(): BelongsTo
    {
        return $this->belongsTo(Specialite::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Génère un numéro d'attestation unique incrémental
     * Ex: ATT-2026-GP-0001
     */
    public static function generateNumero(Specialite|string|null $specialite, ?AnneeAcademique $annee = null): string
    {
        $year = $annee ? Str::substr($annee->libelle, 0, 4) : now()->format('Y');
        $code = 'GEN';
        if ($specialite instanceof Specialite) {
            $code = strtoupper(Str::slug($specialite->code ?? Str::substr($specialite->intitule, 0, 3), ''));
        } elseif (is_string($specialite) && ! empty($specialite)) {
            $code = strtoupper(Str::substr(Str::slug($specialite, ''), 0, 3));
        }

        $count = static::whereYear('created_at', now()->year)->count() + 1;

        return sprintf('ATT-%s-%s-%04d', $year, $code, $count);
    }

    /**
     * Génère un token cryptographique aléatoire sécurisé
     */
    public static function generateToken(): string
    {
        return Str::random(40);
    }

    /**
     * Helper pour le label de naissance accordé en genre
     * Ex: "Née le" si féminin, "Né le" si masculin
     */
    public function getPrefixeNaissanceAttribute(): string
    {
        $sexe = strtoupper((string) ($this->user?->sexe ?? ''));

        return $sexe === 'F' ? 'Née le' : 'Né le';
    }

    /**
     * Date et lieu de naissance formatés
     * Ex: "Née le 02/08/2005 à BAFOUSSAM"
     */
    public function getTexteNaissanceAttribute(): string
    {
        $dateNaissance = $this->user?->date_naissance
            ? Carbon::parse($this->user->date_naissance)->format('d/m/Y')
            : '..........';
        $lieuNaissance = strtoupper((string) ($this->user?->lieu_naissance ?? '..........'));

        return sprintf('%s %s à %s', $this->prefixe_naissance, $dateNaissance, $lieuNaissance);
    }

    /**
     * Tranche de dates formatée
     * Ex: "du 13/10/2025 au 21/09/2026"
     */
    public function getTrancheDatesAttribute(): string
    {
        return sprintf(
            'du %s au %s',
            $this->date_debut ? $this->date_debut->format('d/m/Y') : '...',
            $this->date_fin ? $this->date_fin->format('d/m/Y') : '...'
        );
    }

    /**
     * Scope de recherche
     */
    public function scopeForSpecialite(Builder $query, int $specialiteId): Builder
    {
        return $query->where('specialite_id', $specialiteId);
    }

    public function scopeForAnnee(Builder $query, int $anneeId): Builder
    {
        return $query->where('annee_academique_id', $anneeId);
    }
}
