<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluation extends Model
{
    use HasFactory;

    protected $table = 'evaluations';

    protected $fillable = [
        'user_id',
        'module_id',
        'annee_academique_id',
        'semestre',
        'note',
    ];

    protected $casts = [
        'note' => 'decimal:2',
        'semestre' => 'integer',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function anneeAcademique(): BelongsTo
    {
        return $this->belongsTo(AnneeAcademique::class, 'annee_academique_id');
    }

    // Scopes
    public function scopeBySemestre(Builder $query, int $semestre): Builder
    {
        return $query->where('semestre', $semestre);
    }

    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByAnneeAcademique(Builder $query, int $anneeId): Builder
    {
        return $query->where('annee_academique_id', $anneeId);
    }

    public function scopeByModule(Builder $query, int $moduleId): Builder
    {
        return $query->where('module_id', $moduleId);
    }

    // Methods
    public function isValidNote(): bool
    {
        return $this->note >= 0 && $this->note <= 20;
    }

    public function getAppreciation(): string
    {
        return match (true) {
            $this->note >= 18 => 'Excellent',
            $this->note >= 16 => 'Très bien',
            $this->note >= 14 => 'Bien',
            $this->note >= 12 => 'Assez bien',
            $this->note >= 10 => 'Passable',
            default => 'Insuffisant',
        };
    }

    public static function calculateMoyenneSemestre(int $userId, int $semestre, int $anneeId): ?float
    {
        $moyenne = self::where('user_id', $userId)
            ->where('semestre', $semestre)
            ->where('annee_academique_id', $anneeId)
            ->avg('note');

        return $moyenne ? round((float) $moyenne, 2) : null;
    }
}
