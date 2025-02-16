<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Application Locale
    |--------------------------------------------------------------------------
    | This defines the default locale for the application.
    */
    'default_locale' => env('APP_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Enable Exception Handling
    |--------------------------------------------------------------------------
    | If set to true, the package will apply global exception handling
    | using the ExceptionHandler trait.
    */
    'enable_exception_handling' => true,

    /*
    |--------------------------------------------------------------------------
    | API Versioning
    |--------------------------------------------------------------------------
    | Determines if API versioning should be enabled.
    | If true, versioning traits and routes will be applied.
    */
    'enable_api_versioning' => true,

    /*
    |--------------------------------------------------------------------------
    | Middleware Configuration
    |--------------------------------------------------------------------------
    | Determines if the localization middleware should be applied.
    */
    'enable_localization_middleware' => true,
];