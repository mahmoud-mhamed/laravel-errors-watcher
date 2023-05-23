# Quickly send error message to Slack Or mail


[![Latest Version on Packagist](https://img.shields.io/packagist/v/mahmoud-mhamed/laravel-errors-watcher.svg?style=flat-square)](https://packagist.org/packages/mahmoud-mhamed/laravel-errors-watcher)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mahmoud-mhamed/laravel-errors-watcher/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mahmoud-mhamed/laravel-errors-watcher/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/mahmoud-mhamed/laravel-errors-watcher/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/mahmoud-mhamed/laravel-errors-watcher/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mahmoud-mhamed/laravel-errors-watcher.svg?style=flat-square)](https://packagist.org/packages/mahmoud-mhamed/laravel-errors-watcher)

This package can quickly send alerts to Slack. You can use this to notify yourself of any noteworthy events happening in your app.

in App\Exceptions\Handler.php in register function add 
```php
use Mahmoudmhamed\LaravelErrorsWatcher\LaravelErrorsWatcher;

$this->reportable(function (Throwable $e) {
    LaravelErrorsWatcher::sendSlackErrror($e);
});
```


```php
use Spatie\SlackAlerts\Facades\SlackAlert;

SlackAlert::message("You have a new subscriber to the {$newsletter->name} newsletter!");
```

## Depandences
 [spatie/laravel-slack-alerts](https://github.com/spatie/laravel-slack-alerts).



## Installation

You can install the package via composer:

```bash
composer require mahmoud-mhamed/laravel-errors-watcher
```

You can set a `SLACK_ALERT_WEBHOOK` env variable containing a valid Slack webhook URL. You can learn how to get a webhook URL [in the Slack API docs](https://api.slack.com/messaging/webhooks).


Alternatively, you can publish the config file with:

```bash
php artisan vendor:publish --tag="slack-alerts-config"
php artisan vendor:publish --tag="laravel-errors-watcher-config"
```
This is the contents of the published config file:

```php
return [
    /*
     * The webhook URLs that we'll use to send a message to Slack.
     */
    'webhook_urls' => [
        'default' => env('SLACK_ALERT_WEBHOOK'),
    ],

    /*
     * This job will send the message to Slack. You can extend this
     * job to set timeouts, retries, etc...
     */
    'job' => Spatie\SlackAlerts\Jobs\SendToSlackChannelJob::class,
];

## Usage

To send a message to Slack, simply call `SlackAlert::message()` and pass it any message you want.

```php
SlackAlert::message("You have a new subscriber to the {$newsletter->name} newsletter!");
```

## Sending blocks

Slack supports sending rich formatting using their [Block Kit](https://api.slack.com/block-kit) API, you can send a set of blocks using the `blocks()` method:

```php
SlackAlert::blocks([
    [
        "type" => "section",
        "text" => [
        "type" => "mrkdwn",
            "text" => "You have a new subscriber to the {$newsletter->name} newsletter!"
        ]
    ]
]);
```

## Using multiple webhooks

You can also use an alternative webhook, by specify extra ones in the config file.

```php
// in config/slack-alerts.php

'webhook_urls' => [
    'default' => 'https://hooks.slack.com/services/XXXXXX',
    'marketing' => 'https://hooks.slack.com/services/YYYYYY',
],
```

The webhook to be used can be chosen using the `to` function.

```php
use Spatie\SlackAlerts\Facades\SlackAlert;

SlackAlert::to('marketing')->message("You have a new subscriber to the {$newsletter->name} newsletter!");
```

### Using a custom webhooks

The `to` function also supports custom webhook urls.

```php
use Spatie\SlackAlerts\Facades\SlackAlert;

SlackAlert::to('https://custom-url.com')->message("You have a new subscriber to the {$newsletter->name} newsletter!");
```

## Formatting

### Markdown
You can format your messages with Slack's markup. Learn how [in the Slack API docs](https://slack.com/help/articles/202288908-Format-your-messages).

```php
use Spatie\SlackAlerts\Facades\SlackAlert;

SlackAlert::message("A message *with some bold statements* and _some italicized text_.");
```

Links are formatted differently in Slack than the classic markdown structure.

```php
SlackAlert::message("<https://spatie.be|This is a link to our homepage>");
```

### Emoji's

You can use the same emoji codes as in Slack. This means custom emoji's are also supported.
```php
use Spatie\SlackAlerts\Facades\SlackAlert;

SlackAlert::message(":smile: :custom-code:");

```

### Mentioning

You can use mentions to notify users and groups. Learn how [in the Slack API docs](https://api.slack.com/reference/surfaces/formatting#mentioning-users).
```php
use Spatie\SlackAlerts\Facades\SlackAlert;

SlackAlert::message("A message that notifies <@username> and everyone else who is <!here>")

```

### Usage in tests

In your tests, you can make use of the `SlackAlert` facade to assert whether your code sent an alert to Slack.

```php
// in a test

use Spatie\SlackAlerts\Facades\SlackAlert;

it('will send an alert to Slack', function() {

    SlackAlert::shouldReceive('message')->once();
    
    // execute code here that does send a message to Slack
});
```

Of course, you can also assert that a message wasn't sent to Slack.

```php
// in a test

use Spatie\SlackAlerts\Facades\SlackAlert;

it('will not send an alert to Slack', function() {
    SlackAlert::shouldReceive('message')->never();
    
    // execute code here that doesn't send a message to Slack
});
```

## Credits

- [mahmoud-mhamed](https://github.com/mahmoud-mhamed)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
