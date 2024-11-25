<?php

namespace App\Models;

use App\Models\Traits\TranslatableFields;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    // use TranslatableFields;

    protected $fillable = [
        'name', 'description',
        'status', 'gender',
        'image',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
    ];

    // protected function translationFields(): array
    // {
    //     return ['name'];
    // }

    protected static function boot()
    {
        parent::boot();
    }
}
