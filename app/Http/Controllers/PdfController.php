<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class PdfController extends Controller
{
    public function characters(): Response
    {
        $characters = Character::all();

        $pdf = Pdf::loadView('pdf.characters', compact('characters'));
        $pdf->set_option('isRemoteEnabled', true);

        return $pdf->download('characters.pdf');
    }
}
