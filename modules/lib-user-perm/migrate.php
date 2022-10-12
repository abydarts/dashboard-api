<?php 

return [
    'LibUserMain\\Model\\User' => [
        'fields' => [
            'role' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => true,
                    'default' => 0,
                    'null' => false
                ],
                'index' => 5001
            ]
        ]
    ],
    
    'LibUserPerm\\Model\\UserPerm' => [
        'fields' => [
            'id' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => true,
                    'primary_key' => true,
                    'auto_increment' => true
                ],
                'index' => 0
            ],
            'name' => [
                'type' => 'VARCHAR',
                'length' => 50,
                'attrs' => [
                    'unique' => true,
                    'null' => false
                ],
                'index' => 1000
            ],
            'group' => [
                'type' => 'VARCHAR',
                'length' => 50,
                'attrs' => [
                    'null' => false
                ],
                'index' => 2000
            ],
            'about' => [
                'type' => 'VARCHAR',
                'length' => 200,
                'attrs' => [
                    'null' => false
                ],
                'index' => 3000
            ],
            'created' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 4000
            ]
        ]
    ],
    
    'LibUserPerm\\Model\\UserPermChain' => [
        'fields' => [
            'id' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => true,
                    'primary_key' => true,
                    'auto_increment' => true
                ],
                'index' => 0
            ],
            'user' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => true,
                    'null' => false
                ],
                'index' => 1000
            ],
            'perm' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => true,
                    'null' => false
                ],
                'index' => 2000
            ],
            'created' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 3000
            ]
        ],
        'indexes' => [
            'by_user' => [
                'fields' => [
                    'user' => []
                ]
            ],
            'by_perm' => [
                'fields' => [
                    'perm' => []
                ]
            ]
        ]
    ],
    
    'LibUserPerm\\Model\\UserPermRole' => [
        'fields' => [
            'id' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => true,
                    'primary_key' => true,
                    'auto_increment' => true
                ],
                'index' => 0
            ],
            'user' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => true,
                    'null' => false
                ],
                'index' => 1000
            ],
            'name' => [
                'type' => 'VARCHAR',
                'length' => 50,
                'attrs' => [
                    'unique' => true,
                    'null' => false
                ],
                'index' => 2000
            ],
            'about' => [
                'type' => 'VARCHAR',
                'length' => 200,
                'attrs' => [
                    'null' => false
                ],
                'index' => 3000
            ],
            'created' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 4000
            ]
        ]
    ],

    'LibUserPerm\\Model\\UserPermRoleChain' => [
        'fields' => [
            'id' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => true,
                    'primary_key' => true,
                    'auto_increment' => true
                ],
                'index' => 0
            ],
            'user' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => true,
                    'null' => false
                ],
                'index' => 1000
            ],
            'role' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => true,
                    'null' => false
                ],
                'index' => 2000
            ],
            'perm' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => true,
                    'null' => false
                ],
                'index' => 3000
            ],
            'created' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 4000
            ]
        ],
        'indexes' => [
            'by_role' => [
                'fields' => [
                    'role' => []
                ]
            ],
            'by_perm' => [
                'fields' => [
                    'perm' => []
                ]
            ]
        ]
    ]
];