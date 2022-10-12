<?php

return [
    '__name' => 'site-profile',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/site-profile.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/site-profile' => ['install','update','remove'],
        'app/site-profile' => ['install','remove'],
        'theme/site/profile' => ['install','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'profile' => NULL
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
            'SiteProfile\\Controller' => [
                'type' => 'file',
                'base' => ['modules/site-profile/controller','app/site-profile/controller']
            ],
            'SiteProfile\\Library' => [
                'type' => 'file',
                'base' => 'modules/site-profile/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'site' => [
            'siteProfileSingle' => [
                'path' => [
                    'value' => '/my-profile/',
                    'params' => [
                        'name' => 'slug'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'SiteProfile\\Controller\\Profile::single'
            ],
            'siteProfileAddress' => [
                'path' => [
                    'value' => '/my-address/',
                    'params' => [
                        'name' => 'slug'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'SiteProfile\\Controller\\Profile::address'
            ],
            'siteProfileEdit' => [
                'path' => [
                    'value' => '/my-edit/',
                    'params' => [
                        'name' => 'slug'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'SiteProfile\\Controller\\Profile::edit'
            ],
            'siteProfileNewsUpdate' => [
                'path' => [
                    'value' => '/my-profile/news-update',
                ],
                'method' => 'GET',
                'handler' => 'SiteProfile\\Controller\\Profile::newsUpdate'
            ],
            'siteProfileLiveMatch' => [
                'path' => [
                    'value' => '/my-profile/live-match',
                ],
                'method' => 'GET',
                'handler' => 'SiteProfile\\Controller\\Profile::single'
            ],
            'siteProfileFeed' => [
                'path' => [
                    'value' => '/profile/feed.xml'
                ],
                'method' => 'GET',
                'handler' => 'SiteProfile\\Controller\\Robot::feed'
            ],
            'siteUploadImage' => [
                'path' => [
                    'value' => '/my-profile/upload',
                    'params' => [
                        'file' => 'file'
                    ]
                ],
                'method' => 'POST',
                'handler' => 'SiteProfile\\Controller\\Profile::upload'
            ]
        ]
    ],
    'libFormatter' => [
        'formats' => [
            'profile' => [
                'page' => [
                    'type' => 'router',
                    'router' => [
                        'name' => 'siteProfileSingle',
                        'params' => [
                            'name' => '$name'
                        ]
                    ]
                ]
            ]
        ]
    ],
    'libEvent' => [
        'events' => [
            'profile:created' => [
                'SiteProfile\\Library\\Event::clear' => TRUE
            ],
            'profile:deleted' => [
                'SiteProfile\\Library\\Event::clear' => TRUE
            ],
            'profile:updated' => [
                'SiteProfile\\Library\\Event::clear' => TRUE
            ]
        ]
    ],
    'site' => [
        'robot' => [
            'feed' => [
                'SiteProfile\\Library\\Robot::feed' => TRUE
            ],
//            'sitemap' => [
//                'SiteProfile\\Library\\Robot::sitemap' => TRUE
//            ]
        ]
    ],
    'libForm' => [
        'forms' => [
            'site.profile.address' => [
                'name' => [
                    'type' => 'text',
                    'label' => 'Nama Penerima',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'address' => [
                    'type' => 'text',
                    'label' => 'Alamat',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'state' => [
                    'type' => 'text',
                    'label' => 'Provinsi',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'postal_code' => [
                    'type' => 'text',
                    'label' => 'Kode Pos',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'phone' => [
                    'type' => 'text',
                    'label' => 'Nomor Telepon',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
            ],
            'site.profile.edit' => [
                'avatar' => [
                    'type' => 'hidden',
                    'label' => 'id',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'name' => [
                    'type' => 'text',
                    'label' => 'Name',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'phone' => [
                    'type' => 'text',
                    'label' => 'Phone',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'email' => [
                    'type' => 'text',
                    'label' => 'Email',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'password' => [
                    'type' => 'password',
                    'label' => 'Password'
                ],
                'confirmpassword' => [
                    'type' => 'password',
                    'label' => 'Confirm Password'
                ]
            ],
        ]
    ]
];