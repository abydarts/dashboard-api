<?php

return [
    '__name' => 'lib-robot',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/lib-robot.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-robot' => ['install','update','remove'],
        'theme/site/robot'  => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'lib-formatter' => null
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'LibRobot\\Library' => [
                'type' => 'file',
                'base' => 'modules/lib-robot/library'
            ]
        ],
        'files' => []
    ]
];