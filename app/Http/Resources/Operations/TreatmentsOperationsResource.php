<?php

namespace App\Http\Resources\Operations;

use App\Http\Resources\Treatments\TreatmentResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TreatmentsOperationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'tooth_number' => $this['tooth']['number'],
            'tooth_name' => $this['tooth']['name'],
            'treatment_name' => $this['treatment']['name'],
            'treatment_cost' => $this['treatment']['cost'],
            'date' => Carbon::create($this['created_at'])->diffForHumans(),
        ];
    }
}
