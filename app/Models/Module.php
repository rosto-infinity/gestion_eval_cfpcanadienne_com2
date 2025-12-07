<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    use HasFactory;

    protected $table = 'modules';

    protected $fillable = [
        'specialite_id',
        'code',
        'intitule',
        'coefficient',
        'ordre',
    ];

    protected $casts = [
        'coefficient' => 'decimal:2',
        'ordre' => 'integer',
        'specialite_id' => 'integer',
    ];

    // Relations
    public function specialite(): BelongsTo
    {
        return $this->belongsTo(Specialite::class, 'specialite_id');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'module_id');
    }

    // Scopes
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('ordre', 'asc');
    }

    public function scopeBySpecialite(Builder $query, int $specialiteId): Builder
    {
        return $query->where('specialite_id', $specialiteId);
    }

    public function scopeSemestre1(Builder $query): Builder
    {
        return $query->whereIn('code', ['M1', 'M2', 'M3', 'M4', 'M5']);
    }

    public function scopeSemestre2(Builder $query): Builder
    {
        return $query->whereIn('code', ['M6', 'M7', 'M8', 'M9', 'M10']);
    }

    // Methods
    public function isSemestre1(): bool
    {
        return in_array($this->code, ['M1', 'M2', 'M3', 'M4', 'M5']);
    }

    public function isSemestre2(): bool
    {
        return in_array($this->code, ['M6', 'M7', 'M8', 'M9', 'M10']);
    }

    public function getSemestre(): int
    {
        return $this->isSemestre1() ? 1 : 2;
    }
}