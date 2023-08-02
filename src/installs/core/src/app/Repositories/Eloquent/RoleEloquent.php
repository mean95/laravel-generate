<?php


namespace Core\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Core\Models\Role;
use Core\Repositories\Contracts\PermissionInterface;
use Core\Repositories\Contracts\RoleInterface;

class RoleEloquent extends BaseEloquent implements RoleInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
    }

    /**
     * Handle store role and other logic
     * @param $attributes
     * @return Model|bool
     */
    public function handleStore($attributes)
    {
        DB::beginTransaction();
        try {
            $role = $this->storeRole($attributes);
            app(PermissionInterface::class)->store($attributes);
            app(PermissionInterface::class)->attachRelationRolePermission($role, $attributes);
            DB::commit();
            return $role;
        } catch (\Throwable $th) {
            logger($th->getMessage());
            request()->session()->flash('error', trans('core::admin.flash_message.failed'));
            DB::rollBack();
            return false;
        }
    }

    /**
     * Handle update role and other logic
     * @param $attributes
     * @param $id
     * @return bool
     */
    public function handleUpdate($attributes, $id): bool
    {
        DB::beginTransaction();
        try {
            $attributes['name'] = Str::upper(Str::slug($attributes['display_name'], '_'));
            $role = $this->update($attributes, $id);
            app(PermissionInterface::class)->store($attributes);
            app(PermissionInterface::class)->attachRelationRolePermission($role, $attributes);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            logger($th->getMessage());
            request()->session()->flash('error', trans('core::admin.flash_message.failed'));
            DB::rollBack();
            return false;
        }
    }

    /**
     * @param $attributes
     * @return Model
     */
    protected function storeRole($attributes): Model
    {
        $attributes['name'] = Str::upper(Str::slug($attributes['display_name'], '_'));
        $role = $this->model->newInstance($attributes);
        $role->save();
        return $role;
    }

    /**
     * Get array role by user id
     * @param $id
     * @return array
     */
    public function getRolesByUserId($id): array
    {
        return $this->model->with('adminUsers')
            ->whereHas('adminUsers', function ($query) use ($id) {
                $query->where('admin_users.id', $id);
            })
            ->pluck('name')->toArray();
    }

    /**
     * get role not super
     * @return mixed
     */
    public function getRolesNotSuper()
    {
        return $this->findWhere([
            ['name', '<>', config('core.permission.super_admin')]
        ], ['id', 'name']);
    }
}
