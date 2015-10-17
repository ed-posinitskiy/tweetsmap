<?php

return [
    'doctrine'   => [
        'connection'    => [
            'orm_default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params'      => [
                    'host'          => '${db.host}',
                    'port'          => '3306',
                    'user'          => '${db.user}',
                    'password'      => '$(db.password)',
                    'dbname'        => 'tweetsmap',
                    'driverOptions' => [
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
                    ]
                ]
            ]
        ],
        'configuration' => [
            'orm_default' => [
                'metadata_cache'   => 'filesystem',
                'query_cache'      => 'filesystem',
                'generate_proxies' => false,
                'proxy_dir'        => __DIR__ . '/../../data/generated/doctrine-module-proxy'
            ]
        ],
        'cache'         => [
            'filesystem' => [
                'directory' => __DIR__ . '/../../data/cache/doctrine-module-cache'
            ]
        ]
    ],
    'map'        => [
        'source_url' => 'https://maps.googleapis.com/maps/api/js',
        'api_key' => null,
    ],
    'search_api' => [
        'radius'    => '50km',
        'cache_ttl' => 3600
    ]
];
