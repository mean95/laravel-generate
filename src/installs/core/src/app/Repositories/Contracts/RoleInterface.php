<?php


namespace Core\Repositories\Contracts;


use Illuminate\Database\Eloquent\Model;

interface RoleInterface
{
    /**
     * Handle store role and other logic
     * @param $attributes
     * @return Model|bool
     */
    public function handleStore($attributes);

    /**
     * Handle update role and other logic
     * @param $attributes
     * @param $id
     * @return bool
     */
    public function handleUpdate($attributes, $id): bool;

    /**
     * Get array role by user id
     * @param $id
     * @return array
     */
    public function getRolesByUserId($id): array;
}
