<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Project;


class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $project = Project::find($this->route()->parameters()['project']['id']);
        abort_if($project->status == 'closed', '401', __('you cannot update this project status'));
       
        if ($project->status == 'process') {
            if (!in_array($this->status, ['process','closed'])) {
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
            'title'         => ['required','string'],
            'description'   => ['required','string'],
            'project_owner' => ['required', 'exists:clients,id'],
            'dead_line'     => ['required', 'date'],
            'status'        => ['required' => Rule::in(['new', 'process', 'closed', 'approved'])],
        ];
    }
}
