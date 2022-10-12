<?php

return [
    '__name' => 'api-post',
    '__version' => '0.1.0',
    '__git' => 'git@github.com:getmim/api-post.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/api-post' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'lib-app' => NULL
            ],
            [
                'api' => NULL
            ],
            [
                'post' => NULL
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'ApiPost\\Controller' => [
                'type' => 'file',
                'base' => 'modules/api-post/controller'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'api' => [
            'apiPostIndex' => [
                'path' => [
                    'value' => '/post'
                ],
                'handler' => 'ApiPost\\Controller\\Post::index',
                'method' => 'GET'
            ],
            'apiPostRandom' => [
                'path' => [
                    'value' => '/post/random'
                ],
                'handler' => 'ApiPost\\Controller\\Post::random',
                'method' => 'GET'
            ],
            'apiPostSingle' => [
                'path' => [
                    'value' => '/post/read/(:identity)',
                    'params' => [
                        'identity' => 'any'
                    ]
                ],
                'handler' => 'ApiPost\\Controller\\Post::single',
                'method' => 'GET'
            ]
        ]
    ]
];
