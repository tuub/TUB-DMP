<?php
declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;


/**
 * Class UpdateUserRequest
 *
 * @package App\Http\Requests\Admin
 */
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
        return [];
    }
}
