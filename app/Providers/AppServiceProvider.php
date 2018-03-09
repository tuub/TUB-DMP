<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;
use App\Library\ImageFile;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* Formats given date after $date_pattern */
        Blade::directive('date', function ($expression) {
            return "<?php echo ($expression)->format('Y-m-d'); ?>";
        });

        /* Formats given date after $date_pattern */
        Blade::directive('time', function ($expression) {
            return "<?php echo ($expression)->format('g:i A'); ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local' || $this->app->environment() == 'testing') {
            //$this->app->register('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');
            $this->app->register('Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider');
            $this->app->register('Barryvdh\Debugbar\ServiceProvider');
            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
        }

        if ($this->app->environment() == 'production') {
            //$this->app->register('Ccovey\ODBCDriver\ODBCDriverServiceProvider');
        }
    }
}
