<?php

return [
    '__name' => 'lib-image',
    '__version' => '0.0.2',
    '__git' => 'git@github.com:getmim/lib-image.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-image' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'claviska\\SimpleImage' => [
                'type' => 'file',
                'base' => 'modules/lib-image/third-party/SimpleImage.php'
            ]
        ],
        'files' => []
    ]
];