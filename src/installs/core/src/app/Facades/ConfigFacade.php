<?php
namespace Core\Facades;

use Core\Repositories\Contracts\ConfigInterface;
use Illuminate\Support\Facades\Facade;

class ConfigFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     */
    protected static function getFacadeAccessor()
    {
        return ConfigInterface::class;
    }
}