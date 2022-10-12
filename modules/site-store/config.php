<?php

return [
    '__name' => 'site-store',
    '__version' => '0.1.1',
    '__git' => '~',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Bagas Dicko',
        'email' => 'fahmial@gmail.com',
        'website' => '~'
    ],
    '__files' => [
        'modules/site-payment' => ['install','update','remove'],
    ],
    '__dependencies' => [
        'required' => [
            [
                'site' => null
            ]
        ],
        'optional' => [
            [
                'site-setting' => NULL
            ]
        ]
    ],
    'autoload' => [
        'classes' => [
            'SiteStore\\Controller' => [
                'type' => 'file',
                'base' => ['modules/site-store/controller','app/site-store/controller']
            ],
            'SiteStore\\Library' => [
                'type' => 'file',
                'base' => 'modules/site-store/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'site' => [
            'siteStoreIndex' => [
                'path' => [
                    'value' => '/store',
                ],
                'method' => 'GET',
                'handler' => 'SiteStore\\Controller\\Store::index'
            ],
            'siteStoreSingle' => [
                'path' => [
                    'value' => '/store/(:id)',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteStore\\Controller\\Store::single'
            ],
            'siteStoreRedeem' => [
                'path' => [
                    'value' => '/store/(:id)/redeem',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'SiteStore\\Controller\\Store::redeem'
            ],
            'siteStoreClaimDetail' => [
                'path' => [
                    'value' => '/claim/(:id)',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteStore\\Controller\\Store::redeemDetail'
            ],
            'siteRewardIndex' => [
                'path' => [
                    'value' => '/my-rewards/',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteStore\\Controller\\Store::rewards'
            ],
            'siteRewardDetail' => [
                'path' => [
                    'value' => '/reward-detail/(:id)',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'SiteStore\\Controller\\Store::rewardDetail'
            ],
            'siteStoreRedeemForm' => [
                'path' => [
                    'value' => '/redeem-form/(:id)',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'SiteStore\\Controller\\Store::redeemForm'
            ],
            'siteStoreClaim' => [
                'path' => [
                    'value' => '/claim/(:id)',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'SiteStore\\Controller\\Store::claim'
            ],
        ]
    ],

    'site' => [
        'robot' => [
//            'feed' => [
//                'SiteTournament\\Library\\Robot::feed' => TRUE
//            ],
            'sitemap' => [
                'SiteStore\\Library\\Robot::sitemap' => TRUE
            ]
        ]
    ],
    'libForm' => [
        'forms' => [
            'site.store.claim' => [
                'transaction_id' => [
                    'type' => 'number',
                    'nolabel' => TRUE,
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
            ]
        ]
    ]
];
