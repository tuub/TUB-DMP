<?php
namespace App\Http\Requests;

class UpdatePlanRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /*
        $plan = Plan::findOrFail($this->id);
        return Gate::allows('update', $plan);
        */
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
            'title' => 'required',
            'version' => 'required',
        ];
    }
}