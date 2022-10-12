<?php

return [
    '__name' => 'admin-team',
    '__version' => '0.0.4',
    '__git' => 'git@github.com:getmim/admin-team.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/admin-team' => ['install','update','remove'],
        'theme/admin/team' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'admin' => NULL
            ],
            [
                'team' => NULL
            ],
            [
                'lib-formatter' => NULL
            ],
            [
                'lib-form' => NULL
            ],
            [
                'lib-pagination' => NULL
            ],
            [
                'lib-upload' => NULL
            ],
            [
                'admin-site-meta' => NULL
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'AdminTeam\\Controller' => [
                'type' => 'file',
                'base' => 'modules/admin-team/controller'
            ],
            'AdminTeam\\Library' => [
                'type' => 'file',
                'base' => 'modules/admin-team/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'admin' => [
            'adminTeam' => [
                'path' => [
                    'value' => '/team'
                ],
                'method' => 'GET',
                'handler' => 'AdminTeam\\Controller\\Team::index'
            ],
            'adminTeamEdit' => [
                'path' => [
                    'value' => '/team/(:id)',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'AdminTeam\\Controller\\Team::edit'
            ],
            'adminTeamRemove' => [
                'path' => [
                    'value' => '/team/(:id)/remove',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'AdminTeam\\Controller\\Team::remove'
            ]
        ]
    ],
    'adminUi' => [
        'sidebarMenu' => [
            'items' => [
                'competition' => [
                    'label' => 'Competition',
                    'icon' => '<i class="fas fa-newspaper"></i>',
                    'priority' => 0,
                    'children' => [
                        'all-team' => [
                            'label' => 'All Team',
                            'icon'  => '<i></i>',
                            'route' => ['adminTeam'],
                            'perms' => 'manage_team'
                        ]
                    ]
                ]
            ]
        ]
    ],
    'libForm' => [
        'forms' => [
            'admin.team.edit' => [
                '@extends' => ['std-cover'],
                'name' => [
                    'label' => 'Title',
                    'type' => 'text',
                    'rules' => [
                        'required' => TRUE
                    ]
                ],
                'description' => [
                    'label' => 'About',
                    'type' => 'summernote',
                    'rules' => [
                        'required' => true
                    ]
                ],
            ],
            'admin.team.index' => [
                'q' => [
                    'label' => 'Search',
                    'type' => 'search',
                    'nolabel' => TRUE,
                    'rules' => []
                ],
                'status' => [
                    'label' => 'Status',
                    'type' => 'select',
                    'nolabel' => TRUE,
                    'options' => [
                        '0' => 'All',
                        '1' => 'Draft',
                        '2' => 'Editor',
                        '3' => 'Published'
                    ],
                    'rules' => []
                ]
            ]
        ]
    ],
    'admin' => [
        'objectFilter' => [
            'handlers' => [
                'team' => 'AdminTeam\\Library\\Filter'
            ]
        ]
    ]
];
