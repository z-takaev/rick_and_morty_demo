<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function __invoke()
    {
        // $morty = Http::get('https://rickandmortyapi.com/api/character/7')->json();

        // Character::create([
        //     'name' => $morty['name'],
        //     'status' => $morty['status'],
        //     'gender' => $morty['gender'],
        //     'image' => $morty['image'],
        // ]);

        $character = Character::first();

        // $character->update(['translations' => [
        //     "en" => "Abradolf Lincler (en1)",
        //     "es" => "Abradolf Lincler (es2)",
        //     "fr" => "Abradolf Lincler (fr3)"
        // ]]);

        return view('home');
    }
}
