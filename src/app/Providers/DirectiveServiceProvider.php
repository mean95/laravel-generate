<?php

namespace Core\app\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class DirectiveServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function boot() {
        
        // Form Input Maker
        Blade::directive('mean_input', function($expression) {
            return "<?php echo formMaker()->input({$expression}); ?>";
        });

        // Form Input Maker
        Blade::directive('mean_form', function($expression) {
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