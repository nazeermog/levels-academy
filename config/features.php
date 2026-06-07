<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Feature Flags
    |--------------------------------------------------------------------------
    |
    | Toggle whole features on/off without deleting any code. Set the flag to
    | true (or the matching .env value) to bring a feature back.
    |
    */

    // Organizations / multi-tenant (subdomain) features. Currently disabled:
    // the organization menu items are hidden and admins behave globally.
    // Nothing has been deleted — flip this to true to restore the org UI.
    'organizations' => env('FEATURES_ORGANIZATIONS', false),

];
