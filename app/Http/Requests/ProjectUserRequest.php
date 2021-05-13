<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProjectUserRequest extends FormRequest
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
            'user_id' => [
                'required',
                'exists:App\Models\User,id',
                Rule::unique('project_user')->where('project_id', request()->project),
            ],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The User field is required.',
            'exists' => 'The user does not exist.',
            'unique' => 'The user is already assigned to this project.',
        ];
    }
}
