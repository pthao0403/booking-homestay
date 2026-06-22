<?php

return [

    'default_auth_profile' => env('GOOGLE_CALENDAR_AUTH_PROFILE', 'service_account'),

    'auth_profiles' => [

        /*
         * Authenticate using a service account.
         */
        'service_account' => [
            /*
             * Path to the json file containing the credentials.
             */
            'credentials_json' => env('GOOGLE_CALENDAR_CREDENTIALS'),
        ],

        /*
         * Authenticate with actual oauth.
         */
        'oauth' => [
            /*
             * Path to the json file containing the oauth2 credentials.
             */
            'credentials_json' => env('GOOGLE_CALENDAR_OAUTH_CREDENTIALS'),

            /*
             * Path to the json file containing the oauth2 token.
             */
            'token_json' => env('GOOGLE_CALENDAR_OAUTH_TOKEN'),
        ],
    ],

    /*
     *  The id of the Google Calendar that will be used by default.
     */
    'calendar_id' => env('GOOGLE_CALENDAR_ID'),

    /*
     *  The direction where calendar events are ordered. Possible values: 'asc', 'desc'
     */
    'sort_direction' => env('GOOGLE_CALENDAR_SORT_DIRECTION', 'asc'),

];
