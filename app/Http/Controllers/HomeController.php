<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;

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

        $characters = Character::all();

        $pdf = Pdf::loadView('pdf.characters', compact('characters'));
        $pdf->set_option('isRemoteEnabled', true);
        return $pdf->download('characters.pdf');

        // return view('home');
    }
}
