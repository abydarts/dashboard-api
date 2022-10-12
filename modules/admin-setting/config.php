<?php

return [
    '__name' => 'admin-setting',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/admin-setting.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/admin-setting' => ['install','update','remove'],
        'theme/admin/admin-setting' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'admin' => NULL
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'AdminSetting\\Controller' => [
                'type' => 'file',
                'base' => 'modules/admin-setting/controller'
            ],
            'AdminSetting\\Library' => [
                'type' => 'file',
                'base' => 'modules/admin-setting/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'admin' => [
            'adminSetting' => [
                'path' => [
                    'value' => '/setting'
                ],
                'handler' => 'AdminSetting\\Controller\\Setting::index'
            ]
        ]
    ],
    'adminUi' => [
        'sidebarMenu' => [
            'handlers' => [
                'none' => [
                    'admin-setting' => 'AdminSetting\\Library\\SidebarMenu'
                ]
            ]
        ]
    ],
    'adminSetting' => [
        'menus' => []
    ]
];