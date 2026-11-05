<?php

declare(strict_types=1);

namespace App\Models;

use App\Http\Resources\SpecialiteResource;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[UseResource(SpecialiteResource::class)]
class Specialite extends Model
{
    use HasFactory;

    protected $table = 'specialites';

    protected $fillable = [
        'code',
        'intitule',
        'description',
    ];

    // Relations
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'specialite_id');
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class, 'specialite_id');
    }

    public function attestations(): HasMany
    {
        return $this->hasMany(Attestation::class, 'specialite_id');
    }

    public function programmeModules(): HasMany
    {
        return $this->hasMany(ProgrammeModule::class, 'specialite_id')->orderBy('ordre', 'asc');
    }

    public function competences(): HasMany
    {
        return $this->hasMany(SpecialiteCompetence::class, 'specialite_id')->orderBy('ordre', 'asc');
    }

    public function getTotalHeuresProgrammeAttribute(): int
    {
        return (int) $this->programmeModules()->sum('heures_total');
    }

    // Scopes
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('intitule', 'asc');
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->whereAny(['code', 'intitule'], 'like', "%{$search}%");
    }

    // Methods
    public function getUsersCount(): int
    {
        return $this->users()->count();
    }

    public function getActiveUsersCount(): int
    {
        return $this->users()
            ->whereHas('anneeAcademique', fn ($q) => $q->where('is_active', true))
            ->count();
    }
}
