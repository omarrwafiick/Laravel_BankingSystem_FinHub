<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'account_id',
        'type',
        'amount',
        'balance_before',
        'balance_after',
        'description',
        'reference',
        'confirmed',
        'meta',
        'transfer_id',
        'user_id'
    ];

    public function owner(): BelongsTo{
        return $this->belongsTo(User::class,'user_id');
    }

     public function account(): BelongsTo{
        return $this->belongsTo(related: Account::class, 'account_id');
    }

}
