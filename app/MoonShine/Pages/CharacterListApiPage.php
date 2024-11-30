<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MoonShine\Pages\Page;
use MoonShine\Fields\Text;
use MoonShine\Fields\Preview;
use MoonShine\Components\Badge;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use MoonShine\Components\CardsBuilder;
use MoonShine\Components\MoonShineComponent;

class CharacterListApiPage extends Page
{
    /**
     * @return array<string, string>
     */
    public function breadcrumbs(): array
    {
        return [
            '#' => $this->title()
        ];
    }

    public function title(): string
    {
        return $this->title ?: 'CharacterListApiPage';
    }

    /**
     * @return list<MoonShineComponent>
     */
    public function components(): array
	{
		return [
            CardsBuilder::make(
                fields: [
                    // Preview::make('Аватар', 'image')->image(),
                    Text::make('Имя', 'name'),
                    Text::make('Статус', 'status'),
                ],
                items: $this->fetch(),
            )
                ->title(fn($item) => "Данные персонажа: {$item['name']}")
                ->thumbnail('image')
                ->url(fn($item) => $item['url'])
                ->columnSpan(2)
                ->overlay(),
        ];
	}

    protected function fetch(): Collection
    {
        return Http::get('https://rickandmortyapi.com/api/character')
            ->collect('results');
    }
}
