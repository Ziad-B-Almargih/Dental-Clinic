<?php

namespace App\Services\Operation;

use App\Http\Resources\Operations\DiagnosisOperationsResource;
use App\Interfaces\IOperationServices;
use App\Models\Operation;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use function Termwind\renderUsing;

class DiagnosisOperations implements IOperationServices
{

    public function index(Patient $patient, ?int $number): AnonymousResourceCollection
    {
        $operations = $patient->diagnosis()->get();

        return DiagnosisOperationsResource::collection($operations);
    }

    public function create(array $data): Operation
    {
        $data['type'] = 'diagnosis';

        return
        Operation::query()
            ->create($data);
    }
}
