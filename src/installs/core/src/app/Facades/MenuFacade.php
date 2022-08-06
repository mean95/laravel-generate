<?php
namespace Core\app\Facades;

use Illuminate\Support\Facades\Facade;
use Core\app\Repositories\Contracts\AdminMenuInterface;

class MenuFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     */
    protected static function getFacadeAccessor()
    {
        return AdminMenuInterface::class;
    }
}