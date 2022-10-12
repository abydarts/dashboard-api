<?php

return [
    '__name' => 'site-match',
    '__version' => '0.0.3',
    '__git' => 'git@github.com:getmim/site-match.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'app/site-match' => ['install','remove'],
        'modules/site-match' => ['install','update','remove'],
        'theme/site/match' => ['install','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'match' => NULL
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
            'SiteMatch\\Controller' => [
                'type' => 'file',
                'base' => ['modules/site-match/controller','app/site-match/controller']
            ],
            'SiteMatch\\Library' => [
                'type' => 'file',
                'base' => 'modules/site-match/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'site' => [
            'getMatchByDate' => [
                'path' => [
                    'value' => '/get-match-by-date',
                ],
                'method' => 'POST',
                'handler' => 'SiteMatch\\Controller\\Match::matchByDate'
            ],
            'siteMatchIndex' => [
                'path' => [
                    'value' => '/match',
                ],
                'method' => 'GET',
                'handler' => 'SiteMatch\\Controller\\Match::index'
            ],
            'siteMatchSingle' => [
                'path' => [
                    'value' => '/match/(:id)',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteMatch\\Controller\\Match::single'
            ],
            'siteMatchBuy' => [
                'path' => [
                    'value' => '/match/(:id)/buy',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'SiteMatch\\Controller\\Match::buy'
            ],
            'siteMatchPayment' => [
                'path' => [
                    'value' => '/match/(:id)/payment',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'SiteMatch\\Controller\\Match::matchPayment'
            ],
            'siteMatchQuiz' => [
                'path' => [
                    'value' => '/match/(:id)/quiz',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'SiteMatch\\Controller\\Match::quiz'
            ],
            'siteMatchQuizPayment' => [
                'path' => [
                    'value' => '/match/(:id)/quiz-payment',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'SiteMatch\\Controller\\Match::quizPayment'
            ],
            'siteVirtualStadium' => [
                'path' => [
                    'value' => '/virtual-stadium-example',
                ],
                'method' => 'GET',
                'handler' => 'SiteMatch\\Controller\\Match::virtualStadiumExample'
            ],
            'siteMatchVirtualStadium' => [
                'path' => [
                    'value' => '/match/(:id)/virtual-stadium',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteMatch\\Controller\\Match::virtualStadium'
            ],
            'SiteVirtualStadiumFeed' => [
                'path' => [
                    'value' => '/virtual-match-feed/(:id)',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteMatch\\Controller\\Match::virtualStadiumXML'
            ],
            'SiteVirtualStadiumPlugin' => [
                'path' => [
                    'value' => '/virtual-match-plugin/(:id)',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteMatch\\Controller\\Match::virtualStadiumPlugin'
            ],
            'siteMatchFeed' => [
                'path' => [
                    'value' => '/match/feed.xml'
                ],
                'method' => 'GET',
                'handler' => 'SiteMatch\\Controller\\Robot::feed'
            ]
        ]
    ],
    'libFormatter' => [
        'formats' => [
            'match' => [
                'page' => [
                    'type' => 'router',
                    'router' => [
                        'name' => 'siteMatchSingle',
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
            'match:created' => [
                'SiteMatch\\Library\\Event::clear' => TRUE
            ],
            'match:deleted' => [
                'SiteMatch\\Library\\Event::clear' => TRUE
            ],
            'match:updated' => [
                'SiteMatch\\Library\\Event::clear' => TRUE
            ]
        ]
    ],
    'site' => [
        'robot' => [
            'feed' => [
                'SiteMatch\\Library\\Robot::feed' => TRUE
            ],
//            'sitemap' => [
//                'SiteMatch\\Library\\Robot::sitemap' => TRUE
//            ]
        ]
    ],
    'libForm' => [
        'forms' => [
            'site.match.quiz' => [
                'match_id' => [
                    'type' => 'number',
                    'nolabel' => TRUE,
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'answer' => [
                    'nolabel' => TRUE,
                    'type' => 'number',
                    'rules' => [
                        'empty' => FALSE
                    ]
                ]
            ],
        ]
    ]
];
