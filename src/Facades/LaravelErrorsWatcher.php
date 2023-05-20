<?php

namespace Mahmoudmhamed\LaravelErrorsWatcher\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mahmoudmhamed\LaravelErrorsWatcher\LaravelErrorsWatcher
 */
class LaravelErrorsWatcher extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Mahmoudmhamed\LaravelErrorsWatcher\LaravelErrorsWatcher::class;
    }
}
