<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegistrationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'          => ['required'],
            'email'         => ['required','email','unique:users'],
            'password'      => ['required','confirmed','min:6'],
            'phone'         => ['required', 'starts_with:0', 'string', 'min:10', 'max:10', 'unique:users,phone'],
            'address'       => ['required'],

        ];
    }


    /* public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json($validator->errors(), 422)); 
    } */
}
