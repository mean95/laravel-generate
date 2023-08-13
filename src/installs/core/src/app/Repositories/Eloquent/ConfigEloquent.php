<?php


namespace Core\Repositories\Eloquent;

use Core\Models\Config;
use Core\Repositories\Contracts\ConfigInterface;

class ConfigEloquent extends BaseEloquent implements ConfigInterface
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Config::class;
    }
}
