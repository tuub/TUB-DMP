<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestProjectRequest extends FormRequest
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
            'tub_om' => 'required',
            'institution_identifier' => 'required',
            'contact_email' => 'required|email|max:255',
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'contact_email.required' => 'An institutional contact e-mail address is required to process your request.',
            'contact_email.email' => 'The provided institutional e-mail address is not valid.',
        ];
    }
}
