<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LoginUserRequest extends Request
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
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
            'privacy-statement-1' => 'required',
            'privacy-statement-2' => 'required'
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'email.required' => 'Please provide an e-mail address.',
            'email.email' => 'The e-mail address is not valid.',
            'password.required' => 'Please provide your password..',
            'privacy-statement-1.required' => 'Please check the privacy statement.',
            'privacy-statement-2.required' => 'Please check the privacy statement.'
        ];

        return $messages;
    }
}
