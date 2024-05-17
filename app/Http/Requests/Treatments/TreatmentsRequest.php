<?php

namespace App\Http\Requests\Treatments;

use Illuminate\Foundation\Http\FormRequest;
use function Symfony\Component\Translation\t;

class TreatmentsRequest extends FormRequest
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
            'name'                        => ['required', 'string', 'unique:treatments'],
            'cost'                        => ['required', 'numeric'],
            'treatment_classification_id' => ['required', 'integer', 'exists:treatment_classifications,id']
        ];
    }
}
