<?php

namespace App\Providers;

use App\Console\Commands\ServeCommand;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->extend('command.serve', function () {
            return new ServeCommand();
        });
    }

    public function boot(): void
    {
        //
    }
}
