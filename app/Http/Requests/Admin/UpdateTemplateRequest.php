<?php

namespace App\Http\Requests\Admin;

use App\Template;
use Illuminate\Support\Facades\View;
use App\Http\Requests\Request;

//namespace App\Http\Requests;

//use App\Http\Requests\Request;

class UpdateTemplateRequest extends Request
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
            'name' => 'required|min:3',
            'logo_file' => 'image',
        ];
    }
}
