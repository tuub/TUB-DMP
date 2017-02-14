<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegistrationRequest extends Request
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
            'real_name' => 'required',
            'email' => 'required|email',
        ];

    }

    public function messages()
    {

        return [
            'real_name.required' => 'The name of the principal investigator is required to process your request.',
            'email.required'  => 'A contact e-mail address is required to process your request.',
            'email.email'  => 'The provided e-mail address is not valid.',
        ];

    }
}
