<?php

namespace Mahmoudmhamed\LaravelErrorsWatcher;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Mahmoudmhamed\LaravelErrorsWatcher\Commands\LaravelErrorsWatcherCommand;

class LaravelErrorsWatcherServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-errors-watcher')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-errors-watcher_table')
            ->hasCommand(LaravelErrorsWatcherCommand::class);
    }
}
