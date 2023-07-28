<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Task;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $task = Task::find($this->route()->parameters()['task']['id']);
        abort_if($task->status == 'approved', '401', __('you cannot update this task status'));
       
        if ($task->status == 'new') {
            if (!in_array($this->status, ['new','process'])) {
                return false;
            }
        }
        if ($task->status == 'process') {
            if (!in_array($this->status, ['process','closed'])) {
                return false;
            }
        }
        if ($task->status == 'closed') {
            if (!in_array($this->status, ['closed','process','approved'])) {
                return false;
            }
        }

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
            'started_at'        => ['nullable', 'date'],
            'closed_at'         => ['nullable', 'date'],
            'status'            => ['required' => Rule::in(['new', 'process', 'closed', 'approved'])],
        ];
    }
}
