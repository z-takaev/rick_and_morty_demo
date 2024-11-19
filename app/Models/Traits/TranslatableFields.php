<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait TranslatableFields
{
    abstract protected function translationFields(): array;

    protected static function bootTranslatableFields(): void
    {
        static::creating(function (Model $model) {
            foreach ($model->translationFields() as $fieldName) {
                $translations = [];

                foreach ($model->getLanguages() as $lang) {
                    $translations[$lang] = "{$model->{$fieldName}} ({$lang})";
                }

                $model->translations = $translations;
            }
        });

        static::updating(function (Model $model) {
            foreach ($model->translationFields() as $fieldName) {
                if (! $model->isDirty($fieldName)) {
                    continue;
                }

                $translations = [];

                foreach ($model->getLanguages() as $lang) {
                    $translations[$lang] = "{$model->{$fieldName}} ({$lang})";
                }

                $model->translations = $translations;
            }
        });
    }

    protected function getLanguages(): array
    {
        return ['en', 'es', 'fr'];
    }
}
