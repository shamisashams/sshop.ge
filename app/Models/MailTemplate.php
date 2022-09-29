<?php

namespace App\Models;

use App\Models\Translations\MailTemplateTranslation;
use App\Models\Translations\SliderTranslation;
use App\Models\Translations\StockTranslation;
use App\Traits\ScopeFilter;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailTemplate extends Model
{
    use Translatable, HasFactory;


    protected $table = 'mail_templates';


    protected $fillable = [
        'promocode_cart',
        'promocode_products',
        'client_register',
        'partner_register'
    ];


    protected $translationModel = MailTemplateTranslation::class;

    /** @var array */
    public $translatedAttributes = [
        'promocode_cart',
        'promocode_products',
        'client_register',
        'partner_register'
    ];




}
