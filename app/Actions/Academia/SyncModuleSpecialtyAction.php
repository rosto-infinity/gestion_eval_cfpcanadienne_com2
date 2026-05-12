<?php

declare(strict_types=1);

namespace App\Actions\Academia;

use App\Models\Module;
use App\Models\Specialite;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SyncModuleSpecialtyAction
{
    /**
     * Valider que la somme des coefficients d'une spécialité ne dépasse pas la limite.
     */
    public function validateWeights(Specialite $specialite, float $newCoefficient, ?int $excludeModuleId = null): array
    {
        $maxCoefficient = 150.0;

        $query = Module::where('specialite_id', $specialite->id);

        if ($excludeModuleId) {
            $query->where('id', '!=', $excludeModuleId);
        }

        $total = $query->sum('coefficient');

        if (($total + $newCoefficient) > $maxCoefficient) {
            return [
                'valid' => false,
                'message' => "La somme des coefficients ($total + $newCoefficient = ".($total + $newCoefficient).") dépasse le maximum autorisé ($maxCoefficient).",
                'total_actuel' => $total,
                'max_autorise' => $maxCoefficient,
            ];
        }

        return [
            'valid' => true,
            'total_actuel' => $total,
            'max_autorise' => $maxCoefficient,
        ];
    }

    /**
     * Rattacher un module à une spécialité avec validation de pondération.
     */
    public function attach(Module $module, Specialite $specialite, float $coefficient): Module
    {
        $weightValidation = $this->validateWeights($specialite, $coefficient, $module->id);

        if (! $weightValidation['valid']) {
            throw new \InvalidArgumentException($weightValidation['message']);
        }

        DB::transaction(function () use ($module, $specialite, $coefficient): void {
            $module->update([
                'specialite_id' => $specialite->id,
                'coefficient' => $coefficient,
            ]);

            Context::add('module_specialty_sync', [
                'module_id' => $module->id,
                'module_code' => $module->code,
                'specialite_id' => $specialite->id,
                'specialite_intitule' => $specialite->intitule,
                'coefficient' => $coefficient,
                'action' => 'attach_module',
            ]);

            Log::info('Module rattaché à la spécialité', [
                'module_id' => $module->id,
                'specialite_id' => $specialite->id,
                'coefficient' => $coefficient,
            ]);
        });

        return $module->fresh();
    }

    /**
     * Basculer un module vers une autre spécialité (update).
     */
    public function move(Module $module, Specialite $newSpecialite, float $coefficient): Module
    {
        return $this->attach($module, $newSpecialite, $coefficient);
    }
}
