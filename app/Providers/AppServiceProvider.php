<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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

        /* Formats given date after $date_pattern */
        Blade::directive('infobox', function ($content) {
            $output = '<div class="col-xs-24">
                            <div class="alert alert-guidance" role="alert">
                                <div class="row">
                                    <div class="col-xs-1 vertical-align">
                                        <i class="fa fa-info-circle fa-2x"></i>
                                    </div>
                                    <div class="col-xs-22">
                                        ' . $content . '
                                    </div>
                                </div>
                            </div>
                       </div>';

            return $output;
        });

        /* Formats given date after $date_pattern */
        Blade::directive('infobox2', function ($content) {
            $output = '<div class="col-xs-24">
                            <div class="alert alert-guidance" role="alert">
                                <div class="row">
                                    <div class="col-xs-1 vertical-align">
                                        <i class="fa fa-info fa-2x"></i>
                                    </div>
                                    <div class="col-xs-22">
                                        ' . $content . '
                                    </div>
                                </div>
                            </div>
                       </div>';

            return $output;
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
