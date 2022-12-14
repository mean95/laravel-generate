<?php

namespace Core\Providers;

use Core\Commands\Install;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Core\Facades\MenuFacade;
use Core\Facades\FormFacade;
use Core\Supports\Helper;
use Core\Http\Middleware\AdminAuthenticate;

/**
 * Class BaseServiceProvider
 * @package Core\Providers
 * @author Means
 * @since 1.0
 */
class BaseServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function boot() {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'core');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/../../config/const.php', 'const');
        $this->mergeConfigFrom(__DIR__ . '/../../config/lfm.php', 'lfm');
        $this->mergeConfigFrom(__DIR__ . '/../../config/core.php', 'core');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'core');

        $this->commands([
            Install::class,
        ]);

    }

    /**
     *
     */
    public function register() {

        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('admin', AdminAuthenticate::class);
        AliasLoader::getInstance()->alias('FormMaker', FormFacade::class);
        AliasLoader::getInstance()->alias('AdminMenu', MenuFacade::class);
        Helper::autoload(__DIR__ . '/../../helpers');
    }
}
