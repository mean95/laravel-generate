<?php


namespace Core\Repositories\Eloquent;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Core\Models\Permission;
use Core\Repositories\Contracts\PermissionInterface;

class PermissionEloquent extends BaseEloquent implements PermissionInterface
{
    public function model(): string
    {
        return Permission::class;
    }

    /**
     * Handle insert list permissions
     * @param mixed $attributes
     * @return void
     */
    public function store($attributes)
    {
        $arrayPermission = $this->parseParams($attributes);
        return $this->model->insert($arrayPermission);
    }

    /**
     * Handle attach relationship permissions
     * @param mixed $role
     * @param mixed $attributes
     * @return void
     */
    public function attachRelationRolePermission($role, $attributes)
    {
        $permissions = $this->getArrayPermissionIdAfterInsert($attributes);
        $role->permissions()->sync($permissions);
    }

    /**
     * Get array concat uri and method of permission by admin_users login
     * @return array
     */
    public function getConcatUriMethodPermissionsByUserLogin(): array
    {
        return DB::table('admin_users as u')
            ->join('admin_user_role as ru', 'u.id', '=', 'ru.admin_user_id')
            ->join('roles as r', 'ru.role_id', '=', 'r.id')
            ->join('permission_role as pr', 'r.id', '=', 'pr.role_id')
            ->rightJoin('permissions as p', 'pr.permission_id', '=', 'p.id')
            ->where('u.id', Auth::guard('admin')->user()->getKey())
            ->select(DB::raw('CONCAT(p.uri, "/", p.method) AS uri_method'))
            ->pluck('uri_method')->toArray();
    }

    /**
     * @param $role
     * @return mixed
     */
    public function getArrayCheckPermissionByRole($role)
    {
        $permissions = $role->permissions->mapWithKeys(function ($item, $key) {
            return [$key => $item->uri . '/' . $item->method];
        });
        return $permissions->toArray();
    }

    /**
     * @param $attributes
     * @return array
     */
    protected function getArrayPermissionIdAfterInsert($attributes): array
    {
        if (empty($attributes['uri'])) {
            return [];
        }
        $uriPermissions = getUriPermissions();
        $arrayPermission = collect($attributes['uri'])->mapWithKeys(function ($item, $key) use ($uriPermissions) {
            return [$key => $uriPermissions[$item]];
        });
        $permissions = $this->model;
        foreach ($arrayPermission as $key => $value) {
            if ($key === 0) {
                $permissions = $permissions->where(function ($queryFirst) use ($value) {
                    $queryFirst->where('method', $value['method']);
                    $queryFirst->where('uri', $value['uri']);
                });
            }
            $permissions = $permissions->orWhere(function ($query) use ($value) {
                $query->where('method', $value['method']);
                $query->where('uri', $value['uri']);
            });
        }
        return $permissions->pluck('id')->toArray();
    }

    /**
     * Handle parse array data permissions before insert
     * @param $attributes
     * @return array
     */
    protected function parseParams($attributes): array
    {
        if (empty($attributes['uri'])) {
            return [];
        }
        $permissions = $this->getConcatUriMethodPermissions();
        $uriPermissions = getUriPermissions();
        $keyUriPermissions = array_keys($uriPermissions);
        $attributes = collect($attributes['uri'])
            ->filter(function ($item) use ($keyUriPermissions, $permissions){
                return in_array($item, $keyUriPermissions) && !in_array($item, $permissions);
            })
            ->mapWithKeys(function ($item, $key) use ($uriPermissions) {
                return [$key => $uriPermissions[$item]];
            });
        return $attributes->toArray();
    }

    /**
     * Get array concat uri and method of permission
     * @return array
     */
    protected function getConcatUriMethodPermissions(): array
    {
        return $this->model
            ->select(DB::raw('CONCAT(uri, "/", method) AS uri_method'))
            ->pluck('uri_method')->toArray();
    }
}
