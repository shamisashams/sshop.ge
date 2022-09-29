<?php

namespace App\Models;

use App\Models\Translations\ProductTranslation;
use App\Traits\ScopeFilter;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;


/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $category_id
 * @property string $slug
 * @property int|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read ProductTranslation|null $translation
 * @property-read Category|null $category
 * @property-read Collection|ProductTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Product translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product withTranslation()
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 */
class Product extends Model implements Searchable
{
    use Translatable, HasFactory, ScopeFilter;

    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @var string[]
     */
    protected $fillable = [
        'slug',
        'status',
        'popular',
        'sale',
        'stock',
        'code',
        'price',
        'quantity',
        'special_price',
        'new',
        'new_collection',
        'bunker',
        'day_price',
        'day_product',
        'special_price_tag',
        'parent_id',
        'corner',
        'size',
        'promocode_id',
        'installment_price',
        'min_price',
        'max_price'
    ];

    /** @var string */
    protected $translationModel = ProductTranslation::class;

    //protected $with = ['translation'];

    /** @var array */
    public $translatedAttributes = [
        'title',
        'short_description',
        'description',
        'meta_title',
        'meta_description',
        'meta_keyword',
    ];

    //protected $with = ['translation'];


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
            ],
            'category_id' => [
                'hasParam' => true,
                'scopeMethod' => 'categoryId'
            ],
            'slug' => [
                'hasParam' => true,
                'scopeMethod' => 'slug'
            ],
            'parent' => [
                'hasParam' => true,
                'scopeMethod' => 'parentId'
            ]
        ];
    }

    public function getSearchResult(): SearchResult
    {
        $url = locale_route('client.product.show', $this->slug);

        return new SearchResult(
            $this,
            $this->title,
            $url
        );
    }

    /**
     * @return BelongsTo
     */
    /*public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }*/

    /**
     * The categories that belong to the product.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    /**
     * Get the product attribute values that owns the product.
     */
    public function attribute_values(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    /**
     * @return MorphMany
     */
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


    public function stocks(): BelongsToMany{
        return $this->belongsToMany(Stock::class,'product_stocks')->withPivot('id', 'in_stock');
    }

    public function variants(){
        return $this->hasMany(static::class,'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function collections(){
        return $this->belongsToMany(ProductSet::class,'product_product_sets');
    }

    public function video(){
        return $this->morphOne(Video::class,'videoable');

    }

    public function videos(): MorphMany
    {
        return $this->morphMany(Video::class, 'videoable');
    }

    public function promocode(){
        return $this->belongsTo(PromoCode::class);
    }


    public function colors(){
        return $this->hasMany(ProductColor::class);
    }

    public function blogs(){
        return $this->belongsToMany(Blog::class,'blog_products');
    }

}
