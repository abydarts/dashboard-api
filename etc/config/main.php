<?php

return [
    'name' => 'Nusapay',
    'version' => '0.0.1',
    'host' => 'ifel-project-news.test',
    'timezone' => 'Asia/Jakarta',
    'install' => '2021-02-25 14:16:33',
    'secure' => FALSE,
    'shared' => '~',
    '__gitignore' => [
        'modules/*' => NULL,
        '!modules/.gitkeep' => NULL
    ],
    'app' => [
        'api' => [
            'host' => 'http://dbscore.test',
            'client_id' => '1',
            'client_secret' => 'AramcNdXRR5PGmU',
        ],
        'games' => [
            'host' => 'https://staireight.com',
            'website_id' => '1111',
        ]
    ],
    'libModel' => [
        'connections' => [
            'default' => [
                'driver' => 'mysql',
                'configs' => [
                    'main' => [
                        'host' => '127.0.0.1',
                        'user' => 'root',
                        'dbname' => 'mim_nusapay',
                        'passwd' => '8473',
                        'port' => '3306'
                    ]
                ]
            ]
        ]
    ],
    'libUpload' => [
        'base' => [
            'local' => 'media',
            'host' => 'http://ifel-project-news.test/media/'
        ]
    ],
    'libMailer' => [
        'SMTP' => TRUE,
        'Host' => 'smtp.gmail.com',
        'SMTPAuth' => TRUE,
        'Username' => 'ifel',
        'Password' => 'ifel',
        'SMTPSecure' => 'tls',
        'Port' => 587,
        'FromEmail' => 'ifel@no_reply.com',
        'FromName' => 'ifel'
    ],
    'libRecaptcha' => [
        'sitekey' => 'q',
        'sitesecret' => 'q'
    ]
];