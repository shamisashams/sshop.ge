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

class PromoCode extends Model
{
    use HasFactory, ScopeFilter;


    protected $table = 'promo_codes';


    protected $fillable = [
        'user_id',
        'promo_code',
        'reward',
        'quantity',
        'type',
        'status'
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
            'reward' => [
                'hasParam' => true,
                'scopeMethod' => 'reward'
            ],
            'type' => [
                'hasParam' => true,
                'scopeMethod' => 'type'
            ],
        ];
    }



    public function products()
    {
        return $this->hasMany(Product::class,'promocode_id');
    }

    public function userPromocode(){
        return $this->hasOne(UserPromoCode::class,'promocode_id')->where('user_id',auth()->id());
    }
}
