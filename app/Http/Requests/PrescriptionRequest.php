<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PrescriptionRequest extends FormRequest
{
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
            'doctor_id' => 'sometimes',
            'diagnosis' => 'required|string',
            'description' => 'required|string',
            'drugs' => 'required|array',

            'drugs.*.name' => 'required|string',
            'drugs.*.start_date' => 'required|date',
            'drugs.*.period' => 'required|integer',
            'drugs.*.take_time' => ['sometimes', 'date_format:H:i'],
            'drugs.*.dose' => 'sometimes|string',
            'drugs.*.every_day' => 'sometimes|boolean',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.*
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 422));
    }
}
