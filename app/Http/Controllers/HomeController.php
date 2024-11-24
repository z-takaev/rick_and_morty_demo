<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function __invoke()
    {
        // $morty = Http::get('https://rickandmortyapi.com/api/character/4')->json();

        // Character::create([
        //     'name' => $morty['name'],
        //     'status' => $morty['status'],
        //     'gender' => $morty['gender'],
        //     'image' => $morty['image'],
        // ]);

        return view('home');
    }
}
