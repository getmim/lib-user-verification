<?php

return [
    'LibUserVerification\\Model\\UserVerification' => [
        'fields' => [
            'id' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => TRUE,
                    'primary_key' => TRUE,
                    'auto_increment' => TRUE
                ],
                'index' => 1000
            ],
            'user' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => TRUE,
                    'null' => FALSE
                ],
                'index' => 2000
            ],
            'field' => [
                'type' => 'VARCHAR',
                'length' => 25,
                'attrs' => [
                    'null' => false
                ],
                'index' => 3000
            ],
            'value' => [
                'type' => 'VARCHAR',
                'length' => 200,
                'attrs' => [
                    'null' => false,
                    'unique' => true
                ],
                'index' => 4000
            ],
            'token' => [
                'type' => 'VARCHAR',
                'length' => 200,
                'attrs' => [
                    'null' => false,
                    'unique' => true 
                ],
                'index' => 5000
            ],
            'next' => [
                'type' => 'TEXT',
                'attrs' => [],
                'index' => 6000
            ],
            'validated' => [
                'type' => 'DATETIME',
                'attrs' => [
                    'null' => true 
                ],
                'index' => 7000
            ],
            'expires' => [
                'type' => 'DATETIME',
                'attrs' => [],
                'index' => 8000
            ],
            'updated' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP',
                    'update' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 10000
            ],
            'created' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 11000
            ]
        ],
        'indexes' => [
            'by_user_field' => [
                'fields' => [
                    'user' => [],
                    'field' => []
                ]
            ]
        ]
    ]
];