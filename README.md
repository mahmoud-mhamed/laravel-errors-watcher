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
php artisan vendor:publish --tag="laravel-errors-watcher-config"
```
in env file add
LOG_SLACK_WEBHOOK_URL="https://hooks.slack.com/services/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"


## Credits

- [mahmoud-mhamed](https://github.com/mahmoud-mhamed)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
