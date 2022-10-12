<?php

return [
    'Match\\Model\\Matches' => [
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
            'home_team' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => TRUE,
                    'null' => FALSE
                ],
                'index' => 3000
            ],
            'away_team' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => TRUE,
                    'null' => FALSE
                ],
                'index' => 4000
            ],
            'description' => [
                'type' => 'VARCHAR',
                'length' => 150,
                'attrs' => [
                    'null' => TRUE
                ],
                'index' => 5000
            ],
            'link' => [
                'type' => 'VARCHAR',
                'length' => 150,
                'attrs' => [
                    'null' => TRUE
                ],
                'index' => 6000
            ],
            'match_date' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'null' => TRUE
                ],
                'index' => 7000
            ],
            'closing_date' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'null' => TRUE
                ],
                'index' => 8000
            ],
            'status' => [
                'comment' => '0 Deleted, 1 Active',
                'type' => 'TINYINT',
                'attrs' => [
                    'unsigned' => false,
                    'null' => false,
                    'default' => 1
                ],
                'index' => 9000
            ],
            'updated' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP',
                    'update' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 10000
            ],
            'created' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 11000
            ]
        ]
    ],
    'Match\\Model\\MatchResult' => [
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
            'match' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => TRUE,
                    'null' => FALSE
                ],
                'index' => 2000
            ],
            'home_score' => [
                'type' => 'INT',
                'attrs' => [
                    'null' => FALSE,
                    'default' => 0
                ],
                'index' => 3000
            ],
            'away_score' => [
                'type' => 'INT',
                'attrs' => [
                    'null' => FALSE,
                    'default' => 0
                ],
                'index' => 4000
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
];