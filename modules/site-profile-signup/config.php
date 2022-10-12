<?php

return [
    '__name' => 'site-profile-signup',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/site-profile-signup.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'https://iqbalfn.com/'
    ],
    '__files' => [
        'app/site-profile-signup' => ['install','remove'],
        'modules/site-profile-signup' => ['install','update','remove'],
        'theme/site/profile/auth/signup.phtml' => ['install','remove'],
        'theme/site/profile/auth/signup-success.phtml' => ['install','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'profile' => NULL
            ],
            [
                'site' => NULL
            ],
            [
                'profile-auth' => NULL
            ],
            [
                'lib-form' => NULL
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'SiteProfileSignup\\Library' => [
                'type' => 'file',
                'base' => 'modules/site-profile-signup/library'
            ],
            'SiteProfileSignup\\Controller' => [
                'type' => 'file',
                'base' => 'app/site-profile-signup/controller'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'site' => [
            'siteProfileSignup' => [
                'path' => [
                    'value' => '/pme/signup'
                ],
                'handler' => 'SiteProfileSignup\\Controller\\Signup::register',
                'method' => 'GET|POST'
            ]
        ]
    ],
    'libForm' => [
        'forms' => [
            'site.profile.signup' => [
                'name' => [
                    'label' => 'Name',
                    'type' => 'text',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'confirm_password' => [
                    'label' => 'Confirm Password',
                    'type' => 'password',
                    'meter' => FALSE,
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'type' => 'password',
                    'meter' => FALSE,
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE
                    ]
                ],
                'phone' => [
                    'label' => 'Phone Number',
                    'type' => 'text',
                    'rules' => [
                        'required' => true,
                        'empty' => false 
                    ]
                ],
                'birthdate' => [
                    'label' => 'Date of birth',
                    'type' => 'date',
                    'rules' => []
                ],
                'email' => [
                    'label' => 'Email',
                    'type' => 'email',
                    'rules' => [
                        'required' => true,
                        'email' => true,
                    ]
                ],
            ]
        ]
    ]
];