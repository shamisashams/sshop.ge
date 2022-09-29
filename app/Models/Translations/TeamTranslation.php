<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamTranslation extends BaseTranslationModel
{
    use HasFactory;
    protected $fillable = [
        'name',
        'surname',
        'position'
    ];
}
