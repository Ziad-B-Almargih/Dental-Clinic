<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrUpdateDiseaseRequest;
use App\Models\Disease;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use function request;

class DiseaseController extends Controller
{
    public function index(): JsonResponse
    {
        $searchWord = request('search-word');

        $diseases = Disease::query()
            ->when($searchWord, function (Builder $q) use ($searchWord){
                return $q->where('name', 'LIKE', "%$searchWord%");
            })
            ->get();

        return $this->success($diseases);
    }

    public function create(CreateOrUpdateDiseaseRequest $request): JsonResponse
    {
        $disease = Disease::query()
            ->create($request->validated());

        return $this->success($disease, 'created', 201);
    }

    public function update(CreateOrUpdateDiseaseRequest $request, Disease $disease): JsonResponse
    {
        $disease->update($request->validated());

        return $this->success($disease);
    }

    public function delete(Disease $disease): JsonResponse
    {
        $disease->delete();

        return $this->noResponse();
    }

}
