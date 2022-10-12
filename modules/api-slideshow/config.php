<?php

return [
    '__name' => 'api-slideshow',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/api-slideshow.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'https://iqbalfn.com/'
    ],
    '__files' => [
        'modules/api-slideshow' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'slideshow' => NULL
            ],
            [
                'api' => NULL
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'ApiSlideshow\\Controller' => [
                'type' => 'file',
                'base' => 'modules/api-slideshow/controller'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'api' => [
            'apiSlideshow' => [
                'path' => [
                    'value' => '/slideshow'
                ],
                'handler' => 'ApiSlideshow\\Controller\\Slideshow::index',
                'method' => 'GET'
            ],
            'apiSlideshowSingle' => [
                'path' => [
                    'value' => '/slideshow/(:identity)',
                    'params' => [
                        'identity' => 'any'
                    ]
                ],
                'handler' => 'ApiSlideshow\\Controller\\Slideshow::single',
                'method' => 'GET'
            ]
        ]
    ]
];