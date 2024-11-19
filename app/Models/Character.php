<?php

namespace App\Models;

use App\Models\Traits\TranslatableFields;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use TranslatableFields;

    protected $fillable = [
        'name', 'status',
        'gender', 'image',
        'translations',
    ];

    protected $casts = [
        'translations' => 'array',
    ];

    protected function translationFields(): array
    {
        return ['name'];
    }

    protected static function boot()
    {
        parent::boot();
    }
}
