<?php

namespace App\Http\Resources;

use App\Http\Resources\Patients\PatientIndexResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NearDateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $date =  Carbon::make($this['date'].' '.$this['from']);
        return [
            'date' => $date->dayName,
            'time' => $date->format('H:i'),
            'time_left' => $date->diffForHumans(now()),
        ];
    }
}
