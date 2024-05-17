<?php

namespace App\Http\Resources\Treatments;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TreatmentResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'   => $this['id'],
            'name' => $this['name'],
            'cost' => $this['cost'],
        ];
    }
}
