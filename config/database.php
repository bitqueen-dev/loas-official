<?php
if ($_ENV['APP_ENV'] == 'dev' || $_ENV['APP_ENV'] == 'test') {
    return [
        'fetch' => PDO::FETCH_CLASS,
        'default' => env('DB_CONNECTION', 'mysql'),

        'connections' => [
            'mysql' => [
                'driver' => 'mysql',
                'host' => '127.0.0.1',
                'database' => 'official',
                'username' => 'official',
                'password' => 'FxwD-eZOtxeQi_C4',
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
            ],
            'maintenance' => [
                'driver' => 'mysql',
                'host' => '127.0.0.1',
                'database' => 'maintenance',
                'username' => 'maintenance',
                'password' => 'h645mm4LMzEyA6K5',
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
            ],
        ],

        'redis' => [
            'client' => 'predis',

            'cluster' => false,

            'default' => [
                'host' => '127.0.0.1',
//                'password' => 'xHvnq0JZm5VHAcmq',
                'port' => 6379,
                'database' => 0,
                'read_write_timeout' => 5,
            ],

            'session' => [
                'host' => '127.0.0.1',
//                'password' => 'xHvnq0JZm5VHAcmq',
                'port' => 6379,
                'database' => 1,
                'read_write_timeout' => 5,
            ],
        ],
    ];
} elseif ($_ENV['APP_ENV'] == 'prod') {
    return [
        'fetch' => PDO::FETCH_CLASS,
        'default' => env('DB_CONNECTION', 'mysql'),

        'connections' => [
            'mysql' => [
                'driver' => 'mysql',
                'host' => 'rm-0iw2v1qas1l9g8mw552480.mariadb.japan.rds.aliyuncs.com',
                'database' => 'official',
                'username' => 'official',
                'password' => 'FxwD-eZOtxeQi_C4',
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
            ],
            'maintenance' => [
                'driver' => 'mysql',
                'host' => 'rm-0iw2v1qas1l9g8mw552480.mariadb.japan.rds.aliyuncs.com',
                'database' => 'maintenance',
                'username' => 'maintenance',
                'password' => 'h645mm4LMzEyA6K5',
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
            ],
        ],

        'redis' => [
            'client' => 'predis',

            'cluster' => false,

            'default' => [
                'host' => '192.168.1.61',
                'password' => 'xHvnq0JZm5VHAcmq',
                'port' => 6379,
                'database' => 0,
                'read_write_timeout' => 5,
            ],

            'session' => [
                'host' => '192.168.1.61',
                'password' => 'xHvnq0JZm5VHAcmq',
                'port' => 6379,
                'database' => 1,
                'read_write_timeout' => 5,
            ],
        ],
    ];
}
