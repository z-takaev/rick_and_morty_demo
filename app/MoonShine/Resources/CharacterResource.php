<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use MoonShine\Fields\ID;
use App\Models\Character;
use MoonShine\Fields\Text;
use MoonShine\Fields\Preview;
use MoonShine\Components\Modal;
use MoonShine\Decorations\Block;
use MoonShine\Resources\ModelResource;

use Illuminate\Database\Eloquent\Model;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\Contracts\MoonShineRenderable;
use MoonShine\Fields\Select;

class CharacterResource extends ModelResource
{
    protected string $model = Character::class;

    protected string $title = 'Персонажи';

    public function getActiveActions(): array
    {
        return ['view', 'delete'];
    }

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),

                Preview::make('Аватар', 'image')->image(),
                Text::make('Имя', 'name'),
                Text::make('Пол', 'gender'),
                Text::make('Статус', 'status'),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function pageComponents(): array
    {
        return [
            Modal::make(
                'Изменение статуса',
                fn() => form()
                    ->action(route('moonshine.characters.status.update', $this->item))
                    ->fields([
                        Select::make('Статус', 'status')
                            ->options([
                                'Alive' => 'Живой',
                                'Dead' => 'Мертвый',
                                'Unknown' => 'Неизвестно',
                            ])
                    ])
                    ->fill(['status' => $this->item->status])
            )
            ->name('status-modal'),
        ];
    }

    public function detailButtons(): array
    {
        return [
            ActionButton::make(
                label: 'Изменить статус',
                url: '#',
            )->toggleModal('status-modal')
        ];
    }
}
