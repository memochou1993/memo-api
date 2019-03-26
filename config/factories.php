<?php

return [

    'user' => [
        'name' => 'Administrator',
        'email' => 'admin@email.com',
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
    ],

    'type' => [
        [
            'name' => 'text'
        ],

        [
            'name' => 'url'
        ],
        
        [
            'name' => 'image'
        ],
        
        [
            'name' => 'video'
        ],
        
        [
            'name' => 'audio'
        ],
        
        [
            'name' => 'pdf'
        ],
        
        [
            'name' => 'html'
        ],
        
        [
            'name' => 'markdown'
        ],
        
        [
            'name' => 'json'
        ],
        
        [
            'name' => 'coordinate'
        ],
    ],

];
