<?php
declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;


/**
 * Class CreateProjectRequest
 *
 * @package App\Http\Requests\Admin
 */
class CreateProjectRequest extends FormRequest
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
            'contact_email' => 'required|email|max:255'
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        parent::messages();
        return [
            'contact_email.required' => 'An institutional contact e-mail address is required to process your request.',
            'contact_email.email' => 'The provided institutional e-mail address is not valid.'
        ];
    }
}