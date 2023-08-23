<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use stdClass;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' =>'required',
            'country_code' => 'required',
            'phone' => 'required',
            'password' => 'required'
        ];
    }
    public function failedValidation(Validator $validator)
    {
        $obj = new stdClass();
        $errorMessage = implode(', ', $validator->errors()->all());

        throw new HttpResponseException(response()->json([

            'status'   => false,
            'action' => $errorMessage,
        ]));
    }
}
