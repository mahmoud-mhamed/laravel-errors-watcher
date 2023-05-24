<?php

// config for Mahmoudmhamed/LaravelErrorsWatcher
return [
    /*
     * The webhook URLs that we'll use to send a message to Slack.
     */
    'slack' => [
        'log_error_in_local' => env('SLACK_LOG_ERROR_IN_LOCAL', false),
        'log_header' => env('SLACK_LOG_HEADER', true),
        'header_title' => null, // null = 🚨 env('APP_NAME') Exception Occurred!
        'log_content' => env('SLACK_LOG_CONTENT', true),
        'content' => null,//null = send error message
        'log_url' => env('SLACK_LOG_URL', true),
        'log_auth' => env('SLACK_LOG_AUTH', true),
        'log_trace' => env('SLACK_LOG_TRACE', false),

    ],
];
