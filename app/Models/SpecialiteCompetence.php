<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecialiteCompetence extends Model
{
    use HasFactory;

    protected $table = 'specialite_competences';

    protected $fillable = [
        'specialite_id',
        'intitule',
        'description',
        'ordre',
    ];

    protected $casts = [
        'specialite_id' => 'integer',
        'ordre' => 'integer',
    ];

    public function specialite(): BelongsTo
    {
        return $this->belongsTo(Specialite::class, 'specialite_id');
    }
}
