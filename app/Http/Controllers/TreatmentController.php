<?php

namespace App\Http\Controllers;



use App\Http\Requests\Treatments\TreatmentsRequest;
use App\Http\Resources\Treatments\TreatmentResource;
use App\Models\Treatment;
use Illuminate\Http\JsonResponse;
use function request;

class TreatmentController extends Controller
{
    public function index(): JsonResponse
    {
        $filters['search_word'] = request('search-word');
        $filters['classification_id'] = request('classification-id');

        $treatments = Treatment::query()
            ->filter($filters)
            ->get();

        return $this->success(TreatmentResource::collection($treatments));
    }

    public function create(TreatmentsRequest $request): JsonResponse
    {
        $treatment = Treatment::query()
            ->create($request->validated());

        return $this->success(
            TreatmentResource::make($treatment),
            'created',
            201,
        );
    }

    public function update(TreatmentsRequest $request, Treatment $treatment): JsonResponse {
        $treatment->update($request->validated());

        return $this->success(TreatmentResource::make($treatment), 'updated');
    }

    public function delete(Treatment $treatment): JsonResponse
    {
        $treatment->delete();

        return $this->noResponse();
    }

}
