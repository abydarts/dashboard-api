<?php

return [
    '__name' => 'post-category',
    '__version' => '0.0.2',
    '__git' => 'git@github.com:getmim/post-category.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/post-category' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'lib-model' => NULL
            ],
            [
                'lib-formatter' => NULL
            ]
        ],
        'optional' => [
            [
                'post' => NULL
            ]
        ]
    ],
    'autoload' => [
        'classes' => [
            'PostCategory\\Model' => [
                'type' => 'file',
                'base' => 'modules/post-category/model'
            ]
        ],
        'files' => []
    ],
    'libFormatter' => [
        'formats' => [
            'post' => [
                'category' => [
                    'type' => 'chain',
                    'chain' => [
                        'model' => [
                            'name' => 'PostCategory\\Model\\PostCategoryChain',
                            'field' => 'post'
                        ],
                        'identity' => 'post_category'
                    ],
                    'model' => [
                        'name' => 'PostCategory\\Model\\PostCategory',
                        'field' => 'id'
                    ],
                    'format' => 'post-category'
                ]
            ],
            'post-category' => [
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
                'slug' => [
                    'type' => 'text'
                ],
                'parent' => [
                    'type' => 'object',
                    'model' => [
                        'name' => 'PostCategory\\Model\\PostCategory',
                        'field' => 'id',
                        'type' => 'number'
                    ],
                    'format' => 'post-category'
                ],
                'content' => [
                    'type' => 'text'
                ],
                'meta' => [
                    'type' => 'json'
                ],
                'updated' => [
                    'type' => 'date'
                ],
                'created' => [
                    'type' => 'date'
                ]
            ],
            'post-category-chain' => [
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
                'post' => [
                    'type' => 'object',
                    'model' => [
                        'name' => 'Post\\Model\\Post',
                        'field' => 'id',
                        'type'  => 'number'
                    ],
                    'format' => 'post'
                ],
                'post_category' => [
                    'type' => 'object',
                    'model' => [
                        'name' => 'PostCategory\\Model\\PostCategory',
                        'field' => 'id',
                        'type'  => 'number'
                    ],
                    'format' => 'post-category'
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
