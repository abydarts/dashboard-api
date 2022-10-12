<?php

return [
    '__name' => 'league',
    '__version' => '0.1.3',
    '__git' => 'git@github.com:getmim/league.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/league' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'lib-model' => NULL
            ],
            [
                'lib-formatter' => NULL
            ],
            [
                'lib-user' => NULL
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'League\\Model' => [
                'type' => 'file',
                'base' => 'modules/league/model'
            ]
        ],
        'files' => []
    ],
    'libEnum' => [
        'enums' => [
            'league.status' => ['Deleted', 'Published'],
        ]
    ],
    'libFormatter' => [
        'formats' => [
            'league' => [
                'id' => [
                    'type' => 'number'
                ],
                'status' => [
                    'type' => 'enum',
                    'enum' => 'league.status',
                    'vtype' => 'int'
                ],
                'title' => [
                    'type' => 'text'
                ],
                'slug' => [
                    'type' => 'text'
                ],
                'cover' => [
                    'type' => 'std-cover'
                ],
                'description' => [
                    'type' => 'text'
                ],
                'updated' => [
                    'type' => 'date'
                ],
                'created' => [
                    'type' => 'date'
                ]
            ],
        ]
    ]
];
