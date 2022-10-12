<?php

return [
    '__name' => 'site-team',
    '__version' => '0.0.3',
    '__git' => '~',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Bagas Dicko',
        'email' => 'fahmial51@gmail.com',
        'website' => ''
    ],
    '__files' => [
        'app/site-team' => ['install','remove'],
        'modules/site-team' => ['install','update','remove'],
        'theme/site/team' => ['install','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'team' => NULL
            ],
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
            'SiteTeam\\Controller' => [
                'type' => 'file',
                'base' => ['modules/site-team/controller','app/site-team/controller']
            ],
            'SiteTeam\\Library' => [
                'type' => 'file',
                'base' => 'modules/site-team/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'site' => [
            'siteTeamSingle' => [
                'path' => [
                    'value' => '/team/(:id)',
                    'params' => [
                        'id' => 'id'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteTeam\\Controller\\Team::single'
            ],
            'siteTeamFeed' => [
                'path' => [
                    'value' => '/team/feed.xml'
                ],
                'method' => 'GET',
                'handler' => 'SiteTeam\\Controller\\Robot::feed'
            ]
        ]
    ],
    'libFormatter' => [
        'formats' => [
            'team' => [
                'page' => [
                    'type' => 'router',
                    'router' => [
                        'name' => 'siteTeamSingle',
                        'params' => [
                            'id' => '$id'
                        ]
                    ]
                ]
            ]
        ]
    ],
    'libEvent' => [
        'events' => [
            'team:created' => [
                'SiteTeam\\Library\\Event::clear' => TRUE
            ],
            'team:deleted' => [
                'SiteTeam\\Library\\Event::clear' => TRUE
            ],
            'team:updated' => [
                'SiteTeam\\Library\\Event::clear' => TRUE
            ]
        ]
    ],
    'site' => [
        'robot' => [
            'feed' => [
                'SiteTeam\\Library\\Robot::feed' => TRUE
            ],
            'sitemap' => [
                'SiteTeam\\Library\\Robot::sitemap' => TRUE
            ]
        ]
    ]
];
