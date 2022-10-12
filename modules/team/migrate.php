<?php

return [
    'Team\\Model\\Team' => [
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
            'name' => [
                'type' => 'VARCHAR',
                'length' => 150,
                'attrs' => [
                    'null' => FALSE
                ],
                'index' => 2000
            ],
            'cover' => [
                'type' => 'TEXT',
                'attrs' => [],
                'index' => 5000
            ],
            'link' => [
                'type' => 'VARCHAR',
                'length' => 150,
                'attrs' => [
                    'null' => TRUE
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
            'status' => [
                'comment' => '0 Deleted, 1 Active',
                'type' => 'TINYINT',
                'attrs' => [
                    'unsigned' => false,
                    'null' => false,
                    'default' => 1
                ],
                'index' => 6000
            ],
            'updated' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP',
                    'update' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 7000
            ],
            'created' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 8000
            ]
        ]
    ]
];