<?php

// config for Mahmoudmhamed/LaravelErrorsWatcher
return [
    /*
     * The webhook URLs that we'll use to send a message to Slack.
     */
    'slack'=>[
        'log_error_in_local'=>env('SLACK_LOG_ERROR_IN_LOCAL',false),
        'log_trace'=>env('SLACK_LOG_TRACE',false),
    ],
];
