<?php
return [
    /*
     * Debug mode
     */
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),

    /*
     * Salt Key for Application
     */
    'Security' => [
        'salt' => env('SECURITY_SALT', '__SALT__'),
    ],

    /*
     * Database configration
     */
    'Datasources' => [
        // DEFAULT connection
        'default' => [
            'host' => 'localhost',
            //'port' => 'non_standard_port_number',
            'username' => 'root',
            'password' => '',
            'database' => 'cake_base_5',
            //'schema' => 'myapp',
            'url' => env('DATABASE_URL', null),
        ],

        // TEST connection
        'test' => [
            'host' => 'localhost',
            //'port' => 'non_standard_port_number',
            'username' => 'root',
            'password' => '',
            'database' => 'cake_base_5_test',
            //'schema' => 'myapp',
        ],
    ],

    /*
     * Email configuration.
     */
    'EmailTransport' => [
        'default' => [
            'host' => 'localhost',
            'port' => 25,
            'username' => null,
            'password' => null,
            'client' => null,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],
];