<?php

return [
    '__name' => 'site-league',
    '__version' => '0.0.3',
    '__git' => 'git@github.com:getmim/site-league.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'app/site-league' => ['install','remove'],
        'modules/site-league' => ['install','update','remove'],
        'theme/site/league' => ['install','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'league' => NULL
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
            'SiteLeague\\Controller' => [
                'type' => 'file',
                'base' => ['modules/site-league/controller','app/site-league/controller']
            ],
            'SiteLeague\\Library' => [
                'type' => 'file',
                'base' => 'modules/site-league/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'site' => [
            'siteGetClubDetails' => [
                'path' => [
                    'value' => '/get-club-details',
                ],
                'method' => 'POST',
                'handler' => 'SiteLeague\\Controller\\League::getClubDetails'
            ],
            'siteLeagueSingle' => [
                'path' => [
                    'value' => '/league/(:id)',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteLeague\\Controller\\League::single'
            ],
            'siteLeagueClassement' => [
                'path' => [
                    'value' => '/league/(:id)/classement',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteLeague\\Controller\\League::classement'
            ],
            'siteLeagueSchedule' => [
                'path' => [
                    'value' => '/league/(:id)/schedule',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteLeague\\Controller\\League::schedule'
            ],
            'siteLeagueClub' => [
                'path' => [
                    'value' => '/league/(:id)/club',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteLeague\\Controller\\League::club'
            ],
            'siteLeagueClubStatistic' => [
                'path' => [
                    'value' => '/league/(:id)/club-statistic',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteLeague\\Controller\\League::clubStatistic'
            ],
            'siteLeagueFeed' => [
                'path' => [
                    'value' => '/league/feed.xml'
                ],
                'method' => 'GET',
                'handler' => 'SiteLeague\\Controller\\Robot::feed'
            ]
        ]
    ],
    'libFormatter' => [
        'formats' => [
            'league' => [
                'page' => [
                    'type' => 'router',
                    'router' => [
                        'name' => 'siteLeagueSingle',
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
            'league:created' => [
                'SiteLeague\\Library\\Event::clear' => TRUE
            ],
            'league:deleted' => [
                'SiteLeague\\Library\\Event::clear' => TRUE
            ],
            'league:updated' => [
                'SiteLeague\\Library\\Event::clear' => TRUE
            ]
        ]
    ],
    'site' => [
        'robot' => [
            'feed' => [
                'SiteLeague\\Library\\Robot::feed' => TRUE
            ]
        ]
    ]
];
