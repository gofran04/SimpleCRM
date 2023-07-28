<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'description'       => ['required','string'],
            'assigned_user'     => ['required', 'exists:users,id'],
            'assigned_project'  => ['required', 'exists:projects,id'],
           // 'started_at'        => ['nullable', 'date'],
           // 'closed_at'         => ['nullable', 'date'],
            //'status'            => ['required' => Rule::in(['new', 'process', 'closed', 'approved'])],
        ];
    }
}
