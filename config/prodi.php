<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Public company facts
    |--------------------------------------------------------------------------
    |
    | Name, owner and city are known. Organisation number, street address and
    | postal code are not. Leave those empty until the owner supplies them.
    | Do not invent legal details.
    |
    */

    'name' => env('PRODI_NAME', 'Prodi'),

    'owner' => env('PRODI_OWNER', 'Filip Kostrzewski'),

    'city' => env('PRODI_CITY', 'Märsta'),

    'org_number' => env('PRODI_ORG_NUMBER'),

    'street_address' => env('PRODI_STREET_ADDRESS'),

    'postal_code' => env('PRODI_POSTAL_CODE'),

    /*
    |--------------------------------------------------------------------------
    | Inbox for quote requests
    |--------------------------------------------------------------------------
    |
    | Placeholder until a real mailbox exists. Submissions are still stored
    | and, with MAIL_MAILER=log, written to the Laravel log. Addresses on
    | example.com / example.org / example.net are not shown on the public site.
    |
    */

    'contact_email' => env('PRODI_CONTACT_EMAIL', 'you@example.com'),

];
