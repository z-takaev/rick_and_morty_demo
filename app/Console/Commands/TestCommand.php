<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    protected $signature = 'test:command';

    protected $description = 'Test command';

    public function handle()
    {
        info('test');

        $this->info('Запись в лог прошла успешно');
    }
}
