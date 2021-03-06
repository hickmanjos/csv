<?php

namespace Wilgucki\Csv;

use Illuminate\Support\ServiceProvider;
use Wilgucki\Csv\Commands\Export;
use Wilgucki\Csv\Commands\Import;

class CsvServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/csv.php' => config_path('csv.php')
        ], 'config');
    }

    public function register()
    {
        \App::bind('reader', function () {
            return new Reader();
        });

        \App::bind('writer', function () {
            return new Writer();
        });

        $this->app['command.csv.import'] = $this->app->share(
            function ($app) {
                return new Import();
            }
        );

        $this->app['command.csv.export'] = $this->app->share(
            function ($app) {
                return new Export();
            }
        );

        $this->commands('command.csv.import');
        $this->commands('command.csv.export');
    }
}
