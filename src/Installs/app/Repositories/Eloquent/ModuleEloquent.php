<?php


namespace Core\app\Repositories\Eloquent;


use Core\app\Models\Module;
use Core\app\Repositories\Contracts\ModuleInterface;
use Illuminate\Support\Str;
use Core\app\Traits\ModuleTrait;

class ModuleEloquent extends BaseEloquent implements ModuleInterface
{

    use ModuleTrait;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Module::class;
    }

    /**
     * @param mixed $moduleName
     * @param mixed $icon
     * @return mixed
     */
    public function generateBase($moduleName, $icon)
    {
        $attributes = $this->generateModuleNames($moduleName, $icon);
        $isGen = false;
        if (file_exists(core_path('app/Http/Controllers/Admin/' . $attributes['controller'] . '.php'))) {
            if (in_array($attributes['model'], ['AdminUser', 'Role', 'Permission'])
                && file_exists(core_path('app/Models/' . $attributes['model'] . '.php'))) {
				$isGen = true;
			}
        }
        $module = $this->model->where('name', $attributes['name'])->first();
        $attributes['is_gen'] = $isGen;
        if ($module) {
            request()->session()->flash('error', trans('core::admin.flash_message.failed'));
            return $module->id;
        }
        request()->session()->flash('success', trans('core::admin.flash_message.create_success'));
        $this->create($attributes);
    }

    /**
     * @param mixed $moduleName
     * @param mixed $icon
     * @return array
     * @author Means
     */
    public function generateModuleNames($moduleName, $icon)
    {
		$moduleName = trim($moduleName);
		$moduleNameSlug = Str::slug($moduleName, '_');
		$attributes['name'] = ucfirst(Str::camel(Str::plural($moduleNameSlug)));
		$attributes['label'] = ucfirst(Str::plural($moduleName));
		$attributes['name_db'] = strtolower(Str::plural($moduleNameSlug));
		$attributes['model'] = ucfirst(Str::camel(Str::singular($moduleNameSlug)));
		$attributes['icon'] = $icon;
		$attributes['view_col'] = "";
		$attributes['controller'] = $attributes['model'] . "Controller";
		return $attributes;
    }

    /**
     * Get count item by module
     *
     * @param mixed $moduleName
     * @return int|string
     * @author Means
     */
    public function itemCount($moduleName)
    {
        $module = $this->getModuleByName($moduleName);
        if (!$module) {
            return 0;
        }
        $moduleName = ucfirst(Str::camel(Str::singular($moduleName)));
        if (file_exists(core_path('app/Models/' . $moduleName . '.php'))) {
            $model = "Core\\app\\Models\\" . $moduleName;
            return $model::count();
        }
        return trans('core::module.item_none');
    }

    /**
     * Get module, field, row, by $moduleName
     *
     * @param mixed $moduleName
     * @param null $row
     * @return object
     * @author Means
     */
    public function get($moduleName, $row = null)
    {
        if (is_int($moduleName)) {
			$module = $this->with('moduleFields')->find($moduleName)->toArray();
		} else {
			$module = $this->with('moduleFields')->findWhereFirst(['name' => $moduleName])->toArray();
        }
        $fields = [];
        foreach ($module['module_fields'] as $field) {
            $fields[$field['column_name']] = $field;
        }
        $module['module_fields'] = $fields;
        $module['row'] = $row ?? null;
        return (object) $module;
    }

    /**
     * Get module by name
     *
     * @param mixed $moduleName
     * @return mixed
     * @author Means
     */
    public function getModuleByName($moduleName)
    {
        return $this->with('moduleFields')->findWhereFirst(['name' => $moduleName]);
    }


    /**
     * Get Module by table name
     *
     * @param mixed $tableName
     * @return object|null
     */
	public function getByTable($tableName) {
		$module = $this->with('moduleFields')->findByFirst('name_db', $tableName);
		if (isset($module)) {
			return $this->get($module->name);
		}
		return null;
    }

    /**
     * Get Array for Dropdown, MultiSelect, Tags input, Radio, checkbox from Module getByTable
     *
     * @param $moduleName
     * @return array
     */
    public function getRecordByTable($moduleName) {
		$module = $this->with('moduleFields')->findByFirst('name', $moduleName);
        if (!isset($module)) {
            return [];
        }
        $moduleName = ucfirst(Str::camel(Str::singular($moduleName)));
        $model = "\Core\app\Models\\" . $moduleName;
        $result = $model::all();
        $data = [];
        foreach ($result as $row) {
            $viewCol = $module->view_col;
            $data[$row->id] = $row->{$viewCol};
        }
        return $data;
	}
}
