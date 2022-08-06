<?php


namespace Core\app\Repositories\Eloquent;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Core\app\Models\AdminUser;
use Core\app\Repositories\Contracts\AdminUserInterface;

class AdminUserEloquent extends BaseEloquent implements AdminUserInterface
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return AdminUser::class;
    }

    /**
     * Create admin user
     * @param $attributes
     * @return mixed
     * @author Means
     */
    public function store($attributes)
    {
        $attributes['password'] = Hash::make($attributes['password']);
        $user = $this->create($attributes);
        if (!empty($attributes['role'])) {
            $user->roles()->sync($attributes['role']);
        }
        return $user;
    }

    /**
     * Update admin user
     * @param array $attributes
     * @param $id
     * @return mixed
     * @author Means
     */
    public function updateUser(array $attributes, $id)
    {
        unset($attributes['password']);
        return $this->update($attributes, $id);
    }

    /**
     * Change password common
     * @param mixed $user
     * @param mixed $password
     * @return mixed string
     * @author Means
     */
    public function changePassword($user, $password)
    {
        if (empty($password)) {
            return false;
        }
        Auth::logoutOtherDevices($password);
        $password = Hash::make($password);
        $user->password = $password;
        $user->save();
        return $user;
    }
}
