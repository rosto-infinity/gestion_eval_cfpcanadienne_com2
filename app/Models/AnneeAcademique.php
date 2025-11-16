<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AnneeAcademique extends Model
{
    use HasFactory;

    protected $table = 'annees_academiques';

    protected $fillable = [
        'libelle',
        'date_debut',
        'date_fin',
        'is_active',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'is_active' => 'boolean',
    ];

    // Relations
    // public function users(): HasMany
    // {
    //     return $this->hasMany(User::class, 'annee_academique_id');
    // }

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('date_debut', 'desc');
    }

    // Methods
    public function activate()
    {
        // Désactiver toutes les autres années
        self::where('id', '!=', $this->id)->update(['is_active' => false]);

        return $this->update(['is_active' => true]);
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }
}
