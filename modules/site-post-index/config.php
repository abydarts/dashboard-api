<?php

return [
    '__name' => 'site-post-index',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/site-post-index.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'https://iqbalfn.com/'
    ],
    '__files' => [
        'app/site-post-index' => ['install','remove'],
        'modules/site-post-index' => ['install','update','remove'],
        'theme/site/post/index.phtml' => ['install','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'post' => NULL
            ],
            [
                'site-post' => NULL
            ],
            [
                'site' => NULL
            ],
            [
                'site-setting' => NULL 
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'SitePostIndex\\Controller' => [
                'type' => 'file',
                'base' => 'app/site-post-index/controller'
            ],
            'SitePostIndex\\Library' => [
                'type' => 'file',
                'base' => 'modules/site-post-index/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'site' => [
            'sitePostIndex' => [
                'path' => [
                    'value' => '/post'
                ],
                'method' => 'GET',
                'handler' => 'SitePostIndex\\Controller\\Post::index'
            ]
        ]
    ]
];