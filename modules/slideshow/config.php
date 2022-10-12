<?php

return [
    '__name' => 'slideshow',
    '__version' => '0.0.2',
    '__git' => 'git@github.com:getmim/slideshow.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/slideshow' => ['install','update','remove']
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
                'lib-upload' => NULL
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'Slideshow\\Model' => [
                'type' => 'file',
                'base' => 'modules/slideshow/model'
            ]
        ],
        'files' => []
    ],
    'libFormatter' => [
        'formats' => [
            'slideshow' => [
                'id' => [
                    'type' => 'number'
                ],
                'user' => [
                    'type' => 'object',
                    'model' => [
                        'name'  => 'LibUser\\Library\\Fetcher',
                        'field' => 'id',
                        'type'  => 'number'
                    ],
                    'format' => 'user'
                ],
                'name' => [
                    'type' => 'text'
                ],
                'images' => [
                    'type' => 'json',
                    'format' => 'slideshow-image'
                ],
                'updated' => [
                    'type' => 'date'
                ],
                'created' => [
                    'type' => 'date'
                ]
            ],
            'slideshow-image' => [
                'url' => [
                    'type' => 'media'
                ],
                'text' => [
                    'type' => 'text'
                ],
                'title' => [
                    'type' => 'text'
                ],
                'action' => [
                    'type' => 'text'
                ]
            ]
        ]
    ]
];