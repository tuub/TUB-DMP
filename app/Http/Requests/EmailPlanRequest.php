<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EmailPlanRequest extends Request
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
            'project_number' => 'required',
            'version' => 'required',
            'name' => 'required',
            'email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'email.required'  => 'The email address is required to process your request.',
            'email.email'  => 'The provided email address is not valid.',
        ];
    }
}
