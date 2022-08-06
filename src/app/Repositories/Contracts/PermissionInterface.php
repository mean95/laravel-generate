<?php


namespace Core\app\Repositories\Contracts;


interface PermissionInterface
{
    /**
     * @param mixed $attributes
     * @return void
     */
    public function store($attributes);

    /**
     * Handle attach relationship permissions
     * @param mixed $role
     * @param $attributes
     * @return void
     */
    public function attachRelationRolePermission($role, $attributes);

    /**
     * Get array concat uri and method of permission by admin_users login
     * @return array
     */
    public function getConcatUriMethodPermissionsByUserLogin(): array;
}
