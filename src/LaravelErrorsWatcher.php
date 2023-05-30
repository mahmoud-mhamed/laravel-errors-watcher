<?php

namespace Mahmoudmhamed\LaravelErrorsWatcher;

use App\Models\User;
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
            Log::channel('slack')->error(self::getErrorHeader() . self::getErrorContent($exception) . self::getTraceAuthAndUrlData() . self::getTraceBlock($exception));
        } catch (\Throwable  $e) {
            Log::error($e);
        }
    }

    private static function getAuthData(): ?string
    {
        if (config('errors-watcher.slack.log_auth') && Auth::check()) {
//        if (true) {
            $user = Auth::check() ? Auth::user() : [];
            $user=[
                'id'=>33,
                'name'=>'assd',
            ];
            $user_id = data_get($user, 'id');
            $user_name = data_get($user, 'name');
            $user_email = data_get($user, 'email');

            return "👹Auth Name: $user_name
Auth Id: $user_id
📧 Auth Email: $user_email";
        }

        return null;
    }

    private static function getUrlData(): ?string
    {
        if (config('errors-watcher.slack.log_url')) {
            $request = request();
            $url = url();

            return "
URL: {$request->url()}
IP: {$request->ip()}
Previous Url: {$url->previous()}";
        }

        return null;
    }

    private static function getTraceBlock(Throwable $exception): ?string
    {
        if (!config('errors-watcher.slack.log_trace')) {
            return null;
        }
        $trace_string =  mb_substr($exception->getTraceAsString(), 0, 1000);
        $error_trace = "
📌Trace : $trace_string";

        return self::getLineString().$error_trace;
    }

    private static function getTraceAuthAndUrlData(): ?string
    {
        $auth_data = self::getAuthData();
        $url_data = self::getUrlData();
        $message=null;
        if ($url_data) {
            $message.= self::getLineString() . $url_data;
        }
        if ($auth_data) {
            $message.= self::getLineString() .$auth_data;
        }
        return $message;
    }

    private static function getErrorHeader(): ?string
    {
        if (!config('errors-watcher.slack.log_header')) {
            return null;
        }
        if (config('errors-watcher.slack.header_title')) {
            return config('errors-watcher.slack.header_title');
        }

        return '🚨 ' . env('APP_NAME') . ' Exception Occurred!';
    }

    private static function getErrorContent($exception): ?string
    {
        if (!config('errors-watcher.slack.log_content')) {
            return null;
        }
        if (config('errors-watcher.slack.content')) {
            $message = config('errors-watcher.slack.content');
        } else {
            $message = "
💩{$exception->getMessage()}
📂{$exception->getFile()} line {$exception->getLine()}";
        }

        return self::getLineString() . $message;

    }

    private static function getLineString()
    {
        return "
───────────── ";
    }
}
