<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name'          => ['required', 'string'],
            'phone'         => ['required', 'starts_with:0', 'string', 'min:10', 'max:10', 'unique:clients,phone'],
            'email'         => ['nullable', 'email', 'unique:users'],
            'address'       => ['required'],
            'password'      => ['required','confirmed','min:6'],
            'role'          => ['required', 'exists:roles,id'],
        ];
    }
}
