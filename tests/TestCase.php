<?php

namespace Mahmoudmhamed\LaravelErrorsWatcher\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mahmoudmhamed\LaravelErrorsWatcher\LaravelErrorsWatcherServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Mahmoudmhamed\\LaravelErrorsWatcher\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelErrorsWatcherServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-errors-watcher_table.php.stub';
        $migration->up();
        */
    }
}
