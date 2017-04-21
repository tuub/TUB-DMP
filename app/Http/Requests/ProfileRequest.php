<?php

namespace App\Http\Requests;

class ProfileRequest extends Request
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
            'name' => 'required',
            'email' => 'required|email',
            'new_password' => 'same:confirm_password',
            'confirm_password' => 'same:new_password',
        ];

    }

    public function messages()
    {

        return [
            'name.required' => 'The name is required to process your request.',
            'email.required'  => 'A contact e-mail address is required to process your request.',
            'email.email'  => 'The provided e-mail address is not valid.',
            'new_password.same' => 'The passwords are not identical.',
            'confirm_password.same' => 'The passwords are not identical.',
        ];

    }
}
