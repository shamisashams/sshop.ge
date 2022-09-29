<?php

namespace App\Models;

use App\Traits\ScopeFilter;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class BankAccount extends Model
{
    use HasFactory;

    protected $table = 'bank_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bank_id',
        'account_number'
    ];

    //protected $primaryKey = 'user_id';


    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
