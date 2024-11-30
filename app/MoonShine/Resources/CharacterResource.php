<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Closure;
use MoonShine\Fields\ID;
use App\Models\Character;
use MoonShine\Fields\Text;
use MoonShine\MoonShineUI;
use MoonShine\Enums\JsEvent;
use MoonShine\Fields\Preview;
use MoonShine\Fields\Checkbox;
use MoonShine\MoonShineRequest;
use MoonShine\Support\AlpineJs;
use MoonShine\Decorations\Block;
use MoonShine\QueryTags\QueryTag;
use MoonShine\Components\FormBuilder;
use MoonShine\Components\Layout\Flash;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use App\MoonShine\Traits\HasTranslation;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\ActionButtons\ActionButton;
use Illuminate\View\ComponentAttributeBag;
use MoonShine\Contracts\MoonShineRenderable;

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

                Checkbox::make('Перевести', 'translate')->onApply(function (Model $item) {
                    return $item;
                }),
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

    public function indexButtons(): array
    {
        return [
            ActionButton::make('')
                ->primary()
                ->icon('heroicons.shield-check')
                ->inModal(
                    title: 'Сохранить и обновить поле',
                    content: function($item) {
                        return FormBuilder::make(
                            action: route('moonshine.characters.name.update', $item->getKey()),
                            method: 'post'
                        )
                            ->fields([
                                Text::make('Имя', 'name'),
                            ])
                            ->fill([
                                'name' => $item->name
                            ])
                            ->name('change-name-form')
                            ->async(asyncEvents: [
                                AlpineJs::event(JsEvent::TABLE_UPDATED, 'index-table')
                            ]);
                    }
                ),

            ActionButton::make('Обновить таблицу')
                ->dispatchEvent(AlpineJs::event(JsEvent::TABLE_UPDATED, 'index-table'))
        ];
    }

    public function modifyListComponent(MoonShineRenderable $component): MoonShineRenderable
    {
        return parent::modifyListComponent($component)->async();
    }

    public function test(MoonShineRequest $request)
    {
        $character = $this->getItem();

        Flash::make(key: 'alert', type: 'success', withToast: true, removable: true);

        return back()->with('alert', $character->name);
    }


    public function formButtons(): array
    {
        return [
            ActionButton::make('Сохранить и обновить поле')
            ->method('saveAndUpdateField')
            ->primary()
            ->icon('heroicons.language')
        ];
    }

    public function saveAndUpdateField()
    {
        if ($this->isNowOnCreateForm()) {
            $this->getModel()->status = 'Dead';
            $this->getModel()->save();
        } else {
            $this->getItem()->status = 'Dead';
            $this->getItem()->save();
        }

        Flash::make(key: 'alert', type: 'success', withToast: true, removable: true);

        return back()->with('alert', 'Поле успешно сохранено и обновлено');
    }
}
