<?php

namespace App\Services\Operation;

use App\Http\Resources\Operations\PlansOperationsResource;
use App\Interfaces\IOperationServices;
use App\Models\Operation;
use App\Models\Patient;
use Exception;

class PlansOperations implements IOperationServices
{

    /**
     * @throws Exception
     */
    public function index(Patient $patient, ?int $number)
    {
        if($number == null){
            throw new Exception('Choose a plan!');
        }
        if($number < 0 || $number > 3)
            throw new Exception('the number of plan must be between 1 and 3');
        $operation = $patient->plan($number)->get();
        $totalCost = $operation->sum('treatment.cost');

        return [
            'total_cost' => $totalCost,
            'operations' => PlansOperationsResource::collection($operation)
        ];
    }

    /**
     * @throws Exception
     */
    public function create(array $data)
    {
        if($data['number'] == null){
            throw new Exception('Choose a plan!');
        }
        if($data['number'] < 0 || $data['number'] > 3)
            throw new Exception('the number of plan must be between 1 and 3');
        $data['plan_number'] = $data['number'];
        $data['type'] = 'plans';

        return Operation::query()
            ->create($data);
    }
}
