<?php

namespace Mahmoudmhamed\LaravelErrorsWatcher;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelErrorsWatcherServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/errors-watcher.php' => config_path('errors-watcher.php'),
        ], 'laravel-errors-watcher-config');
    }

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
