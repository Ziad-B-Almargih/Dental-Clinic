<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientPaymentResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'total_cost' => $this['total_cost'],
            'total_payments' => $this['total_payments'],
            'remaining' => $this['remaining'],
            'payments' => PaymentResource::collection($this['payments']),
        ];
    }
}
