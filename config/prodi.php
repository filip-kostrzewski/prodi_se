<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Public company facts
    |--------------------------------------------------------------------------
    |
    | Name, owner, city, organisation number and the Märsta address are known.
    | Phone is not. Leave PRODI_PHONE empty until a real number exists.
    |
    */

    'name' => env('PRODI_NAME', 'Prodi'),

    'legal_name' => env('PRODI_LEGAL_NAME') ?: 'Prodi Digital AB',

    'owner' => env('PRODI_OWNER', 'Filip Kostrzewski'),

    'city' => env('PRODI_CITY', 'Märsta'),

    'org_number' => env('PRODI_ORG_NUMBER') ?: '559214-9370',

    'street_address' => env('PRODI_STREET_ADDRESS') ?: 'Tegelbrukets väg 41',

    'postal_code' => env('PRODI_POSTAL_CODE') ?: '195 59',

    /*
    | Empty until Filip provides a number. Nothing is shown on the site
    | while this is blank, and no number is invented here.
    |
    */

    'phone' => env('PRODI_PHONE'),

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
