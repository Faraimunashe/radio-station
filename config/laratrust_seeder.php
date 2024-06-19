<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'admin' => [
            'users' => 'c,r,u,d',
            'payments' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'archivist' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'ep' => [
            'profile' => 'r,u',
        ],
        'presenter' => [
            'profile' => 'r,u',
        ],
        'engineer' => [
            'profile' => 'r,u',
        ],
        'audience' => [
            'profile' => 'r,u',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
