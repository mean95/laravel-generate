<?php


namespace Core\Repositories\Eloquent;


use Core\Models\AdminMenu;
use Core\Repositories\Contracts\AdminMenuInterface;
use Illuminate\Support\Facades\DB;
use Core\Repositories\Contracts\ModuleInterface;

class AdminMenuEloquent extends BaseEloquent implements AdminMenuInterface
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AdminMenu::class;
    }

    /**
     * Get menu by parent === 0
     * @param int $parent
     * @return mixed
     * @author Means
     */
    public function getMenus($parent = 0)
    {
        return $this->with('menuChildren')->orderBy('sort')->findWhere(['admin_menu_id' => $parent]);
    }

    /**
     * Add to admin menu
     * @param mixed $attributes
     * @return mixed
     * @author Means
     */
    public function store($attributes)
    {
        $moduleId = $attributes['module_id'] ?? 0;
        $module = app(ModuleInterface::class)->findByFirst('id', $moduleId);
        $attributes['type'] = config('const.menu_type.custom');
        if (!empty($moduleId) && $module) {
            $attributes['type'] = config('const.menu_type.module');
            $attributes['name'] = $module->label;
            $attributes['url'] = $module->name_db;
            $attributes['icon'] = $module->icon;
        }
        return $this->create($attributes);
    }

    /**
     * Add menu when generate module
     *
     * @param mixed $config
     * @return mixed|bool
     * @author Means
     */
    public function addMenu($config)
    {
        $menu = $this->model->where('url', $config['db_table_name'])->first();
        if ($menu) {
            return false;
        }
        $this->create([
            "name" => $config['module_label'],
            "url" => $config['db_table_name'],
            "icon" => $config['icon'],
            "type" => 'module',
            "admin_menu_id" => 0
        ]);
        return $menu;
    }

    /**
     * Delete menu
     *
     * @param mixed $id
     * @return bool
     */
    public function delete($id)
    {
        $menu = $this->find($id);
        try {
            $exception = DB::transaction(function () use ($menu) {
                $menus = $this->model->where('admin_menu_id', $menu->id)
                    ->update([
                        'admin_menu_id' => $menu->admin_menu_id
                    ]);
                $this->destroy($menu->id);
            });
            return is_null($exception) ? true : false;
        } catch (\Throwable $th) {
            logger($th->getMessage());
            return false;
        }
    }

    /**
     * @param $moduleName
     * @return $this
     */
    public function deleteMenuByModule($moduleName)
    {
        $menu = $this->findByFirst('name', $moduleName);
        if ($menu) {
            $menu->delete();
        }
        return $this;
    }

    /**
     * Handle sort admin menu
     *
     * @param $attributes
     * @return array
     */
    public function updateHierarchy($attributes)
    {
        $parentId = 0;
        for ($i=0; $i < count($attributes); $i++) {
            $this->applyHierarchy($attributes[$i], $i+1, $parentId);
        }
        return $attributes;
    }

    /**
     * Undocumented function
     *
     * @param $menuItem
     * @param $num
     * @param $parentId
     * @return void
     */
    public function applyHierarchy($menuItem, $num, $parentId)
    {
        $menu = $this->find($menuItem['id']);
        $menu->admin_menu_id = $parentId;
        $menu->sort = $num;
        $menu->save();
        if (isset($menuItem['children'])) {
            for ($i=0; $i < count($menuItem['children']); $i++) {
                $this->applyHierarchy($menuItem['children'][$i], $i+1, $menuItem['id']);
            }
        }
    }
}
