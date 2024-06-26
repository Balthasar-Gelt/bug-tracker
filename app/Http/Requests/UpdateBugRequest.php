<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBugRequest extends FormRequest
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
            'name' => 'required|string',
            'short_description' => 'required|string|max:100',
            'description' => 'required|string',
            'assignee' => 'nullable|exists:App\Models\User,id',
            'priority_id' => 'required|exists:App\Models\Priority,id',
        ];
    }
}
