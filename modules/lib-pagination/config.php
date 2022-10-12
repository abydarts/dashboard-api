<?php
/**
 * Module lib-pagination config
 * @package lib-pagination
 * @version 0.0.1
 */

return [
    '__name' => 'lib-pagination',
    '__version' => '0.1.0',
    '__git' => 'git@github.com:getphun/lib-pagination.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'https://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-pagination' => ['install', 'update', 'remove']
    ],
    '__dependencies' => [
        'required' => [],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'LibPagination\Library' => [
                'type' => 'file',
                'base' => 'modules/lib-pagination/library'
            ]
        ]
    ]
];
