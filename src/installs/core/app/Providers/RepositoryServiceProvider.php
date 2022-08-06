<?php

namespace Core\app\Providers;

use Core\app\Repositories\Contracts\AdminMenuInterface;
use Core\app\Repositories\Contracts\AdminUserInterface;
use Core\app\Repositories\Contracts\BaseInterface;
use Core\app\Repositories\Contracts\ModuleFieldInterface;
use Core\app\Repositories\Contracts\ModuleFieldTypeInterface;
use Core\app\Repositories\Contracts\ModuleInterface;
use Core\app\Repositories\Contracts\PermissionInterface;
use Core\app\Repositories\Contracts\RoleInterface;
use Core\app\Repositories\Eloquent\AdminMenuEloquent;
use Core\app\Repositories\Eloquent\AdminUserEloquent;
use Core\app\Repositories\Eloquent\BaseEloquent;
use Core\app\Repositories\Eloquent\ModuleEloquent;
use Core\app\Repositories\Eloquent\ModuleFieldEloquent;
use Illuminate\Support\ServiceProvider;
use Core\app\Repositories\Eloquent\ModuleFieldTypeEloquent;
use Core\app\Repositories\Eloquent\PermissionEloquent;
use Core\app\Repositories\Eloquent\RoleEloquent;

class RepositoryServiceProvider extends ServiceProvider
{


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            BaseInterface::class, BaseEloquent::class
        );
        $this->app->bind(
            AdminMenuInterface::class, AdminMenuEloquent::class
        );
        $this->app->bind(
            AdminUserInterface::class, AdminUserEloquent::class
        );
        $this->app->bind(
            ModuleInterface::class, ModuleEloquent::class
        );
        $this->app->bind(
            ModuleFieldInterface::class, ModuleFieldEloquent::class
        );
        $this->app->bind(
            ModuleFieldTypeInterface::class, ModuleFieldTypeEloquent::class
        );
        $this->app->bind(
            RoleInterface::class, RoleEloquent::class
        );
        $this->app->bind(
            PermissionInterface::class, PermissionEloquent::class
        );
    }
}        