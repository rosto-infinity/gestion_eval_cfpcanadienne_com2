<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    // Scopes
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('intitule', 'asc');
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search): void {
            $q->where('code', 'like', "%{$search}%")
                ->orWhere('intitule', 'like', "%{$search}%");
        });
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
