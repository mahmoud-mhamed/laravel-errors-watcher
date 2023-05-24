<?php

namespace Mahmoudmhamed\LaravelErrorsWatcher;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\SlackAlerts\Facades\SlackAlert;
use Throwable;

class LaravelErrorsWatcher
{
    public static function sendSlackError(Throwable $exception): void
    {
        if (App::isLocal() && !config('errors-watcher.slack.log_error_in_local')) {
            return;
        }
        try {
            SlackAlert::blocks([
                ...self::getErrorHeader(),
                ...self::getErrorContent($exception),
                ...self::getTraceAuthAndUrlData(),
                ...self::getTraceBlock($exception),
            ]);

        } catch (\Throwable  $e) {
            Log::error($e);
        }
    }

    private static function getAuthData(): ?string
    {
        if (config('errors-watcher.slack.log_auth') && Auth::check()) {
            $user = Auth::check() ? Auth::user() : [];
            $user_id = data_get($user, 'id');
            $user_name = data_get($user, 'name');
            $user_email = data_get($user, 'email');

            return ">👹Auth Name: $user_name
>Auth Id: $user_id
>📧 Auth Email: $user_email";
        }

        return null;
    }

    private static function getUrlData(): ?string
    {
        if (config('errors-watcher.slack.log_url')) {
            $request = request();
            $url = url();
            return "
>URL: {$request->url()}
>IP: {$request->ip()}
>Previous Url: {$url->previous()}";
        }

        return null;
    }

    private static function getTraceBlock(Throwable $exception): array
    {
        if (!config('errors-watcher.slack.log_trace')) {
            return [];
        }
        $trace_string = str_replace("\n", '<', mb_substr($exception->getTraceAsString(), 0, 1000));
        $error_trace = "
>📌Trace : $trace_string";

        return [
            [
                'type' => 'divider',
            ],
            [
                'type' => 'section',
                'text' => [
                    'type' => 'mrkdwn',
                    'text' => $error_trace,
                ],
            ],
        ];

    }

    private static function getTraceAuthAndUrlData(): array
    {
        $auth_data = self::getAuthData();
        $url_data = self::getUrlData();
        if ($auth_data || $url_data) {
            $error_user_data = "
$url_data
$auth_data";
            return [
                [
                    'type' => 'divider',
                ],
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => $error_user_data,
                    ],
                ],
            ];
        }
        return [];
    }

    private static function getErrorHeader(): array
    {
        if (!config('errors-watcher.slack.log_header'))
            return [];
        if (config('errors-watcher.slack.header_title')) {
            $message = config('errors-watcher.slack.header_title');
        } else {
            $message = "🚨 " . env('APP_NAME') . " Exception Occurred!";
        }
        return [
            [
                'type' => 'header',
                'text' => [
                    'type' => 'plain_text',
                    'text' => $message,
                    'emoji' => true,
                ],
            ]
        ];

    }

    private static function getErrorContent($exception): array
    {
        if (!config('errors-watcher.slack.log_content'))
            return [];
        if (config('errors-watcher.slack.content')) {
            $message = config('errors-watcher.slack.content');
        } else {
            $message = "
>💩{$exception->getMessage()}
>📂`{$exception->getFile()} line {$exception->getLine()}`";
        }
        return [
            [
                'type' => 'section',
                'text' => [
                    'type' => 'mrkdwn',
                    'text' => $message,
                ],
            ]
        ];

    }
}
