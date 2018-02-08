<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Views / Endpoints
    |--------------------------------------------------------------------------
    |
    | Set your login page, or login routes, here. If you provide a view,
    | that will be rendered. Otherwise, it will redirect to a route.
    |
     */

    'idp_login'     => '/Shibboleth.sso/Login',
    'idp_logout'    => '/Shibboleth.sso/Logout',
    'shibboleth_authenticated' => '/my/dashboard/',
    'shibboleth_unauthorized'  => '/',

    /*
    |--------------------------------------------------------------------------
    | Emulate an IdP
    |--------------------------------------------------------------------------
    |
    | In case you do not have access to your Shibboleth environment on
    | homestead or your own Vagrant box, you can emulate a Shibboleth
    | environment with the help of Shibalike.
    |
    | Do not use this in production for literally any reason.
    |
     */

    'emulate_idp'       => true,
    'emulate_idp_users' => array(
        'dmp' => array(
            'uid'         => 'dmp',
            'givenName'   => 'Example',
            'sn'          => 'User',
            'o'           => 'ACME University',
            'tubPersonKostenstelle'	=> '123456',
            'tubPersonOM' => '123456',
            'mail'        => 'dmp@example.org',
        ),
    ),

    /*
    |--------------------------------------------------------------------------
    | Server Variable Mapping
    |--------------------------------------------------------------------------
    |
    | Change these to the proper values for your IdP.
    |
     */

    'entitlement' => 'entitlement',

    'user' => [
        // fillable user model attribute => server variable
        'email'       => 'mail',
        'tub_om'  => 'tubPersonOM',
        'first_name'  => 'givenName',
        'last_name'   => 'sn',
        'institution_identifier' => 'tubPersonKostenstelle',
    ],

    /*
    |--------------------------------------------------------------------------
    | User Creation and Groups Settings
    |--------------------------------------------------------------------------
    |
    | Allows you to change if / how new users are added
    |
     */

    'add_new_users' => true, // Should new users be added automatically if they do not exist?

    /*
    |--------------------------------------------------------------------------
    | JWT Auth
    |--------------------------------------------------------------------------
    |
    | JWTs are for the front end to know it's logged in
    |
    | https://github.com/tymondesigns/jwt-auth
    | https://github.com/StudentAffairsUWM/Laravel-Shibboleth-Service-Provider/issues/24
    |
     */

    'jwtauth' => env('JWTAUTH', false),
);
