<?php

return [
    '__name' => 'api',
    '__version' => '0.1.0',
    '__git' => 'git@github.com:getmim/api.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/api' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'Api\\Controller' => [
                'type' => 'file',
                'base' => 'modules/api/system/Controller.php'
            ],
            'Api\\Middleware' => [
                'type' => 'file',
                'base' => 'modules/api/system/Middleware.php'
            ],
            'Api\\Library' => [
                'type' => 'file',
                'base' => 'modules/api/library'
            ],
            'Api\\Iface' => [
                'type' => 'file',
                'base' => 'modules/api/interface'
            ]
        ],
        'files' => []
    ],
    'gates' => [
        'api' => [
            'priority' => 10000,
            'host' => [
                'value' => 'HOST'
            ],
            'path' => [
                'value' => '/api'
            ]
        ]
    ],
    'routes' => [
        'api' => [
            404 => [
                'handler' => 'Api\\Controller::show404'
            ],
            500 => [
                'handler' => 'Api\\Controller::show500'
            ]
        ]
    ]
];