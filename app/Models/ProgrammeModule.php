<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgrammeModule extends Model
{
    use HasFactory;

    protected $table = 'programme_modules';

    protected $fillable = [
        'specialite_id',
        'numero_module',
        'titre',
        'heures_hebdomadaires',
        'heures_total',
        'categorie',
        'ordre',
    ];

    protected $casts = [
        'specialite_id' => 'integer',
        'numero_module' => 'integer',
        'heures_hebdomadaires' => 'integer',
        'heures_total' => 'integer',
        'ordre' => 'integer',
    ];

    public function specialite(): BelongsTo
    {
        return $this->belongsTo(Specialite::class, 'specialite_id');
    }
}
