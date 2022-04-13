<?php

namespace App\Http\Requests;

use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class PrescriptionRequest extends FormRequest
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
}
