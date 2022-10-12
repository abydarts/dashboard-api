<?php

return [
    '__name' => 'site-notification',
    '__version' => '0.1.1',
    '__git' => '~',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Bagas Dicko',
        'email' => 'fahmial@gmail.com',
        'website' => '~'
    ],
    '__files' => [
        'modules/site-notification' => ['install','update','remove'],
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
            'SiteNotification\\Controller' => [
                'type' => 'file',
                'base' => ['modules/site-notification/controller','app/site-notification/controller']
            ],
            'SiteNotification\\Library' => [
                'type' => 'file',
                'base' => 'modules/site-notification/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'site' => [
            'siteNotificationIndex' => [
                'path' => [
                    'value' => '/notification',
                ],
                'method' => 'GET',
                'handler' => 'SiteNotification\\Controller\\Notification::index'
            ],
        ]
    ],
];
