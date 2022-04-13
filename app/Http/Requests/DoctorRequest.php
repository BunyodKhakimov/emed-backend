<?php

namespace App\Http\Requests;

use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
{
    use FailedValidation;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'speciality' => 'required|string',
            'info' => 'required|string',
            'patients' => 'sometimes|integer',
            'experience' => 'sometimes|integer',
            'rating' => 'sometimes|numeric',
        ];
    }
}
