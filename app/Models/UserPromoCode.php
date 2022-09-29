<?php

namespace App\Models;

use App\Models\Translations\CityTranslation;
use App\Models\Translations\SliderTranslation;
use App\Traits\ScopeFilter;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPromoCode extends Model
{
    use HasFactory, ScopeFilter;


    protected $table = 'user_promocodes';


    protected $fillable = [
        'user_id',
        'promocode_id',
        'promocode',


    ];



    public function getFilterScopes(): array
    {
        return [
            'id' => [
                'hasParam' => true,
                'scopeMethod' => 'id'
            ],
            'status' => [
                'hasParam' => true,
                'scopeMethod' => 'status'
            ],
            'title' => [
                'hasParam' => true,
                'scopeMethod' => 'titleTranslation'
            ]
        ];
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promocodeM(){
        return $this->belongsTo(PromoCode::class,'promocode_id','id');
    }
}
