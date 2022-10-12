<?php

return [
    '__name' => 'lib-recaptcha',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/lib-recaptcha.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-recaptcha' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'lib-curl' => null
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'LibRecaptcha\\Library' => [
                'type' => 'file',
                'base' => 'modules/lib-recaptcha/library'
            ]
        ],
        'files' => []
    ],
    'libRecaptcha' => [
        'sitekey' => NULL,
        'sitesecret' => NULL
    ],
    '__inject' => [
        [
            'name' => 'libRecaptcha',
            'children' => [
                [
                    'name' => 'sitekey',
                    'question' => 'reCAPTCHA site key',
                    'rule' => '!^.+$!'
                ],
                [
                    'name' => 'sitesecret',
                    'question' => 'reCAPTCHA site secret',
                    'rule' => '!^.+$!'
                ]
            ]
        ]
    ]
];