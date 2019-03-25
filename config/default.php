<?php

return [

    'factories' => [
        'user' => [
            'name' => 'Administrator',
            'email' => 'admin@email.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ],

        'type' => [
            [ 'name' => 'text' ],

            [ 'name' => 'url' ],
            
            [ 'name' => 'file' ],
            
            [ 'name' => 'html' ],
            
            [ 'name' => 'markdown' ],
            
            [ 'name' => 'json' ],
            
            [ 'name' => 'coordinate' ],
        ],
    ],

    'seeds' => [
        'user' => [
            'number' => 5,
        ],

        'record' => [
            'number' => 100,
        ],

        'tag' => [
            'number' => 100,
        ],

        'records_tags' => [
            'number' => 100,
        ],
    ],

];
