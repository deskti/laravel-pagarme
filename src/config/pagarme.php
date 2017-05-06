<?php

return [
    'mode' => env('PAGARME_MODE','test'), // test or production

    'credentials' => [
        'test' => [
            'key' => env('PAGARME_TEST_KEY', 'ABABABABABABABABABABABABABABABABABABABAB'),
            'token' => env('PAGARME_TEST_TOKEN', '01010101010101010101010101010101'),
        ],
        'production' => [
            'key' => env('PAGARME_PRODUCTION_KEY', 'ABABABABABABABABABABABABABABABABABABABAB'),
            'token' => env('PAGARME_PRODUCTION_TOKEN', '01010101010101010101010101010101'),
        ],
    ],

    'subscription' => [
        'body' => [
            'status' => [
                // Tem acesso
                'active' => [
                    'paid' => 'Paga',
                    'pending_payment' => 'Pendente',
                    'trialing' => 'Trial'
                ],
                // Não tem mais acesso
                'deactivate' => [
                    'unpaid' => 'Não Paga',
                    'cancel' => 'Cancelada',
                    'ended' => 'Finalizada'
                ],
            ]
        ],
        'active'=>true
    ],

    'plans' => [
        '54668' => [
            'title' => 'Plano Básico',
            'amount' => 29100,
            'description' => 'Descrição do Básico',
            'features' => [

            ],
            'roles_add' => ['role-consulting-basic'],
            'active' => true, // boolean,
            'tag' => 'plano_basico'
        ],
        '54664' => [
            'title' => 'Plano Avançado',
            'amount' => 44100,
            'description' => 'Descrição do Plano Avançado',
            'features' => [

            ],
            'roles_add' => ['role-consulting-basic','role-consulting-advanced'],
            'active' => true, // boolean,
            'tag' => 'plano_avancado'
        ],
        '54666' => [
            'title' => 'Plano Black',
            'amount' => 68100,
            'description' => 'Descrição do Plano Black',
            'features' => [

            ],
            'roles_add' => ['role-consulting-basic','role-consulting-advanced','role-consulting-black'],
            'active' => true, // boolean
            'tag' => 'plano_black'
        ]
    ],

    'email' => [
        'subject' => 'Financeiro Faixa Preta',
        'from' => 'contato@musculacaofaixapreta.com.br'
    ],

    'activecampaign' => [
        'tags' => [
            'plans' => [
                'cancel'=>'plano_cancelou',
                'unpaid'=>'plano_nao_pagou',
                'payment'=>'plano_renovou'
            ]
        ]
    ]

];