<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Kraken API Credentials
    |--------------------------------------------------------------------------
    |
    | Your Kraken API Credentials. If you don't know this information, find it here:
    | "https://kraken.io/account/api-credentials"
    |
    */
    'api_key'    => env('KRAKENIO_API_KEY'),
    'api_secret' => env('KRAKENIO_API_SECRET'),

    'sizes' => [
        [
            'id' => 'original',
            'strategy' => 'none',
            'lossy' => false
        ],
        [
            'id' => 'lossy',
            'strategy' => 'none',
            'lossy' => true,
            'quality' => 90
        ],
        [
            'id' => 'thumbnail',
            'width' => 350,
            'strategy' => 'landscape',
        ],
    ]
];