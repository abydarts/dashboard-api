<?php

return [
    '__name' => 'admin-site-meta',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/admin-site-meta.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/admin-site-meta' => ['install','update','remove'],
        'theme/admin/site-meta' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'admin' => NULL
            ],
            [
                'site-meta' => NULL
            ],
            [
                'lib-form' => NULL
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'AdminSiteMeta\\Library' => [
                'type' => 'file',
                'base' => 'modules/admin-site-meta/library'
            ]
        ],
        'files' => []
    ],
    'libForm' => [
        'forms' => [
            'std-site-meta' => [
                'meta-schema' => [
                    'label' => 'Schema',
                    'type' => 'select',
                    'rules' => []
                ],
                'meta-title' => [
                    'label' => 'Title',
                    'type' => 'text',
                    'rules' => []
                ],
                'meta-description' => [
                    'label' => 'Description',
                    'type' => 'textarea',
                    'rules' => []
                ],
                'meta-keywords' => [
                    'label' => 'Keywords',
                    'type' => 'input-tag',
                    'rules' => []
                ]
            ]
        ]
    ]
];