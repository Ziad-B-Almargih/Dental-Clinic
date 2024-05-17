<?php

namespace App\Http\Controllers;

use App\Http\Requests\Patient\CreatePatientRequest;
use App\Http\Requests\Patient\Disease\AttachOrDetachDiseaseRequest;
use App\Http\Requests\Patient\UpdatePatientRequest;
use App\Http\Resources\Patients\PatientDataResource;
use App\Http\Resources\Patients\PatientIndexResource;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;
use function request;

class PatientController extends Controller
{
    public function index(): JsonResponse {
        $searchWord = request('search-word');
        $patients = Patient::query()
            ->search($searchWord)
            ->get();
        return $this->success(PatientIndexResource::collection($patients));
    }

    public function show(Patient $patient): JsonResponse{
        return $this->success(PatientDataResource::make($patient));
    }

    public function create(CreatePatientRequest $request): JsonResponse {
        $patient = Patient::query()
            ->create($request->validated());

        return $this->success(
            PatientDataResource::make($patient),
            'created',
            201
        );
    }

    public function update(UpdatePatientRequest $request, Patient $patient): JsonResponse {
        $patient->update($request->validated());

        return $this->success(PatientDataResource::make($patient));
    }

    public function delete(Patient $patient): JsonResponse {
        $patient->delete();

        return $this->noResponse();
    }

    public function addDisease(AttachOrDetachDiseaseRequest $request, Patient $patient): JsonResponse
    {
        $data = $request->validated();

        if($patient->diseases->contains($data['disease_id']))
            return $this->failed('this disease already exists');

        $patient->diseases()->attach($data['disease_id']);

        return $this->noResponse();
    }

    public function deleteDisease(AttachOrDetachDiseaseRequest $request, Patient $patient): JsonResponse
    {
        $data = $request->validated();

        if(!$patient->diseases->contains($data['disease_id']))
            return $this->failed('this disease is not exists');

        $patient->diseases()->detach($data['disease_id']);

        return $this->noResponse();
    }
}
