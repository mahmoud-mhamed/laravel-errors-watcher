<?php

namespace Mahmoudmhamed\LaravelErrorsWatcher;

use Mahmoudmhamed\LaravelErrorsWatcher\Commands\LaravelErrorsWatcherCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelErrorsWatcherServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name('laravel-errors-watcher')
            ->hasConfigFile();
    }
}
