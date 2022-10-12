<?php

return [
    '__name' => 'admin-league',
    '__version' => '0.0.4',
    '__git' => 'git@github.com:getmim/admin-league.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/admin-league' => ['install','update','remove'],
        'theme/admin/league' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'admin' => NULL
            ],
            [
                'league' => NULL
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
            'AdminLeague\\Controller' => [
                'type' => 'file',
                'base' => 'modules/admin-league/controller'
            ],
            'AdminLeague\\Library' => [
                'type' => 'file',
                'base' => 'modules/admin-league/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'admin' => [
            'adminLeague' => [
                'path' => [
                    'value' => '/league'
                ],
                'method' => 'GET',
                'handler' => 'AdminLeague\\Controller\\League::index'
            ],
            'adminLeagueEdit' => [
                'path' => [
                    'value' => '/league/(:id)',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'AdminLeague\\Controller\\League::edit'
            ],
            'adminLeagueEditTeam' => [
                'path' => [
                    'value' => '/league/(:id)/teams',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'AdminLeague\\Controller\\League::editTeam'
            ],
            'adminLeagueAddTeam' => [
                'path' => [
                    'value' => '/league/add-team',
                ],
                'method' => 'POST',
                'handler' => 'AdminLeague\\Controller\\League::addTeam'
            ],
            'adminLeagueRemoveTeam' => [
                'path' => [
                    'value' => '/league/remove-team',
                ],
                'method' => 'POST',
                'handler' => 'AdminLeague\\Controller\\League::removeTeam'
            ],
            'adminLeagueRemove' => [
                'path' => [
                    'value' => '/league/(:id)/remove',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'AdminLeague\\Controller\\League::remove'
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
                        'all-league' => [
                            'label' => 'All League',
                            'icon'  => '<i></i>',
                            'route' => ['adminLeague'],
                            'perms' => 'manage_league'
                        ]
                    ]
                ]
            ]
        ]
    ],
    'libForm' => [
        'forms' => [
            'admin.league.edit' => [
                '@extends' => ['std-cover'],
                'title' => [
                    'label' => 'League Name',
                    'type' => 'text',
                    'rules' => [
                        'required' => TRUE
                    ]
                ],
                'slug' => [
                    'label' => 'Slug',
                    'type' => 'text',
                    'slugof' => 'title',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                        'unique' => [
                            'model' => 'League\\Model\\League',
                            'field' => 'slug',
                            'self' => [
                                'service' => 'req.param.id',
                                'field' => 'id'
                            ]
                        ]
                    ]
                ],
                'description' => [
                    'label' => 'About',
                    'type' => 'summernote',
                    'rules' => [
                        'required' => true
                    ]
                ]
            ],
            'admin.league.index' => [
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
                'league' => 'AdminLeague\\Library\\Filter'
            ]
        ]
    ]
];
