<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id',
        'user_id',
        'reference',
        'transfer_id',
        'account_id',
        'amount',
        'balance_before',
        'balance_after',
        'category',
        'confirmed',
        'description',
        'meta'
    ];

    public function owner(): BelongsTo{
        return $this->belongsTo(User::class,'user_id');
    }

     public function account(): BelongsTo{
        return $this->belongsTo(related: Account::class, 'account_id');
    }

}
