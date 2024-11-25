<?php

declare(strict_types=1);

namespace App\MoonShine\Controllers;

use App\Models\Character;
use MoonShine\MoonShineRequest;
use MoonShine\Http\Controllers\MoonShineController;
use Symfony\Component\HttpFoundation\Response;

final class CharacterController extends MoonShineController
{
    public function __invoke(MoonShineRequest $request, Character $character): Response
    {
        $character->update(['status' => $request->input('status')]);

        $this->toast('Статус обновлен');

        return back();
    }
}
