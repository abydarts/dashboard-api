<?php

return [
    '__name' => 'site-static-page',
    '__version' => '0.0.3',
    '__git' => 'git@github.com:getmim/site-static-page.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'app/site-static-page' => ['install','remove'],
        'modules/site-static-page' => ['install','update','remove'],
        'theme/site/static-page' => ['install','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'static-page' => NULL
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
            'SiteStaticPage\\Controller' => [
                'type' => 'file',
                'base' => ['app/site-static-page/controller','modules/site-static-page/controller']
            ],
            'SiteStaticPage\\Meta' => [
                'type' => 'file',
                'base' => 'modules/site-static-page/meta'
            ],
            'SiteStaticPage\\Library' => [
                'type' => 'file',
                'base' => 'modules/site-static-page/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'site' => [
            'siteStaticPageSingle' => [
                'path' => [
                    'value' => '/page/(:slug)',
                    'params' => [
                        'slug' => 'slug'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteStaticPage\\Controller\\Page::single'
            ],
            'siteStaticPageFeed' => [
                'path' => [
                    'value' => '/page/feed.xml'
                ],
                'method' => 'GET',
                'handler' => 'SiteStaticPage\\Controller\\Robot::feed'
            ]
        ]
    ],
    'libFormatter' => [
        'formats' => [
            'static-page' => [
                'page' => [
                    'type' => 'router',
                    'router' => [
                        'name' => 'siteStaticPageSingle',
                        'params' => [
                            'slug' => '$slug'
                        ]
                    ]
                ]
            ]
        ]
    ],
    'libEvent' => [
        'events' => [
            'static-page:created' => [
                'SiteStaticPage\\Library\\Event::clear' => TRUE
            ],
            'static-page:deleted' => [
                'SiteStaticPage\\Library\\Event::clear' => TRUE
            ],
            'static-page:updated' => [
                'SiteStaticPage\\Library\\Event::clear' => TRUE
            ]
        ]
    ],
    'site' => [
        'robot' => [
            'feed' => [
                'SiteStaticPage\\Library\\Robot::feed' => TRUE
            ],
            'sitemap' => [
                'SiteStaticPage\\Library\\Robot::sitemap' => TRUE
            ]
        ]
    ]
];