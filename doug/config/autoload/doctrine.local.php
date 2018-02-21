<?php
return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
//                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => [
                    'driver'   => 'pdo_mysql',
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => 'vagrant',
                    'password' => 'vagrant',
                    'dbname'   => 'course'
                ]
            ]
        ],
        'configuration' => [
            'orm_default' => [
                'metadata_cache'   => 'array',
                'query_cache'      => 'array',
                'result_cache'     => 'array',
                'hydration_cache'  => 'array',
                'generate_proxies' => true,
                'proxy_dir'        => __DIR__ . '/../../data/proxy',
                'driver'           => 'orm_default',
            ],
        ],
    ]
];
