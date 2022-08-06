<?php


namespace Core\app\Traits;


use Illuminate\Support\Facades\Auth;
use Core\app\Repositories\Contracts\PermissionInterface;
use Core\app\Repositories\Contracts\RoleInterface;

trait PermissionTrait
{
    /**
     * @param bool $id
     *
     * @return bool
     * @throws \Exception
     */
    public function isSuperAdmin(bool $id = false): bool
    {
        if (in_array(config('core.permission.super_admin'), $this->getPreparedRoles($id))) {
            return true;
        }
        return false;
    }

    /**
     * @param bool $id
     *
     * @return bool
     * @throws \Exception
     */
    public function isViewer(bool $id = false): bool
    {
        if (in_array(config('core.permission.viewer'), $this->getPreparedRoles($id))) {
            return true;
        }
        return false;
    }

    /**
     * Get array role by user id
     * @param $id
     * @return array
     */
    protected function getPreparedRoles($id): array
    {
        $id = !empty($id) ? $id : Auth::guard('admin')->user()->getKey();
        return app(RoleInterface::class)->getRolesByUserId($id);
    }

    /**
     * Check permission access
     * @param $nameRoute
     * @return bool
     * @throws \Exception
     * @author Means
     */
    public function isAccess($nameRoute): bool
    {
        if (in_array($nameRoute, $this->hasNameRouteAccess()) || $this->isSuperAdmin()) {
            return true;
        }
        return false;
    }

    /**
     * Get array name route permission by user login
     * @return array
     */
    protected function hasNameRouteAccess(): array
    {
        $permissions = app(PermissionInterface::class)->getConcatUriMethodPermissionsByUserLogin();
        $uriPermissions = getUriPermissions();
        return collect($permissions)->mapWithKeys(function ($item, $key) use ($uriPermissions) {
            return [$key => $uriPermissions[$item]['name_route']];
        })->toArray();
    }

    /**
     * @param $permission
     * @return bool
     * @throws \Exception
     */
    public function hasAnyPermission($permission): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        if ($this->isViewer() && str_contains($permission, '/GET')) {
            return true;
        }
        return $this->hasAnyAccess($permission);
    }

    /**
     * @param mixed $permission
     *
     * @return bool
     */
    public function hasAnyAccess($permission): bool
    {
        $permissions = app(PermissionInterface::class)->getConcatUriMethodPermissionsByUserLogin();
        if (in_array($permission, $permissions)) {
            return true;
        }
        return false;
    }
}
