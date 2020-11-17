<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',

    'thumbnail_informations' =>
        ['width' => 480, 'height' => 270],

    'thumbnail_services' =>
        ['width'  => 270, 'height' => 180],

    'thumbnail_category' =>
        ['width'  => 370, 'height' => 250],

    'gallery_services' =>
        ['width'  => 1000, 'height' => 700],

    'gallery_gallery' =>
        ['width'  => 1200, 'height' => 900]

];
