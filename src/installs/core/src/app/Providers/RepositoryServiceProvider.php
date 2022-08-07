<?php

namespace Core\Providers;

use Core\Repositories\Contracts\AdminMenuInterface;
use Core\Repositories\Contracts\AdminUserInterface;
use Core\Repositories\Contracts\BaseInterface;
use Core\Repositories\Contracts\ModuleFieldInterface;
use Core\Repositories\Contracts\ModuleFieldTypeInterface;
use Core\Repositories\Contracts\ModuleInterface;
use Core\Repositories\Contracts\PermissionInterface;
use Core\Repositories\Contracts\RoleInterface;
use Core\Repositories\Eloquent\AdminMenuEloquent;
use Core\Repositories\Eloquent\AdminUserEloquent;
use Core\Repositories\Eloquent\BaseEloquent;
use Core\Repositories\Eloquent\ModuleEloquent;
use Core\Repositories\Eloquent\ModuleFieldEloquent;
use Illuminate\Support\ServiceProvider;
use Core\Repositories\Eloquent\ModuleFieldTypeEloquent;
use Core\Repositories\Eloquent\PermissionEloquent;
use Core\Repositories\Eloquent\RoleEloquent;

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