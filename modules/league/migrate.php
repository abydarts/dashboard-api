<?php

return [
    'League\\Model\\League' => [
        'fields' => [
            'id' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => TRUE,
                    'primary_key' => TRUE,
                    'auto_increment' => TRUE
                ],
                'index' => 1000
            ],
            'status' => [
                'comment' => '0 Deleted, 1 Published',
                'type' => 'TINYINT',
                'attrs' => [
                    'unsigned' => true,
                    'null' => false,
                    'default' => 1
                ],
                'index' => 2000
            ],
            'title' => [
                'type' => 'VARCHAR',
                'length' => 150,
                'attrs' => [
                    'null' => FALSE
                ],
                'index' => 3000
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'length' => 150,
                'attrs' => [
                    'null' => FALSE,
                    'unique' => TRUE
                ],
                'index' => 4000
            ],
            'description' => [
                'type' => 'TEXT',
                'attrs' => [],
                'index' => 5000
            ],
            'cover' => [
                'type' => 'TEXT',
                'attrs' => [],
                'index' => 5000
            ],
            'updated' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP',
                    'update' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 5000
            ],
            'created' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 6000
            ]
        ]
    ],
    'League\\Model\\LeagueClassement' => [
        'fields' => [
            'id' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => TRUE,
                    'primary_key' => TRUE,
                    'auto_increment' => TRUE
                ],
                'index' => 1000
            ],
            'league' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => TRUE,
                    'null' => FALSE
                ],
                'index' => 2000
            ],
            'team' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => TRUE,
                    'null' => FALSE
                ],
                'index' => 3000
            ],
            'match_played' => [
                'type' => 'INT',
                'attrs' => [
                    'null' => FALSE,
                    'default' => 0,
                ],
                'index' => 3000
            ],
            'point' => [
                'type' => 'INT',
                'attrs' => [
                    'null' => FALSE,
                    'default' => 0,
                ],
                'index' => 3000
            ],
            'win' => [
                'type' => 'INT',
                'attrs' => [
                    'null' => FALSE,
                    'default' => 0,
                ],
                'index' => 3000
            ],
            'draw' => [
                'type' => 'INT',
                'attrs' => [
                    'null' => FALSE,
                    'default' => 0,
                ],
                'index' => 3000
            ],
            'lose' => [
                'type' => 'INT',
                'attrs' => [
                    'null' => FALSE,
                    'default' => 0,
                ],
                'index' => 3000
            ],
            'goal_for' => [
                'type' => 'INT',
                'attrs' => [
                    'null' => FALSE,
                    'default' => 0,
                ],
                'index' => 3000
            ],
            'goal_difference' => [
                'type' => 'INT',
                'attrs' => [
                    'null' => FALSE,
                    'default' => 0,
                ],
                'index' => 3000
            ],
            'goal_against' => [
                'type' => 'INT',
                'attrs' => [
                    'null' => FALSE,
                    'default' => 0,
                ],
                'index' => 3000
            ],
            'updated' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP',
                    'update' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 40000
            ],
            'created' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 5000
            ]
        ]
    ]
];