<?php

namespace App\MoonShine\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasTranslation
{
    protected bool $hasTranslate = false;

    abstract public function translationFields(): array;

    // public function prepareForValidation(): void
    // {
    //     $this->hasTranslate = request()?->boolean('translate');

    //     request()?->request->remove('translate');
    // }

    protected function needTranslate(): bool
    {
        return request()?->boolean('translate');
    }

    protected function translate(Model $model): Model
    {
        dd($this->translationFields());

        return $model;
    }
}
