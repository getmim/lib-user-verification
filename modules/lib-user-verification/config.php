<?php

return [
    '__name' => 'lib-user-verification',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/lib-user-verification.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'https://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-user-verification' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'lib-user' => NULL
            ],
            [
                'lib-model' => NULL
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'LibUserVerification\\Model' => [
                'type' => 'file',
                'base' => 'modules/lib-user-verification/model'
            ],
            'LibUserVerification\\Library' => [
                'type' => 'file',
                'base' => 'modules/lib-user-verification/library'
            ]
        ],
        'files' => []
    ],
    'libFormatter' => [
        'formats' => [
            'user-verification' => [
                'id' => [
                    'type' => 'number'
                ],
                'user' => [
                    'type' => 'user'
                ],
                'field' => [
                    'type' => 'text'
                ],
                'value' => [
                    'type' => 'text'
                ],
                'token' => [
                    'type' => 'text'
                ],
                'next' => [
                    'type' => 'text'
                ],
                'validated' => [
                    'type' => 'date'
                ],
                'expires' => [
                    'type' => 'date'
                ],
                'updated' => [
                    'type' => 'date'
                ],
                'created' => [
                    'type' => 'date'
                ]
            ]
        ]
    ]
];