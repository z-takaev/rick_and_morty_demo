<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $morty = Http::get('https://rickandmortyapi.com/api/character/3')->json();

        Character::create([
            'name' => $morty['name'],
            'status' => $morty['status'],
            'gender' => $morty['gender'],
            'image' => $morty['image'],
        ]);

        // $morty = Character::firstOrFail();
        // $morty->update(['name' => 'Morty Smith']);

        return view('home');
    }
}
