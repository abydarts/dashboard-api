<?php

return [
    '__name' => 'site-profile-setting',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/site-profile-signup.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'https://iqbalfn.com/'
    ],
    '__files' => [
        'app/site-profile-setting' => ['install','remove'],
        'modules/site-profile-setting' => ['install','update','remove'],
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
            'SiteProfileSetting\\Library' => [
                'type' => 'file',
                'base' => 'modules/site-profile-setting/library'
            ],
            'SiteProfileSetting\\Controller' => [
                'type' => 'file',
                'base' => ['app/site-profile-setting/controller']
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'site' => [
            'siteProfileSetting' => [
                'path' => [
                    'value' => '/pme/settings'
                ],
                'handler' => 'SiteProfileSetting\\Controller\\Setting::account',
                'method' => 'GET|POST'
            ],
            'siteProfileSettingIdentity' => [
                'path' => [
                    'value' => '/pme/settings/identity'
                ],
                'handler' => 'SiteProfileSetting\\Controller\\Setting::identity',
                'method' => 'GET|POST'
            ],
            'siteProfileSettingSecurity' => [
                'path' => [
                    'value' => '/pme/settings/security'
                ],
                'handler' => 'SiteProfileSetting\\Controller\\Setting::security',
                'method' => 'GET|POST'
            ],
        ]
    ],
    'libForm' => [
        'forms' => [
            'site.profile.account' => [
                'avatar' => [
                    'label' => 'Avatar',
                    'type' => 'text',
                    'rules' => [
                    ]
                ],
                'name' => [
                    'label' => 'Name',
                    'type' => 'text',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                        'text' => 'slug',
                    ]
                ],
                'f_name' => [
                    'label' => 'First Name',
                    'type' => 'text',
                    'rules' => [
                        'required' => true,
                        'empty' => false 
                    ]
                ],
                'l_name' => [
                    'label' => 'Last Name',
                    'type' => 'text',
                    'rules' => [
                        'required' => true,
                        'empty' => false
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'type' => 'email',
                    'rules' => [
                        'required' => true,
                        'email' => true,
                    ]
                ],
            ],
            'site.profile.security' => [
                'old_password' => [
                    'label' => 'Old Password',
                    'type' => 'password',
                    'meter' => FALSE,
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE
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
            ],
            'site.profile.identity' => [
                'fullname' => [
                    'label' => 'Nama Lengkap',
                    'type' => 'text',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'gender' => [
                    'label' => 'Jenis Kelamin',
                    'type' => 'select',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'age' => [
                    'label' => 'Umur',
                    'type' => 'select',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'phone' => [
                    'label' => 'Telepon',
                    'type' => 'select',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'occupation' => [
                    'label' => 'Pekerjaan',
                    'type' => 'select',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'religion' => [
                    'label' => 'Agama',
                    'type' => 'select',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'address' => [
                    'label' => 'Alamat',
                    'type' => 'select',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'nationality' => [
                    'label' => 'Kewarganegaraan',
                    'type' => 'select',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'identity_type' => [
                    'label' => ' Jenis Identitas',
                    'type' => 'select',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'nik' => [
                    'label' => 'No. Identitas',
                    'type' => 'select',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'type' => 'email',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
            ],
        ]
    ]
];