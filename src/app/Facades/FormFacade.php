<?php
namespace Core\app\Facades;

use Illuminate\Support\Facades\Facade;
use Core\app\Helpers\FormMaker;

class FormFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     */
    protected static function getFacadeAccessor()
    {
        return FormMaker::class;
    }
}