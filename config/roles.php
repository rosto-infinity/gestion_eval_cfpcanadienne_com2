<?php

return [
    'default' => env('APP_DEFAULT_ROLE', 'user'),
    'superadmin' => env('APP_SUPERADMIN_ROLE', 'superadmin'),
    
    'permissions' => [
        'superadmin' => ['*'],
        'admin'      => ['manage_users', 'view_dashboard', 'edit_content'],
        'manager'    => ['view_dashboard', 'edit_content'],
        'user'       => ['view_content'],
    ],
];