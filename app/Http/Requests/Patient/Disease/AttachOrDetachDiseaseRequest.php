<?php

namespace App\Http\Requests\Patient\Disease;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class AttachOrDetachDiseaseRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'disease_id' => ['required', 'integer', 'exists:diseases,id'],
        ];
    }
}
