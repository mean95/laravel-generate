<?php

namespace Core\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class DirectiveServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function boot() {
        
        // Form Input Maker
        Blade::directive('coreInput', function($expression) {
            return "<?php echo formMaker()->input({$expression}); ?>";
        });

        // Form Input Maker
        Blade::directive('coreForm', function($expression) {
            return "<?php echo formMaker()->form({$expression}); ?>";
        });
    }

    /**
     *
     */
    public function register() {
        //
    }
}