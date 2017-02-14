<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class CreatePlanRequest extends Request
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
            'project_number' => 'required|unique_with:plans,version',
            'template_id' => 'required',
            'user_id' => 'required'
        ];
    }
}
