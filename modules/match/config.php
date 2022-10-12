<?php

return [
    '__name' => 'match',
    '__version' => '0.0.1',
    '__git' => '~',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'bagas dicko',
        'email' => 'fahmial51@gmail.com',
        'website' => 'test.test'
    ],
    '__files' => [
        'modules/match' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'Match\\Model' => [
                'type' => 'file',
                'base' => 'modules/match/model'
            ]
        ],
        'files' => []
    ],
    'libEnum' => [
        'enums' => [
            'match.status' => ['Deleted', 'Coming Soon', 'Live Now', 'Expired'],
        ]
    ],
    'libFormatter' => [
        'formats' => [
            'match' => [
                'id' => [
                    'type' => 'number'
                ],
                'result' => [
                    'type' => 'partial',
                    'model' => [
                        'name' => 'Match\\Model\\MatchResult',
                        'field' => 'match',
                    ],
                    'fields' => [
                        [
                            'name' => 'home_score',
                            'type' => 'number'
                        ],
                        [
                            'name' => 'away_score',
                            'type' => 'number'
                        ],
                    ],
                ],
                'status' => [
                    'type' => 'enum',
                    'enum' => 'match.status',
                    'vtype' => 'int'
                ],
                'league' => [
                    'type' => 'object',
                    'model' => [
                        'name'  => 'League\\Model\\League',
                        'field' => 'id',
                        'type'  => 'number'
                    ],
                    'format' => 'league'
                ],
                'home_team' => [
                    'type' => 'object',
                    'model' => [
                        'name'  => 'Team\\Model\\Team',
                        'field' => 'id',
                        'type'  => 'number'
                    ],
                    'format' => 'team'
                ],
                'away_team' => [
                    'type' => 'object',
                    'model' => [
                        'name'  => 'Team\\Model\\Team',
                        'field' => 'id',
                        'type'  => 'number'
                    ],
                    'format' => 'team'
                ],
                'link' => [
                    'type' => 'text'
                ],
                'description' => [
                    'type' => 'text'
                ],

                'match_date' => [
                    'type' => 'date'
                ],
                'closing_date' => [
                    'type' => 'date'
                ],
                'updated' => [
                    'type' => 'date'
                ],
                'created' => [
                    'type' => 'date'
                ]
            ],
            'match-result' => [
                'id' => [
                    'type' => 'number'
                ],
                'home_score' => [
                    'type' => 'number'
                ],
                'away_score' => [
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