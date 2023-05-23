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
        if (App::isLocal() && !config('errors-watcher.slack.log_error_in_local'))
            return;
        try {
            $request = request();
            $url = url();
            $project_name = env('APP_NAME');
            $auth_data = self::getAuthData();
            $error_message = "
>💩{$exception->getMessage()}
>📂 `{$exception->getFile()} line {$exception->getLine()}`";
            $error_user_data = "
>URL: {$request->url()}
>IP: {$request->ip()}
>Previous Url: {$url->previous()}
$auth_data";

            SlackAlert::blocks([
                [
                    "type" => "header",
                    "text" => [
                        "type" => "plain_text",
                        "text" => "🚨 $project_name Exception Occurred!",
                        "emoji" => true
                    ]
                ],
                [
                    "type" => "section",
                    "text" => [
                        "type" => "mrkdwn",
                        "text" => $error_message
                    ]
                ],
                [
                    "type" => "divider"
                ],
                [
                    "type" => "section",
                    "text" => [
                        "type" => "mrkdwn",
                        "text" => $error_user_data
                    ]
                ],
                ...self::getTraceBlock($exception),
            ]);

        } catch (\Throwable  $e) {
            Log::error($e);
        }
    }

    private static function getAuthData(): ?string
    {
        if (Auth::check()) {
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

    private static function getTraceBlock(Throwable $exception): array
    {
        if(!config('errors-watcher.slack.log_trace')){
            return [];
        }
        $trace_string = str_replace("\n", '<', mb_substr($exception->getTraceAsString(), 0, 1000));
        $error_trace = "
>📌Trace : $trace_string";
        return [
            [
                "type" => "divider"
            ],
            [
                "type" => "section",
                "text" => [
                    "type" => "mrkdwn",
                    "text" => $error_trace
                ]
            ]
        ];

    }
}
