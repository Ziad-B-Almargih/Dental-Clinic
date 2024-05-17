<?php

namespace App\Services;

use App\Http\Resources\PaymentResource;
use App\Models\Operation;
use App\Models\Patient;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class DebtsServices
{
    public static function totalDebts(): float{
        return
        Patient::query()
            ->with('payments')
            ->get()
            ->sum('remaining');
    }

    public static function debts() {
        $operations = Operation::query()
            ->select(
                'patient_id',
                DB::raw('SUM(treatments.cost) AS total_cost')
            )
            ->leftJoin(
                'treatments',
                'operations.treatment_id',
                '=',
            'treatments.id')
            ->where('type', '=', 'treatments')
            ->groupBy('patient_id');

        $payments = Payment::query()
            ->select(
                'patient_id',
                DB::raw('SUM(amount) AS total_payment')
            )
            ->groupBy('patient_id');

        $patients = Patient::query()
            ->select(
                'patients.id',
                'patients.name',
                'patients.phone_number',
                'operations.total_cost',
                DB::raw('COALESCE(payments.total_payment, 0) AS total_payment'),
                DB::raw('total_cost - total_payment AS remaining')
            )
            ->joinSub($operations,
                'operations',
            'patients.id',
            '=',
            'operations.patient_id')
            ->joinSub($payments,
                'payments',
                'patients.id',
                '=',
                'payments.patient_id',
            'left')
            ->whereRaw('total_cost > total_payment')
            ->orWhereNull('total_payment')
            ->get();

        return $patients;
    }
}
