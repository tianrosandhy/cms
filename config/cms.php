<?php
return [
    'admin' => [
        'prefix' => env('ADMIN_PREFIX', 'p4n3lb04rd'),
        'auth_guard_name' => 'admin',
        'assets' => 'core',
        'crud_confirmation_on_save' => false,
        'crud_confirmation_on_back' => true,
    ],
    'max_filesize' => 20,
    'config' => [
        'force_https' => env('FORCE_HTTPS'),
        'google_map_api_key' => env('GOOGLE_MAP_API_KEY'),
        'fcm_server_key' => env('FCM_SERVER_KEY'),
        'fcm_sender_id' => env('FCM_SENDER_ID'),
        'fcm_api_key' => env('FCM_API_KEY'),
        'fcm_project_id' => env('FCM_PROJECT_ID'),
        'fcm_app_id' => env('FCM_APP_ID'),
    ],
    'cache_key' => [
        'setting' => 'APP-CMS-ALLSETTING',
        'language' => 'APP-CMS-ALLLANGUAGE',
        'role' => 'APP-CMS-ALLROLE',
    ],
];