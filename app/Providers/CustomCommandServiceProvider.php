<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Console\Commands\CustomServeCommand;

class CustomCommandServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Override the default 'serve' command with our Windows-fixed version
        $this->app->extend('command.serve', function () {
            return new CustomServeCommand();
        });
    }
}
