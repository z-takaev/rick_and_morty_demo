<?php

declare(strict_types=1);

namespace App\MoonShine\Controllers;

use App\Models\Character;
use MoonShine\MoonShineRequest;
use MoonShine\Http\Controllers\MoonShineController;
use MoonShine\Http\Responses\MoonShineJsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CharacterController extends MoonShineController
{
    public function updateName(Character $character, MoonShineRequest $request): Response
    {
        $character->name = $request->get('name');
        $character->save();

        return $this->json('Успешно');
        // $this->toast('Успешно', 'success');

        // return back();
    }
}
