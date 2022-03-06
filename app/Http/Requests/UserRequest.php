<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email_address',
            'phone_number' => 'required|regex:/^998[39][012345789][0-9]{7}$/|unique:users,phone_number',
            'password'  => 'required|string|min:8|confirmed',
        ];
    }
}
