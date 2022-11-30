<?php

namespace App\Models;

use App\Traits\ScopeFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use HasFactory, ScopeFilter;

    protected $table = 'orders';

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'city',
        'address',
        'info',
        'payment_method',
        'courier_service',
        'locale',
        'grand_total',
        'payment_type',
        'user_id',
        'discount',
        'ship_price',
        'status_text',
        'tbc_session_id',
        'tbc_pay_id',
        'tbc_transaction_id',
        'tbc_rec_id',
        'tbc_payment_method'
    ];

    protected $appends = [
        'formatted_date'
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
            'price' => [
                'hasParam' => true,
                'scopeMethod' => 'price'
            ],
            'name' => [
                'hasParam' => true,
                'scopeMethod' => 'firstLastName'
            ],
            'email' => [
                'hasParam' => true,
                'scopeMethod' => 'email'
            ],
            'phone' => [
                'hasParam' => true,
                'scopeMethod' => 'phone'
            ],
            'from' => [
                'hasParam' => true,
                'scopeMethod' => 'from'
            ],
            'to' => [
                'hasParam' => true,
                'scopeMethod' => 'to'
            ],
        ];
    }


    public function items():HasMany{
        return $this->hasMany(OrderItem::class);
    }

    public function collections(){
        return $this->hasMany(OrderCollection::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


    public function getFormattedDateAttribute(){
        return (new Carbon($this->created_at))->format('d.m.Y');
    }

}
