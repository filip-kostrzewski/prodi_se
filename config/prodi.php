<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Public company facts
    |--------------------------------------------------------------------------
    |
    | Name, owner, city and organisation number are known. Prodi is an AB.
    | Street address and postal code are not. Leave those empty until the
    | owner supplies them. Do not invent a street or postal code.
    |
    */

    'name' => env('PRODI_NAME', 'Prodi'),

    'owner' => env('PRODI_OWNER', 'Filip Kostrzewski'),

    'city' => env('PRODI_CITY', 'Märsta'),

    'org_number' => env('PRODI_ORG_NUMBER') ?: '559214-9370',

    'street_address' => env('PRODI_STREET_ADDRESS'),

    'postal_code' => env('PRODI_POSTAL_CODE'),

    /*
    |--------------------------------------------------------------------------
    | Inbox for quote requests
    |--------------------------------------------------------------------------
    |
    | Quote requests are emailed here. Addresses on example.com, example.org
    | and example.net are not shown on the public site.
    |
    */

    'contact_email' => env('PRODI_CONTACT_EMAIL') ?: 'filip@prodi.se',

];
