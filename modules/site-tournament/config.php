<?php

return [
    '__name' => 'site-tournament',
    '__version' => '0.0.3',
    '__git' => '~',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Bagas Dicko',
        'email' => 'fahmial51@gmail.com',
        'website' => '~'
    ],
    '__files' => [
        'app/site-tournament' => ['install','remove'],
        'modules/site-tournament' => ['install','update','remove'],
        'theme/site/tournament' => ['install','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'site' => NULL
            ],
            [
                'site-meta' => NULL
            ],
            [
                'lib-formatter' => NULL
            ]
        ],
        'optional' => [
            [
                'lib-event' => NULL
            ],
            [
                'lib-cache-output' => NULL
            ]
        ]
    ],
    'autoload' => [
        'classes' => [
            'SiteTournament\\Controller' => [
                'type' => 'file',
                'base' => ['modules/site-tournament/controller','app/site-tournament/controller']
            ],
            'SiteTournament\\Library' => [
                'type' => 'file',
                'base' => 'modules/site-tournament/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'site' => [
            'siteTournamentIndex' => [
                'path' => [
                    'value' => '/tournament',
                ],
                'method' => 'GET',
                'handler' => 'SiteTournament\\Controller\\Tournament::index'
            ],
            'siteTournamentSingle' => [
                'path' => [
                    'value' => '/tournament/(:id)',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteTournament\\Controller\\Tournament::single'
            ],

            'siteTournamentSingleMatch' => [
                'path' => [
                    'value' => '/tournament/(:id)/match',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteTournament\\Controller\\Tournament::singleMatch'
            ],
            'siteTournamentSingleRules' => [
                'path' => [
                    'value' => '/tournament/(:id)/rules',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteTournament\\Controller\\Tournament::singleRules'
            ],
            'siteTournamentSingleTutorial' => [
                'path' => [
                    'value' => '/tournament/(:id)/tutorial',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteTournament\\Controller\\Tournament::singleTutorial'
            ],
            'siteTournamentPayment' => [
                'path' => [
                    'value' => '/tournament/(:id)/join',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'SiteTournament\\Controller\\Tournament::payment'
            ],
            'siteTournamentAddTeam' => [
                'path' => [
                    'value' => '/tournament/(:id)/add-team',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteTournament\\Controller\\Tournament::addTeam'
            ],
            'siteTournamentEditTeam' => [
                'path' => [
                    'value' => '/tournament/(:id)/edit-team',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'SiteTournament\\Controller\\Tournament::editTeam'
            ],
        ]
    ],
    'libFormatter' => [
        'formats' => [
            'tournament' => [
                'page' => [
                    'type' => 'router',
                    'router' => [
                        'name' => 'siteTournamentSingle',
                        'params' => [
                            'id' => '$id'
                        ]
                    ]
                ]
            ]
        ]
    ],
    'site' => [
        'robot' => [
            'feed' => [
                'SiteTournament\\Library\\Robot::feed' => TRUE
            ],
//            'sitemap' => [
//                'SiteTournament\\Library\\Robot::sitemap' => TRUE
//            ]
        ]
    ],
    'libForm' => [
        'forms' => [
            'site.tournament.edit.team' => [
                'group_name' => [
                    'type' => 'text',
                    'nolabel' => TRUE,
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
//                'email' => [
//                    'type' => 'email',
//                    'nolabel' => TRUE,
//                    'rules' => [
//                        'required' => TRUE,
//                        'empty' => FALSE,
//                    ]
//                ],
//                'domisili' => [
//                    'type' => 'text',
//                    'nolabel' => TRUE,
//                    'rules' => [
//                        'required' => TRUE,
//                        'empty' => FALSE,
//                    ]
//                ],
//                'address' => [
//                    'type' => 'text',
//                    'nolabel' => TRUE,
//                    'rules' => [
//                        'required' => TRUE,
//                        'empty' => FALSE,
//                    ]
//                ],
//                'identity' => [
//                    'type' => 'text',
//                    'nolabel' => TRUE,
//                    'rules' => [
//                        'required' => TRUE,
//                        'empty' => FALSE,
//                    ]
//                ],
                'group_players' => [
                    'type' => 'json',
                    'nolabel' => TRUE,
                    'rules' => [
                    ]
                ],
            ]
        ]
    ]
];
