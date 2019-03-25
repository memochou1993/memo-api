<?php

return [

    'user' => [
        'name' => 'Administrator',
        'email' => 'admin@email.com',
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    ],

    'type' => [
        [ 'name' => 'text' ],

        [ 'name' => 'url' ],
        
        [ 'name' => 'image' ],
        
        [ 'name' => 'video' ],
        
        [ 'name' => 'audio' ],
        
        [ 'name' => 'pdf' ],
        
        [ 'name' => 'html' ],
        
        [ 'name' => 'markdown' ],
        
        [ 'name' => 'json' ],
        
        [ 'name' => 'coordinate' ],
    ],

];
