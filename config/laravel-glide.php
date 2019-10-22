<?php

return [

    /*
    * The driver that will be used to create images. Can be set to gd or imagick.
    */
    'driver' => 'gd',

    /*
     * Glide will search for images in this directory
     *
     */
    'source' => [
        //'path' => storage_path('images'),
        //'path' => public_path('images'),
        'path' => base_path('public'),
    ],

    /*
     * The directory Glide will use to store it's cache
     * A .gitignore file will be automatically placed in this directory
     * so you don't accidentally end up committing these images
     *
     */
    'cache' => [
        'path' => storage_path('glide/cache'),
        //'path' => public_path('images/cache'),
    ],

    /*
     * URLs to generated images will start with this string
     *
     */
    //'baseURL' => 'img',
    'baseURL' => 'uploads',

    /*
     * The maximum allowed total image size in pixels
     */
    'maxSize' => 2000 * 2000,

    /*
     * Glide has a feature to sign each generated URL with
     * a key to avoid the visitors of your site to alter the URL
     * manually
     */
    //'useSecureURLs' => true,
];
