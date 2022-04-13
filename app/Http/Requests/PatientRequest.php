<?php

namespace App\Http\Requests;

use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
            'gender' => ['required', 'string', 'regex:/^(?:male|female)$/'],
            'age' => 'required|integer',
            'profile_image' => 'sometimes|image:jpeg,png,jpg,gif,svg|max:2048',
            'height' => 'sometimes|numeric',
            'weight' => 'sometimes|numeric',
            'blood_pressure' => 'sometimes|numeric',
            'temperature' => 'sometimes|numeric',
        ];
    }
}
