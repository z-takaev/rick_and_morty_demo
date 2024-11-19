<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CreateQueueCharactersCommand extends Command
{
    protected $signature = 'characters:queue';

    protected $description = 'Создание задач на создание персонажей';

    public function handle()
    {
        $info = Http::get('https://rickandmortyapi.com/api/character')->json('info');

        for ($i = 1; $i <= $info['count']; $i++) {

        }
    }
}
