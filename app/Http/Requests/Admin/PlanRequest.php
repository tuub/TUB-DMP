<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use Route;

class PlanRequest extends Request
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
        //TODO: checkout out unique_width
        $id = Route::input('plan');
        return [
            //'title' => 'required|max:255|unique:plans,title,project_id' . ($id ? ',' . $id : ''),
            'version' => 'required',
            'template_id' => 'required'
        ];
    }
}
