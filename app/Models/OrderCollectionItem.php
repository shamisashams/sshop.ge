<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderCollectionItem extends Model
{
    use HasFactory;

    protected $table = 'order_collection_items';

    protected $fillable = [
        'order_collections_id',
        'product_id',
        'title',
        'price',
        'attributes'
    ];


    public function orderCollection(): BelongsTo
    {
        return $this->belongsTo(OrderCollection::class);
    }

    public function getAttributesAttribute($value){
        return json_decode($value);
    }

}
