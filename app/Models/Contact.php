<?php

namespace App\Models;

use App\Models\Translations\ContactTranslation;
use App\Models\Translations\SliderTranslation;
use App\Models\Translations\StockTranslation;
use App\Models\Translations\TeamTranslation;
use App\Traits\ScopeFilter;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use Translatable, HasFactory, ScopeFilter;


    protected $table = 'contacts';


    protected $fillable = [
        'city_id',
        'working_hours',
        'phone',
        'options'
    ];


    protected $translationModel = ContactTranslation::class;

    /** @var array */
    public $translatedAttributes = [
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

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function getOptionsAttribute($value){
        return json_decode($value);
    }

}
