<?php

return [
    '__name' => 'team',
    '__version' => '0.0.1',
    '__git' => '~',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'bagas dicko',
        'email' => 'fahmial51@gmail.com',
        'website' => 'test.test'
    ],
    '__files' => [
        'modules/team' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'lib-model' => NULL
            ],
            [
                'lib-formatter' => NULL
            ],
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'Team\\Model' => [
                'type' => 'file',
                'base' => 'modules/team/model'
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
                'team' => [
                    'type' => 'chain',
                    'chain' => [
                        'model' => [
                            'name' => 'League\\Model\\LeagueClassement',
                            'field' => 'league'
                        ],
                        'identity' => 'team'
                    ],
                    'model' => [
                        'name' => 'Team\\Model\\Team',
                        'field' => 'id'
                    ],
                    'format' => 'team'
                ]
            ],
            'team' => [
                'id' => [
                    'type' => 'number'
                ],
                'status' => [
                    'type' => 'enum',
                    'enum' => 'team.status',
                    'vtype' => 'int'
                ],
                'name' => [
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

            'league-classement' => [
                'id' => [
                    'type' => 'number'
                ],
                'league' => [
                    'type' => 'object',
                    'model' => [
                        'name' => 'League\\Model\\League',
                        'field' => 'id',
                        'type'  => 'number'
                    ],
                    'format' => 'league'
                ],
                'team' => [
                    'type' => 'object',
                    'model' => [
                        'name' => 'Team\\Model\\Team',
                        'field' => 'id',
                        'type'  => 'number'
                    ],
                    'format' => 'team'
                ],
                'point' => [
                    'type' => 'number'
                ],
                'win' => [
                    'type' => 'number'
                ],
                'draw' => [
                    'type' => 'number'
                ],
                'lose' => [
                    'type' => 'number'
                ],
                'goal_for' => [
                    'type' => 'number'
                ],
                'goal_different' => [
                    'type' => 'number'
                ],
                'goal_against' => [
                    'type' => 'number'
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