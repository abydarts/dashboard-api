<?php

return [
    'Banner\\Model\\Banner' => [
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
            'user' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => true,
                    'null' => false
                ],
                'index' => 2000
            ],
            'name' => [
                'type' => 'VARCHAR',
                'length' => 50,
                'attrs' => [
                    'null' => false,
                    'unique' => true
                ],
                'index' => 3000
            ],
            'placement' => [
                'type' => 'VARCHAR',
                'length' => 50,
                'attrs' => [
                    'null' => false 
                ],
                'index' => 4000
            ],
            'expires' => [
                'type' => 'DATETIME',
                'attrs' => [
                    'null' => false
                ],
                'index' => 5000
            ],
            'type' => [
                'type' => 'TINYINT',
                'length' => 1,
                'attrs' => [
                    'null' => false
                ],
                'index' => 6000
            ],
            'content' => [
                'type' => 'TEXT',
                'attrs' => [],
                'index' => 7000
            ],
            'updated' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP',
                    'update' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 9000
            ],
            'created' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 10000
            ]
        ]
    ]
];