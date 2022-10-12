<?php

return [
    '__name' => 'site-meta',
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
            'SitePayment\\Controller' => [
                'type' => 'file',
                'base' => ['modules/site-payment/controller','app/site-payment/controller']
            ],
            'SitePayment\\Library' => [
                'type' => 'file',
                'base' => 'modules/site-payment/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'site' => [
            'sitePaymentShowStatus' => [
                'path' => [
                    'value' => '/payment-success',
                ],
                'method' => 'GET',
                'handler' => 'SitePayment\\Controller\\Payment::showStatus'
            ],
            'sitePaymentHistory' => [
                'path' => [
                    'value' => '/payment-history',
                ],
                'method' => 'GET',
                'handler' => 'SitePayment\\Controller\\Payment::history'
            ],
            'sitePointHistory' => [
                'path' => [
                    'value' => '/point-history',
                ],
                'method' => 'GET',
                'handler' => 'SitePayment\\Controller\\Payment::pointHistory'
            ],
            'sitePaymentDetail' => [
                'path' => [
                    'value' => '/payment-transaction/(:id)',
                ],
                'method' => 'GET',
                'handler' => 'SitePayment\\Controller\\Payment::historyDetail'
            ],
            'sitePaymentTopup' => [
                'path' => [
                    'value' => '/top-up',
                ],
                'method' => 'GET|POST',
                'handler' => 'SitePayment\\Controller\\Payment::topup'
            ],
            'sitePaymentTopupCoin' => [
                'path' => [
                    'value' => '/top-up-coin',
                ],
                'method' => 'POST',
                'handler' => 'SitePayment\\Controller\\Payment::topupCoin'
            ],
        ]
    ],
    'libForm' => [
        'forms' => [
            'site.payment.confirmation' => [
                'confirmation' => [
                    'type' => 'number',
                    'nolabel' => TRUE,
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
            ],
            'site.payment.quiz' => [
                'match_id' => [
                    'type' => 'number',
                    'nolabel' => TRUE,
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'is_quiz' => [
                    'nolabel' => TRUE,
                    'type' => 'number',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE
                    ]
                ]
            ],
            'site.payment.topup.coin' => [
                'coin' => [
                    'type' => 'number',
                    'nolabel' => TRUE,
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
            ],
            'site.payment.topup' => [
                'coin' => [
                    'type' => 'number',
                    'nolabel' => TRUE,
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE,
                    ]
                ],
                'channel' => [
                    'nolabel' => TRUE,
                    'type' => 'text',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE
                    ]
                ]
            ],
        ]
    ]
];
