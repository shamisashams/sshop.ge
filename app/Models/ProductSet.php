<?php

namespace App\Models;

use App\Models\Translations\ProductSetTranslation;
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

class ProductSet extends Model
{
    use Translatable, HasFactory, ScopeFilter;


    protected $table = 'product_sets';


    protected $fillable = [
        'slug',
        'price',
        'status',
        'special_price',
        'code'
    ];

    protected $appends = [
      'product_count',
    ];


    protected $translationModel = ProductSetTranslation::class;

    /** @var array */
    public $translatedAttributes = [
        'title',
        'description',
        'meta_title',
        'meta_description',
        'short_description',
        'meta_keyword'
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

    public function latestImage()
    {
        return $this->morphOne(File::class, 'fileable')->orderBy('main','desc');
    }



    public function products(): BelongsToMany{
        return $this->belongsToMany(Product::class,'product_product_sets')->withPivot(['id','coordinates']);
    }

    public function colors(){
        return $this->belongsToMany(AttributeOption::class,'collection_colors','product_set_id','color_id');
    }

    public function video(): MorphOne
    {
        return $this->morphOne(Video::class, 'videoable');
    }

    public function getSetImageAttribute($value){
        return asset($value);
    }

    public function getProductCountAttribute(){
        return $this->products()->count();
    }


    public function categories(){
        return $this->belongsToMany(Category::class, 'collection_categories');
    }
}
