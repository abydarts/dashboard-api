<?php
/**
 * Module lib-event config
 * @package lib-event
 * @version 0.0.1
 */

return [
    '__name' => 'lib-event',
    '__version' => '0.0.2',
    '__git' => 'git@github.com:getphun/lib-event.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'https://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-event' => ['install', 'update', 'remove']
    ],
    '__dependencies' => [
        'required' => [],
        'optional' => [
            [
                'lib-worker' => null
            ]
        ]
    ],
    'autoload' => [
        'classes' => [
            'LibEvent\\Library' => [
                'type' => 'file',
                'base' => 'modules/lib-event/library'
            ],
            'LibEvent\\Service' => [
                'type' => 'file',
                'base' => 'modules/lib-event/service'
            ]
        ]
    ],

    'service' => [
        'event' => 'LibEvent\\Service\\Event'
    ],

    'libEvent' => [
        'events' => [
            'match-updated' => [
                'AdminLeague\\Controller\\LeagueController::updateClassementAction' => true
            ]
        ]
    ]
];
