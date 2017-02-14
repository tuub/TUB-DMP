<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class UpdateUserRequest extends Request
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
            'new_password' => 'same:confirm_password',
            'confirm_password' => 'same:new_password',
        ];

    }

    public function messages()
    {
        return [
            'new_password.same' => 'The passwords are not identical.',
            'confirm_password.same' => 'The passwords are not identical.',
        ];

    }
}
