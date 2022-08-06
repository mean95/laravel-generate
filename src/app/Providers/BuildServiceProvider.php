<?php

namespace Install\Providers;

use Install\Commands\Build;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class BuildServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function boot() {

        $this->commands([
            Build::class,
        ]);

    }

    /**
     *
     */
    public function register() {
        //
    }
}
