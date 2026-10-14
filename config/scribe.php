<?php

return [

    /*
     * Scribe was installed but its API docs were never generated for this
     * project (the generated openapi.yaml / collection.json and the package
     * view assets are not present). Registering the /docs routes therefore
     * results in 500 errors, so they are disabled here.
     *
     * To enable API docs, publish and fill in a full Scribe config and run
     * `php artisan scribe:generate`.
     */
    'type' => 'laravel',

    'laravel' => [
        'add_routes' => false,
    ],

];
