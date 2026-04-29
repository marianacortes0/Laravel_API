<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ServeCommand as BaseServeCommand;

class ServeCommand extends BaseServeCommand
{
    public function handle()
    {
        $this->info('Reseteando base de datos...');
        $this->call('migrate:fresh', ['--seed' => true, '--force' => true]);

        return parent::handle();
    }
}
