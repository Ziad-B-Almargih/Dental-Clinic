<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class CreatePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'         => ['required', 'string'],
            'phone_number' => ['required', 'regex:/^09[0-9]{8}$/', 'unique:patients'],
            'berth_date'   => ['required', 'date'],
            'note'        => ['string'],
            'prescription' => ['string'],
            'gender'       => ['required', 'integer', 'between:0,1'],
        ];
    }
}
