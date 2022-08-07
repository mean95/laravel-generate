<?php

namespace Core\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => 'required|max:100|unique:roles,display_name,' . $this->route('role'),
            'display_name' => 'required|max:100',
            'description' => 'nullable|max:255',
        ];
    }
}
