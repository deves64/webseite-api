<?php

return [
    'default' => 'lumen_api',
    'migrations' => 'migrations',
    'connections' => [
        'lumen_api' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST'),
            'port'      => env('DB_PORT'),
            'database'  => env('DB_DATABASE'),
            'username'  => env('DB_USERNAME'),
            'password'  => env('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
        'laravel_website' => [
            'driver'    => 'mysql',
            'host'      => env('DB2_HOST'),
            'port'      => env('DB2_PORT'),
            'database'  => env('DB2_DATABASE'),
            'username'  => env('DB2_USERNAME'),
            'password'  => env('DB2_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
    ]
];