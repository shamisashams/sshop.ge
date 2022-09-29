<?php

namespace App\Models;

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

class Stock extends Model
{
    use Translatable, HasFactory, ScopeFilter;


    protected $table = 'stocks';


    protected $fillable = [
        'long',
        'lat',
        'city_id'
    ];


    protected $translationModel = StockTranslation::class;

    /** @var array */
    public $translatedAttributes = [
        'title',
        'address',
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

    public function city(): BelongsTo{
        return $this->belongsTo(City::class);
    }

    public function products(): BelongsToMany{
        return $this->belongsToMany(Product::class,'product_stocks');
    }
}
