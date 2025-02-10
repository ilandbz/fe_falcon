<?php

return [
    'default' => env('FILESYSTEM_DISK', 'local'),

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'visibility' => 'public',
            'url' => env('APP_URL').'/storage',
        ],
        'fotos' => [
            'driver' => 'local',
            'root' => storage_path('app/public/fotos'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],  
        'personas' => [
            'driver' => 'local',
            'root' => storage_path('app/public/fotos/personas'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],    
    ],

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],
];