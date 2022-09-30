<?php

namespace App\Models;

use App\Traits\ScopeFilter;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, ScopeFilter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'surname',
        'is_partner',
        'id_number',
        'phone',
        'affiliate_id',
        'referred_by',
        'address',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /*protected $with = [
      'referrals'
    ];*/

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFilterScopes(): array
    {
        return [
            'id' => [
                'hasParam' => true,
                'scopeMethod' => 'id'
            ],
            'email' => [
                'hasParam' => true,
                'scopeMethod' => 'email'
            ],
            'name' => [
                'hasParam' => true,
                'scopeMethod' => 'fullName'
            ],
        ];
    }


    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable')->where('type','!=',File::CV);
    }

    public function cv(): MorphOne{
        return $this->morphOne(File::class,'fileable')->where('type',File::CV);
    }

    public function partner(): HasOne{
        return $this->hasOne(Partner::class);
    }

    public function referrals(): HasMany{
        return $this->hasMany(self::class,'referred_by','affiliate_id');
    }

    public function referrer(){
        return $this->belongsTo(self::class, 'referred_by','affiliate_id');
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'user_id');
    }

    public function promoCode(){
        return $this->hasOne(UserPromoCode::class);
    }

    public function promoCodes(){
        return $this->hasMany(UserPromoCode::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function bankAccount(){
        return $this->hasOne(BankAccount::class);
    }

    public function bankAccounts(){
        return $this->hasMany(BankAccount::class);
    }

    public function cart(){
        return $this->hasOne(Cart::class);
    }

}
