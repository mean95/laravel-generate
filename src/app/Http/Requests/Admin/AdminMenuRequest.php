<?php

namespace Core\app\Http\Requests\Admin;

use Core\app\Repositories\Contracts\AdminMenuInterface;
use Illuminate\Foundation\Http\FormRequest;

class AdminMenuRequest extends FormRequest
{
    /**
     * @var AdminMenuInterface
     */
    protected $adminMenu;

    /**
     * @param AdminMenuInterface $adminMenu
     */
    public function __construct(AdminMenuInterface $adminMenu)
    {
        $this->adminMenu = $adminMenu;
    }

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
        if (!empty(request('module_id'))) {
            return [
                'module_id' => 'exists:modules,id'
            ];
        }
        $count = $this->adminMenu->all()->count();
        $count = $count ?: 1;
        return [
            'name' => 'required|max:50',
            'url' => 'required|max:256',
            'icon' => 'required|max:50',
            'admin_menu_id' => 'required|between:0,' . $count,
            'sort' => 'nullable|integer',
        ];
    }
}
