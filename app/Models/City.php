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

class City extends Model
{
    use Translatable, HasFactory, ScopeFilter;


    protected $table = 'cities';


    protected $fillable = [
        'status',
        'ship_price',
        'is_shipping'
    ];


    protected $translationModel = CityTranslation::class;

    /** @var array */
    public $translatedAttributes = [
        'title',
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

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
    /**
     * @return MorphOne
     */
    public function file(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function contacts(){
        return $this->hasMany(Contact::class);
    }

    public function stocks(){
        return $this->hasMany(Stock::class);
    }
}
