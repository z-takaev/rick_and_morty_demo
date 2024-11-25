<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use MoonShine\Fields\ID;
use App\Models\Character;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Fields\Preview;
use MoonShine\Decorations\Tab;
use MoonShine\Decorations\Tabs;
use MoonShine\Decorations\Block;

use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Textarea;

/**
 * @extends ModelResource<Character>
 */
class CharacterResource extends ModelResource
{
    protected string $model = Character::class;

    protected string $title = 'Персонажи';

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),

                Preview::make('Аватар', 'image')->image(),

                Text::make('Имя', 'name.ru')
                    ->onApply(function(Model $item, $value, Field $field) {
                        $translations = $item->name;
                        $translations['ru'] = $value;
                        $item->name = $translations;
                    }),

                Textarea::make('Описание', 'description.ru')
                    ->onApply(function(Model $item, $value, Field $field) {
                        $translations = $item->description;
                        $translations['ru'] = $value;
                        $item->description = $translations;
                    }),

                ...$this->translationFields()
            ]),
        ];
    }

    public function translationFields(): array
    {
        $langs = collect(['en', 'es', 'fr']);

        $translationFields = $langs->map(function ($lang) {
            return Tab::make($lang, [
                Text::make('Имя (' . $lang . ')', 'name.' . $lang)
                    ->onApply(function(Model $item, $value, Field $field) use ($lang) {
                        $column = explode('.', $field->column())[0];

                        $translations = $item->{$column};
                        $translations[$lang] = $value;
                        $item->{$column} = $translations;

                        return $item;
                    }),

                Textarea::make('Описание (' . $lang . ')', 'description.' . $lang)
                    ->onApply(function(Model $item, $value, Field $field) use ($lang) {
                        $column = explode('.', $field->column())[0];

                        $translations = $item->{$column};
                        $translations[$lang] = $value;
                        $item->{$column} = $translations;

                        return $item;
                    }),
            ]);
        });

        return [
            Tabs::make([
                ...$translationFields
            ]),

            Switcher::make('Автоматический перевод', 'is_translate')->default(false),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            // 'name' => ['required', 'string', 'min:3', 'max:100']
        ];
    }

    protected function beforeCreating(Model $item): Model
    {
        $this->translate();

        return $item;
    }

    protected function beforeUpdating(Model $item): Model
    {
        $this->translate();

        return $item;
    }

    private function translate(): void
    {
        $isTranslate = request()->boolean('is_translate');

        request()->request->remove('is_translate');

        if ($isTranslate) {
            request()->merge([
                'name' => [
                    "en" => "foo (en1)",
                    "es" => "foo (es2)",
                    "fr" => "foo (fr3)"
                ],
                'description' => [
                    "en" => "foo (en1)",
                    "es" => "foo (es2)",
                    "fr" => "foo (fr3)"
                ]
            ]);
        }
    }
}
