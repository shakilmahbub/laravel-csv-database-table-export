<?php

namespace Shakil\CsvDatabaseTableExport\Services;

use Illuminate\Database\Eloquent\Model;
use League\Csv\Writer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class CsvExporter
{
    public function exportModelToCsv(string $modelClass, array $options = [])
    {
        $model = new $modelClass;
        $query = $model->query();

        // Apply options
        $disk = $options['disk'] ?? config('table-csv-export.default_disk');
        $directory = $options['directory'] ?? config('table-csv-export.default_directory');
        $filename = $options['filename'] ??
            sprintf(config('table-csv-export.default_filename'), now()->format('Ymd_His'));
        $chunkSize = $options['chunk_size'] ?? config('table-csv-export.chunk_size');
        $includeHeaders = $options['include_headers'] ?? config('table-csv-export.include_headers');

        // Ensure directory exists
        Storage::disk($disk)->makeDirectory($directory);

        $path = $directory.'/'.$filename;
        $fullPath = Storage::disk($disk)->path($path);

        $csv = Writer::createFromPath($fullPath, 'w+');

        if ($includeHeaders) {
            $csv->insertOne($this->getModelHeaders($model));
        }

        $query->chunk($chunkSize, function ($records) use ($csv) {
            foreach ($records as $record) {
                $csv->insertOne($this->formatRecord($record));
            }
        });

        return $path;
    }

    protected function getModelHeaders(Model $model): array
    {
        return array_keys($model->getAttributes());
    }

    protected function formatRecord(Model $record): array
    {
        $attributes = $record->getAttributes();

        foreach ($attributes as $key => $value) {
            if ($value instanceof \DateTimeInterface) {
                $attributes[$key] = $value->format(config('table-csv-export.date_format'));
            } elseif (is_array($value)) {
                $attributes[$key] = json_encode($value);
            } elseif (is_object($value)) {
                $attributes[$key] = method_exists($value, '__toString')
                    ? $value->__toString()
                    : json_encode($value);
            }
        }

        return $attributes;
    }
}
