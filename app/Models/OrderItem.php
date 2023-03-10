<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';


    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getAttributesAttribute($value){
        return json_decode($value);
    }


}
