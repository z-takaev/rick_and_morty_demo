<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Closure;
use MoonShine\Fields\ID;
use App\Models\Character;
use MoonShine\Fields\Text;
use MoonShine\Fields\Preview;
use MoonShine\Fields\Checkbox;
use MoonShine\Decorations\Block;
use MoonShine\QueryTags\QueryTag;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use App\MoonShine\Traits\HasTranslation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\ComponentAttributeBag;

class CharacterResource extends ModelResource
{
    use HasTranslation;

    protected string $model = Character::class;

    protected string $title = 'Персонажи';

    protected bool $columnSelection = true;

    protected bool $stickyTable = true;

    public function getActiveActions(): array
    {
        return ['view', 'delete', 'update'];
    }

    public function translationFields(): array
    {
        return ['name', 'gender', 'status'];
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

                Checkbox::make('Перевести', 'translate'),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function trAttributes(): Closure
    {
        return function (
            Model $item,
            int $row,
            ComponentAttributeBag $attr
        ): ComponentAttributeBag {

            $class = match ($item->status) {
                'Dead' => 'bgc-red',
                'Alive' => 'bgc-green',
                default => 'bgc-gray',
            };

            $attr->setAttributes([
                'class' => $class
            ]);

            return $attr;
        };
    }

    public function queryTags(): array
    {
        return [
            QueryTag::make(
                'Живые персонажи',
                fn(Builder $query) => $query->where('status', 'Alive')
            )
        ];
    }

    protected function beforeUpdating(Model $item): Model
    {
        if ($this->needTranslate()) {
            return $this->translate($item);
        }

        return $item;
    }

}
