<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOperationRequest;
use App\Http\Resources\Operations\DiagnosisOperationsResource;
use App\Http\Resources\Operations\PlansOperationsResource;
use App\Http\Resources\Operations\TreatmentsOperationsResource;
use App\Interfaces\IOperationServices;
use App\Models\Operation;
use App\Models\Patient;
use App\Services\Operation\DiagnosisOperations;
use App\Services\Operation\PlansOperations;
use App\Services\Operation\TreatmentsOperations;
use Exception;
use Illuminate\Http\JsonResponse;

class OperationController extends Controller
{

    private IOperationServices $operationServices;

    private array $types = [
        'treatments' => TreatmentsOperations::class,
        'diagnosis'  => DiagnosisOperations::class,
        'plans'      => PlansOperations::class,
    ];

    private array $resources = [
        'treatments' => TreatmentsOperationsResource::class,
        'diagnosis'  => DiagnosisOperationsResource::class,
        'plans'      => PlansOperationsResource::class,
    ];

    /**
     * @throws Exception
     */
    private function getOperationClass(string $type){

        if(!isset($this->types[$type]))
            throw new Exception('type must be [treatments, diagnosis, plans]');

        $class = $this->types[$type];

        return new $class;
    }

    public function index(Patient $patient, string $type, int $number = null): JsonResponse
    {
        try {

            $this->operationServices = $this->getOperationClass($type);
            return $this->success($this->operationServices->index($patient, $number));

        }catch (Exception $exception){
            return $this->failed($exception->getMessage());
        }


    }

    public function create(CreateOperationRequest $request, Patient $patient, $type, $number = null): JsonResponse
    {

        try {
            $this->operationServices = $this->getOperationClass($type);
        }catch (Exception $exception){
            return $this->failed($exception->getMessage());
        }

        $data = $request->validated();
        $data['patient_id'] = $patient['id'];
        $data['number'] = $number;

        try {
            $operation = $this->operationServices->create($data);
        }catch (Exception $exception){
            return $this->failed($exception->getMessage());
        }

        return $this->success(
            $this->resources[$type]::make($operation));
    }

    public function delete(Patient $patient, Operation $operation): JsonResponse
    {

        $operation->delete();

        return $this->noResponse();
    }
}
