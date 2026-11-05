<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionArrete extends Model
{
    use HasFactory;

    protected $table = 'institution_arretes';

    protected $fillable = [
        'type',
        'numero',
        'date_arrete',
        'texte',
        'ordre',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'date_arrete' => 'date',
            'is_active' => 'boolean',
            'ordre' => 'integer',
        ];
    }

    /**
     * Scope pour les arrêtés actifs
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope ordonné
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('ordre', 'asc')->orderBy('date_arrete', 'asc');
    }

    /**
     * Scope pour les visas historiques
     */
    public function scopeVisas(Builder $query): Builder
    {
        return $query->where('type', 'visa');
    }

    /**
     * Scope pour l'arrêté principal
     */
    public function scopePrincipal(Builder $query): Builder
    {
        return $query->where('type', 'principal');
    }

    /**
     * Obtenir l'arrêté principal actif actuel
     */
    public static function getPrincipal(): ?self
    {
        return static::principal()->active()->ordered()->first();
    }

    /**
     * Obtenir tous les visas actifs ordonnés
     */
    public static function getActiveVisas()
    {
        return static::visas()->active()->ordered()->get();
    }
}
