<?php

namespace App\Http\Requests\Treatments;

use Illuminate\Foundation\Http\FormRequest;

class TreatmentClassificationRequest extends FormRequest
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
            'name' => ['required', 'string', 'unique:treatment_classifications']
        ];
    }
}
