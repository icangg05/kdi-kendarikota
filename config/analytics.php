<?php

return [

    /*
     * The property id of which you want to display data.
     */
    // 'property_id' => env('ANALYTICS_PROPERTY_ID'),
    'property_id' => '490558835',


    /*
     * Path to the client secret json file. Take a look at the README of this package
     * to learn how to get this file. You can also pass the credentials as an array
     * instead of a file path.
     */
    'service_account_credentials_json' => storage_path('app/kendarikota-462713-79720e0d3bac.json'),
    // kendarikota-analytics@kendarikota-462713.iam.gserviceaccount.com

    /*
     * The amount of minutes the Google API responses will be cached.
     * If you set this to zero, the responses won't be cached at all.
     */
    'cache_lifetime_in_minutes' => 60 * 24,

    /*
     * Here you may configure the "store" that the underlying Google_Client will
     * use to store it's data.  You may also add extra parameters that will
     * be passed on setCacheConfig (see docs for google-api-php-client).
     *
     * Optional parameters: "lifetime", "prefix"
     */
    'cache' => [
        'store' => 'file',
    ],
];
