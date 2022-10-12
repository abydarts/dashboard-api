<?php

return [
    '__name' => 'lib-app',
    '__version' => '1.0.0',
    '__git' => 'git@github.com:getmim/lib-app.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-app' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'lib-model' => NULL
            ],
            [
                'lib-user' => NULL
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'LibApp\\Model' => [
                'type' => 'file',
                'base' => 'modules/lib-app/model'
            ],
            'LibApp\\Service' => [
                'type' => 'file',
                'base' => 'modules/lib-app/service'
            ],
            'LibApp\\Iface' => [
                'type' => 'file',
                'base' => 'modules/lib-app/interface'
            ]
        ],
        'files' => []
    ],
    'service' => [
        'app' => 'LibApp\\Service\\App'
    ],
    'libApp' => [
        'authorizer' => []
    ]
];