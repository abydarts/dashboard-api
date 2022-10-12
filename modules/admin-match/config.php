<?php

return [
    '__name' => 'admin-match',
    '__version' => '0.0.4',
    '__git' => 'git@github.com:getmim/admin-match.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/admin-match' => ['install','update','remove'],
        'theme/admin/match' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'admin' => NULL
            ],
            [
                'match' => NULL
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
            'AdminMatch\\Controller' => [
                'type' => 'file',
                'base' => 'modules/admin-match/controller'
            ],
            'AdminMatch\\Library' => [
                'type' => 'file',
                'base' => 'modules/admin-match/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'admin' => [
            'adminMatch' => [
                'path' => [
                    'value' => '/match'
                ],
                'method' => 'GET',
                'handler' => 'AdminMatch\\Controller\\Match::index'
            ],
            'adminMatchEdit' => [
                'path' => [
                    'value' => '/match/(:id)',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'AdminMatch\\Controller\\Match::edit'
            ],
            'adminMatchEditResult' => [
                'path' => [
                    'value' => '/match/(:id)/result',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'AdminMatch\\Controller\\Match::editResult'
            ],
            'adminMatchRemove' => [
                'path' => [
                    'value' => '/match/(:id)/remove',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'AdminMatch\\Controller\\Match::remove'
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
                        'all-match' => [
                            'label' => 'All Match',
                            'icon'  => '<i></i>',
                            'route' => ['adminMatch'],
                            'perms' => 'manage_match'
                        ]
                    ]
                ]
            ]
        ]
    ],
    'libForm' => [
        'forms' => [
            'admin.match.edit' => [
                'league' => [
                    'label' => 'League',
                    'type' => 'select',
                    'rules' => [
                        'required' => true
                    ]
                ],
                'home_team' => [
                    'label' => 'Home Team',
                    'type' => 'select',
                    'rules' => [],
                    'classname' => 'js-data-select-team'
                ],
                'away_team' => [
                    'label' => 'Away Team',
                    'type' => 'select',
                    'rules' => [],
                    'classname' => 'js-data-select-team'
                ],
                'match_date' => [
                    'label' => 'Match Date',
                    'type' => 'datetime',
                    'rules' => [
                        'required' => TRUE
                    ]
                ],
                'link' => [
                    'label' => 'Virtual Stadium URL',
                    'type' => 'url',
                    'rules' => [
                        'required' => FALSE
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
            'admin.match.edit.result' => [
                'home_score' => [
                    'label' => 'Home Score',
                    'type' => 'number',
                    'nolabel' => TRUE,
                    'rules' => [
                        'required' => true
                    ]
                ],
                'away_score' => [
                    'label' => 'Away Score',
                    'type' => 'number',
                    'nolabel' => TRUE,
                    'rules' => [
                        'required' => true
                    ]
                ],
            ],
            'admin.match.index' => [
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
                        '0' => 'All Status',
                        '1' => 'On Going',
                        '2' => 'Expired',
                    ],
                    'rules' => []
                ],
                'league' => [
                    'label' => 'League',
                    'type' => 'select',
                    'nolabel' => TRUE,
                    'rules' => []
                ]
            ]
        ]
    ],
    'admin' => [
        'objectFilter' => [
            'handlers' => [
                'match' => 'AdminMatch\\Library\\Filter'
            ]
        ]
    ]
];
