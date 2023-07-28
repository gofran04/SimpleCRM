<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'company_name'      => ['required', 'string'],
            'phone'             => 'required|starts_with:0|string|min:10|max:10|unique:clients,phone,'.$this->client->id,
            'email'             => 'required|email|unique:clients,email,'.$this->client->id,
            'address'           => ['required']
        ];
    }
}
