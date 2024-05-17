<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrUpdatePaymentRequest;
use App\Http\Resources\PatientPaymentResource;
use App\Http\Resources\PaymentResource;
use App\Models\Patient;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function index(Patient $patient): JsonResponse
    {
        return $this->success(PatientPaymentResource::make($patient));
    }

    public function create(CreateOrUpdatePaymentRequest $request, Patient $patient): JsonResponse
    {
        $data = $request->validated();

        if($patient['remaining'] < $data['amount'])
            return $this->failed('the amount must be less than or equal '.$patient['remaining']);

        $data['patient_id'] = $patient['id'];

        $payment = Payment::query()
            ->create($data);

        return $this->success(PaymentResource::make($payment));
    }

    public function update(CreateOrUpdatePaymentRequest $request, Patient $patient, Payment $payment): JsonResponse
    {
        $data = $request->validated();
        if($patient['remaining'] + $payment['amount'] < $data['amount'])
            return $this->failed('the amount must be less than or equal '.$patient['remaining'] + $payment['amount']);

        $payment->update($request->validated());

        return $this->success(PaymentResource::make($payment));
    }

    public function delete(Patient $patient, Payment $payment): JsonResponse
    {
        $payment->delete();

        return $this->noResponse();
    }
}
