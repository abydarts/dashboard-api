<?php

return [
    '__name' => 'site-games',
    '__version' => '0.1.1',
    '__git' => '~',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Albert Weskers',
        'email' => 'albertweskers@gmail.com',
        'website' => '~'
    ],
    '__dependencies' => [
        'required' => [
            [
                'site' => null
            ]
        ],
        'optional' => [
            [
                'site-setting' => NULL
            ]
        ]
    ],
    'autoload' => [
        'classes' => [
            'SiteGames\\Controller' => [
                'type' => 'file',
                'base' => ['modules/site-games/controller','app/site-games/controller']
            ],
            'SiteGames\\Library' => [
                'type' => 'file',
                'base' => 'modules/site-games/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'site' => [
            'siteGamesIndex' => [
                'path' => [
                    'value' => '/games',
                ],
                'method' => 'GET',
                'handler' => 'SiteGames\\Controller\\Games::index'
            ],
            'siteGamesRedirect' => [
                'path' => [
                    'value' => '/games/(:id)',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteGames\\Controller\\Games::redirect'
            ]
        ]
    ],
];
