<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Export Settings
    |--------------------------------------------------------------------------
    |
    | These settings will be used as defaults for all CSV exports unless
    | overridden in the command options.
    |
    */

    'default_disk' => 'local',
    'default_directory' => 'exports',
    'default_filename' => 'export_%s.csv', // %s will be replaced with timestamp
    'chunk_size' => 1000,
    'include_headers' => true,
    'date_format' => 'Y-m-d H:i:s',
];
