<?php

namespace App\Http\Controllers;

use App\Http\Requests\Treatments\TreatmentClassificationRequest;
use App\Http\Resources\IndexTreatmentClassificationResource;
use App\Http\Resources\Treatments\TreatmentClassificationResource;
use App\Models\TreatmentClassification;
use Illuminate\Http\JsonResponse;

class TreatmentClassificationController extends Controller
{
    public function index(): JsonResponse
    {
        $treatments = TreatmentClassification::all();

        return $this->success(IndexTreatmentClassificationResource::collection($treatments));
    }

    public function create(TreatmentClassificationRequest $request): JsonResponse
    {
        $treatmentClassification = TreatmentClassification::query()
            ->create($request->validated());

        return $this->success(
            TreatmentClassificationResource::make($treatmentClassification),
            'created',
            201
        );
    }

    public function show(TreatmentClassification $treatmentClassification): JsonResponse {
        return $this->success(TreatmentClassificationResource::make($treatmentClassification));
    }

    public function update(TreatmentClassificationRequest $request, TreatmentClassification $treatmentClassification): JsonResponse {
        $treatmentClassification->update($request->validated());

        return $this->success(TreatmentClassificationResource::make($treatmentClassification), 'updated');
    }

    public function delete(TreatmentClassification $treatmentClassification): JsonResponse
    {

        if(count($treatmentClassification['treatments']))
            return $this->failed('can not delete this classification');
        $treatmentClassification->delete();

        return $this->noResponse();
    }
}
