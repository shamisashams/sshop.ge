<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTranslation extends BaseTranslationModel
{
    use HasFactory;
    protected $fillable = [
        'title',
        'address'
    ];
}
