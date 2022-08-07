<?php
namespace Core\Facades;

use Illuminate\Support\Facades\Facade;
use Core\Helpers\SchemaManager;

class SchemaManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     */
    protected static function getFacadeAccessor()
    {
        return SchemaManager::class;
    }
}