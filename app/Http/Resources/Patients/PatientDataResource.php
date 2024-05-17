<?php

namespace App\Http\Resources\Patients;

use App\Http\Resources\DiseaseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this['id'],
            'name'         => $this['name'],
            'age'          => $this['age'],
            'gender'       => $this['gender'],
            'note'        => $this['note'],
            'prescription' => $this['prescription'],
            'diseases'     => DiseaseResource::collection($this['diseases']),
        ];
    }
}
