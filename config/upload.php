<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Upload Stuff
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'template_logo' => [
        'supported' => 'image',
        'formats' => [
            'header' => [
                'x' => null,
                'y' => 111,
            ],
            'export' => [
                'x' => 400,
                'y' => null,
            ],
        ],
    ],

];
