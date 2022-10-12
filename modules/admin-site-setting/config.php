<?php

return [
    '__name' => 'admin-site-setting',
    '__version' => '0.3.2',
    '__git' => 'git@github.com:getmim/admin-site-setting.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/admin-site-setting' => ['install','update','remove'],
        'theme/admin/site-setting'   => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'admin-setting' => NULL 
            ],
            [
                'admin' => NULL
            ],
            [
                'site-setting' => NULL
            ],
            [
                'lib-event' => NULL
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'AdminSiteSetting\\Controller' => [
                'type' => 'file',
                'base' => 'modules/admin-site-setting/controller'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'admin' => [
            'adminSiteSettingSingle' => [
                'path' => [
                    'value' => '/setting/(:group)',
                    'params' => [
                        'group' => 'any'
                    ]
                ],
                'handler' => 'AdminSiteSetting\\Controller\\Setting::single'
            ],
            'adminSiteSettingEdit' => [
                'path' => [
                    'value' => '/setting/(:group)/(:item)',
                    'params' => [
                        'group' => 'any',
                        'item'  => 'number'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'AdminSiteSetting\\Controller\\Setting::edit'
            ]
        ]
    ]
];
