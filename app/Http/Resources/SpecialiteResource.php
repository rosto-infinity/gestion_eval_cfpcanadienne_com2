<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Specialite;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Attributes\PreserveKeys;
use Illuminate\Http\Resources\Json\JsonResource;

#[PreserveKeys]
/** @mixin Specialite */
class SpecialiteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'intitule' => $this->intitule,
            'description' => $this->whenNotNull($this->description),

            'users_count' => $this->whenCounted('users'),
            'modules_count' => $this->whenCounted('modules'),

            'modules' => ModuleResource::collection($this->whenLoaded('modules')),

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
