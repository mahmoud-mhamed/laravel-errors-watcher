<?php

namespace Mahmoudmhamed\LaravelErrorsWatcher\Commands;

use Illuminate\Console\Command;

class LaravelErrorsWatcherCommand extends Command
{
    public $signature = 'laravel-errors-watcher';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
