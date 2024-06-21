<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BugPositionRequest extends FormRequest
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
            'sibling_id' => 'nullable|exists:App\Models\Bug,id',
            'target_id' => 'sometimes|exists:App\Models\Stage,id',
            'sort' => 'sometimes|Integer'
        ];
    }
}
