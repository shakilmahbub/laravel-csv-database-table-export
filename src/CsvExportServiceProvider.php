<?php

namespace Shakil\CsvDatabaseTableExport;

use Illuminate\Support\ServiceProvider;
use Shakil\CsvDatabaseTableExport\Commands\ExportCsvCommand;

class CsvExportServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/table-csv-export.php', 'table-csv-export'
        );

        $this->app->singleton('csv-exporter', function ($app) {
            return new Services\CsvExporter();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/table-csv-export.php' => config_path('table-csv-export.php'),
        ], 'table-csv-export-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                ExportCsvCommand::class,
            ]);
        }
    }
}
