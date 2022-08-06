<?php

namespace Core\app\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ModuleRequest extends FormRequest
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
            'name' => 'required|max:50',
            'icon' => 'required|max:30'
        ];
    }

    /**
     * @param mixed $validator
     * 
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (count($validator->errors()->messages())) {
                $validator->errors()->add('error_module', '#add-module');
            }
        });
    }
}
