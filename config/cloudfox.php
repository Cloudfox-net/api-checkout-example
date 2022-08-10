<?php

return [
    'url_sandbox'    => env('CLOUDFOX_URL_SANDBOX', 'https://sandbox.cloudfox.net/api'),
    'url_production' => env('CLOUDFOX_URL_PRODUCTION', 'https://cloudfox.net/api'),
    'url_script'     => env('CLOUDFOX_URL_SCRIPT', 'url_gerado_pelo_sirius'),
    'environment'    => env('CLOUDFOX_ENVIRONMENT', 'sandbox'),
];
