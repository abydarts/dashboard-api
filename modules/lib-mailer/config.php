<?php

return [
    '__name' => 'lib-mailer',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/lib-mailer.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-mailer' => ['install','update','remove'],
        'theme/mailer' => ['install','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'lib-view' => NULL
            ]
        ],
        'optional' => []
    ],
    '__inject' => [
        [
            'name' => 'libMailer',
            'children' => [
                [
                    'name' => 'SMTP',
                    'question' => 'Use SMTP protocol',
                    'default' => TRUE,
                    'rule' => 'boolean'
                ],
                [
                    'name' => 'Host',
                    'question' => 'Mailer hostname',
                    'default' => 'smtp.gmail.com',
                    'rule' => '!^.+$!'
                ],
                [
                    'name' => 'SMTPAuth',
                    'question' => 'Use SMTP auth',
                    'default' => TRUE,
                    'rule' => 'boolean'
                ],
                [
                    'name' => 'Username',
                    'question' => 'Mailer username',
                    'rule' => '!^.+$!'
                ],
                [
                    'name' => 'Password',
                    'question' => 'Mailer password',
                    'rule' => '!^.+$!'
                ],
                [
                    'name' => 'SMTPSecure',
                    'question' => 'SMTPSecure',
                    'default' => 'tls',
                    'rule' => '!^.+$!'
                ],
                [
                    'name' => 'Port',
                    'question' => 'Mailer SMTP Port',
                    'default' => 587,
                    'rule' => 'number'
                ],
                [
                    'name' => 'FromEmail',
                    'question' => 'Mailer sender email',
                    'rule' => '!^.+$!'
                ],
                [
                    'name' => 'FromName',
                    'question' => 'Mailer sender name',
                    'rule' => '!^.+$!'
                ]
            ]
        ]
    ],
    'autoload' => [
        'classes' => [
            'LibMailer\\Library' => [
                'type' => 'file',
                'base' => 'modules/lib-mailer/library'
            ],
            'PHPMailer\\PHPMailer' => [
                'type' => 'psr4',
                'base' => 'modules/lib-mailer/third-party/PHPMailer/src'
            ]
        ],
        'files' => []
    ]
];