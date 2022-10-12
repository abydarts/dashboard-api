<?php

return [
    '__name' => 'banner',
    '__version' => '0.1.0',
    '__git' => 'git@github.com:getmim/banner.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/banner' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'lib-model' => NULL
            ],
            [
                'lib-user' => NULL
            ],
            [
                'lib-formatter' => NULL
            ],
            [
                'lib-enum' => NULL
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'Banner\\Model' => [
                'type' => 'file',
                'base' => 'modules/banner/model'
            ],
            'Banner\\Library' => [
                'type' => 'file',
                'base' => 'modules/banner/library'
            ]
        ],
        'files' => []
    ],
    'libEnum' => [
        'enums' => [
            'banner.type' => [
                1 => 'Image',
                2 => 'HTML',
                3 => 'Google Adsense',
                4 => 'iFrame'
            ]
        ]
    ],
    'libFormatter' => [
        'formats' => [
            'banner' => [
                'id' => [
                    'type' => 'number'
                ],
                'user' => [
                    'type' => 'object',
                    'model' => [
                        'name' => 'LibUser\\Library\\Fetcher',
                        'field' => 'id',
                        'type' => 'number'
                    ],
                    'format' => 'user'
                ],
                'name' => [
                    'type' => 'text'
                ],
                'placement' => [
                    'type' => 'text'
                ],
                'expires' => [
                    'type' => 'date'
                ],
                'type' => [
                    'type' => 'enum',
                    'enum' => 'banner.type',
                    'vtype' => 'int'
                ],
                'content' => [
                    'type' => 'json'
                ],
                'updated' => [
                    'type' => 'date'
                ],
                'created' => [
                    'type' => 'date'
                ]
            ]
        ]
    ]
];
