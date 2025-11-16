<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class BilanCompetence extends Model
{
    use HasFactory;

    protected $table = 'bilans_competences';

    protected $fillable = [
        'user_id',
        'annee_academique_id',
        'moy_eval_semestre1',
        'moy_eval_semestre2',
        'moy_evaluations',
        'moy_competences',
        'moyenne_generale',
        'observations',
    ];

    protected $casts = [
        'moy_eval_semestre1' => 'decimal:2',
        'moy_eval_semestre2' => 'decimal:2',
        'moy_evaluations' => 'decimal:2',
        'moy_competences' => 'decimal:2',
        'moyenne_generale' => 'decimal:2',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function anneeAcademique(): BelongsTo
    {
        return $this->belongsTo(AnneeAcademique::class, 'annee_academique_id');
    }

    // Scopes
    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByAnneeAcademique(Builder $query, int $anneeId): Builder
    {
        return $query->where('annee_academique_id', $anneeId);
    }

    // Methods
    public function calculateAndSave(?float $moyCompetences = null): bool
    {
        // Calcul des moyennes semestrielles
        $this->moy_eval_semestre1 = Evaluation::calculateMoyenneSemestre(
            $this->user_id,
            1,
            $this->annee_academique_id
        );

        $this->moy_eval_semestre2 = Evaluation::calculateMoyenneSemestre(
            $this->user_id,
            2,
            $this->annee_academique_id
        );

        // Calcul de la moyenne des évaluations (30%)
        if ($this->moy_eval_semestre1 !== null && $this->moy_eval_semestre2 !== null) {
            $moyenneEvals = ($this->moy_eval_semestre1 + $this->moy_eval_semestre2) / 2;
            $this->moy_evaluations = round($moyenneEvals, 2);
        }

        // Si la moyenne des compétences est fournie
        if ($moyCompetences !== null) {
            $this->moy_competences = round($moyCompetences, 2);
        }

        // Calcul de la moyenne générale (30% évals + 70% compétences)
        if ($this->moy_evaluations !== null && $this->moy_competences !== null) {
            $this->moyenne_generale = round(
                ($this->moy_evaluations * 0.30) + ($this->moy_competences * 0.70),
                2
            );
        }

        return $this->save();
    }

    public function getAppreciation(): string
    {
        if ($this->moyenne_generale === null) {
            return 'Non évalué';
        }

        return match (true) {
            $this->moyenne_generale >= 18 => 'Excellent',
            $this->moyenne_generale >= 16 => 'Très bien',
            $this->moyenne_generale >= 14 => 'Bien',
            $this->moyenne_generale >= 12 => 'Assez bien',
            $this->moyenne_generale >= 10 => 'Passable',
            default => 'Insuffisant',
        };
    }

    public function getMention(): string
    {
        if ($this->moyenne_generale === null) {
            return '';
        }

        return match (true) {
            $this->moyenne_generale >= 16 => 'Très Bien',
            $this->moyenne_generale >= 14 => 'Bien',
            $this->moyenne_generale >= 12 => 'Assez Bien',
            $this->moyenne_generale >= 10 => 'Passable',
            default => 'Ajourné',
        };
    }

    public function isAdmis(): bool
    {
        return $this->moyenne_generale !== null && $this->moyenne_generale >= 10;
    }
}