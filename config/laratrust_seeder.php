<?php

return [
    'role_structure' => [
        'superadministrator' => [
            'charts' => 'r',
            'customers' => 'c,r,u,d',
            'payment-methods' => 'c,r,u,d',
            'orders' => 'c,r,u,d',
            'products' => 'c,r,u,d',
            'categories' => 'c,r,u,d',
            'tags' => 'c,r,u,d',
            'user' => 'c,r,u,d',
        ],
        'administrator' => [
            'customers' => 'c,r,u',
            'payment-methods' => 'c,r,u',
            'orders' => 'r,u',
            'products' => 'c,r,u',
            'categories' => 'c,r,u',
            'tags' => 'c,r,u',
        ],
        'normaluser' => [
            'customers' => 'r',
            'payment-methods' => 'r',
            'orders' => 'r',
            'products' => 'r',
            'categories' => 'r',
            'tags' => 'r',
        ],
    ],
    'permission_structure' => [

    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
