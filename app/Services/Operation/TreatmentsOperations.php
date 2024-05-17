<?php

namespace App\Services\Operation;

use App\Http\Resources\Operations\TreatmentsOperationsResource;
use App\Interfaces\IOperationServices;
use App\Models\Operation;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TreatmentsOperations implements IOperationServices
{

    public function index(Patient $patient, ?int $number)
    {
        $operations = $patient->treatments()->get();

        $totalCost = $operations->sum('treatment.cost');

        return [
            'total_cast' => $totalCost,
            'operations' => TreatmentsOperationsResource::collection($operations)
        ];
    }

    public function create(array $data)
    {
        $data['type'] = 'treatments';
        return
            Operation::query()
                ->create($data);
    }
}
