<?php

namespace App\Jobs;

use App\Models\Character;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class CharacterJob implements ShouldQueue
{
    use Queueable;

    const API_URL = 'https://rickandmortyapi.com/api/character/';


    public function __construct(public int $id)
    {
        //
    }

    public function handle(): void
    {
        $character = Http::get(self::API_URL . $this->id)->json();

        Character::create([
            'name' => $character['name'],
            'status' => $character['status'],
            'gender' => $character['gender'],
            'image' => $character['image'],
        ]);
    }
}
