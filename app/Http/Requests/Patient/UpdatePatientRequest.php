<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => ['string'],
            'phone_number' => ['regex:/^09[0-9]{8}$/', 'unique:patients'],
            'berth_date'   => ['date'],
            'note'         => ['string', 'nullable'],
            'prescription' => ['string', 'nullable'],
            'gender'       => ['required', 'integer', 'between:0,1'],
        ];
    }
}
