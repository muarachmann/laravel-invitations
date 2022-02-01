<?php

return [

    'invitation_model' => MuaRachmann\Invitations\Models\Invitation::class,

    /*
    |--------------------------------------------------------------------------
    | Invitation Expiration Time
    |--------------------------------------------------------------------------
    |
    | Default Expiry time in Hours from current time. (48 Hours default).
    |
    */

    'expires' => 48,

    /*
    |--------------------------------------------------------------------------
    | Database settings
    |--------------------------------------------------------------------------
    |
    | Define the settings for the database driver here.
    |
    */
    'database' => [

        'connection' => '',

        'invitations_table' => 'invitations',

    ],
];
