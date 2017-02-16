<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use Route;

class ProjectRequest extends Request
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
        $id = Route::input('project');
        return [
            'identifier' => 'required|max:50|unique:projects,identifier' . ($id ? ',' . $id : ''),
            'user_id' => 'required'
        ];
    }
}
