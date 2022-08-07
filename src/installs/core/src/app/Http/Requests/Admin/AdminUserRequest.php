<?php

namespace Core\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserRequest extends FormRequest
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
        $required = !empty($this->route('admin_user')) ? 'nullable' : 'required';
        return [
            'last_name' => 'required|max:80',
            'first_name' => 'required|max:80',
            'username' => 'required|max:20|unique:admin_users,username,' . $this->route('admin_user') ?? 0,
            'email' => 'required|email:rfc,dns|unique:admin_users,email,' . $this->route('admin_user') ?? 0,
            'password' => $required . '|min:6|max:32|confirmed',
            'avatar' => 'nullable|integer',
            'status' => 'nullable|in:on',
        ];
    }
}
