<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSetTranslation extends BaseTranslationModel
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'meta_title',
        'meta_description',
        'short_description',
        'meta_keyword'
    ];
}
