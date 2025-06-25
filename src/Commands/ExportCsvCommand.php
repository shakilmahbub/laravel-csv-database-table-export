<?php

namespace Shakil\CsvDatabaseTableExport\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
class ExportCsvCommand extends Command
{
    protected $signature = 'export:csv 
                            {model : The model class to export}
                            {--disk= : The storage disk to use}
                            {--directory= : The directory to save the export}
                            {--filename= : The filename for the export}
                            {--chunk-size= : Number of records to process at a time}
                            {--no-headers : Exclude headers from the CSV}';

    protected $description = 'Export an Eloquent model to CSV';

    public function handle()
    {
        $modelClass = $this->argument('model');

        if (!class_exists($modelClass)) {
            $this->error("Model class {$modelClass} does not exist.");
            return 1;
        }

        $options = [
            'disk' => $this->option('disk'),
            'directory' => $this->option('directory'),
            'filename' => $this->option('filename'),
            'chunk_size' => $this->option('chunk-size'),
            'include_headers' => !$this->option('no-headers'),
        ];

        $this->info("Starting export of {$modelClass} to CSV...");

        try {
            $exporter = App::make('csv-exporter');
            $path = $exporter->exportModelToCsv($modelClass, $options);

            $this->info("Export completed successfully!");
            $this->line("File saved to: {$path}");

            return 0;
        } catch (\Exception $e) {
            $this->error("Export failed: {$e->getMessage()}");
            return 1;
        }
    }
}
