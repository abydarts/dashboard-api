<?php

return [
    '__name' => 'admin-ui',
    '__version' => '0.16.1',
    '__git' => 'git@github.com:getmim/admin-ui.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/admin-ui' => ['install','update','remove'],
        'theme/admin/error' => ['install','update','remove'],
        'theme/admin/layout' => ['install','update','remove'],
        'theme/admin/shared' => ['install','update','remove'],
        'theme/admin/static' => ['install','update','remove'],
        'theme/admin/form/field' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'AdminUi\\Library' => [
                'type' => 'file',
                'base' => 'modules/admin-ui/library'
            ],
            'AdminUi\\Iface' => [
                'type' => 'file',
                'base' => 'modules/admin-ui/interface'
            ]
        ],
        'files' => []
    ],
    'adminUi' => [
        'sidebarMenu' => [
            'handlers' => [],
            'items' => []
        ],
        'static' => [
            'head' => [
                'css' => [
                    'css/bootstrap.min.css' => 1,
                    'css/codemirror.min.css' => 1,
                    'css/bootstrap-plugins.min.css' => 1,
                    'css/Chart.min.css' => 1,
                    'css/summernote.min.css' => 1,
                    'css/select2.min.css' => 1,
                ],
                'js' => []
            ],
            'foot' => [
                'css' => [],
                'js' => [
                    'js/jquery-3.3.1.min.js' => 1,
                    'js/popper.min.js' => 1,
                    'js/moment.min.js' => 1,
                    'js/Chart.min.js' => 1,
                    'js/summernote.min.js' => 1,
                    'js/codemirror.min.js' => 1,
                    'js/bootstrap.min.js' => 1,
                    'js/bootstrap-plugins.min.js' => 1,
                    'js/select2.min.js' => 1,
                    'js/main.js' => 1
                ]
            ]
        ]
    ],
    'libFormatter' => [
        'formats' => [
            'aui-std-file-list' => [
                'url' => [
                    'type' => 'media'
                ],
                'path' => [
                    'type' => 'text'
                ],
                'name' => [
                    'type' => 'text'
                ],
                'type' => [
                    'type' => 'text'
                ],
                'size' => [
                    'type' => 'number'
                ]
            ]
        ],
        'handlers' => [
            'aui-std-file-list' => [
                'handler' => 'AdminUi\\Library\\Format::fileList',
                'collective' => false
            ]
        ]
    ]
];
