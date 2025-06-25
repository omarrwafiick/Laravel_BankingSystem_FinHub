<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'sender_id',
        'sender_account_id',
        'recipient_id',
        'recipient_account_id',
        'amount',
        'description',
        'initiated_by'
    ];
    public function sender(): BelongsTo{
        return $this->belongsTo(User::class,'sender_id');
    }

    public function recipient(): BelongsTo{
        return $this->belongsTo(User::class,'recipient_id');
    }

    public function sender_account(): BelongsTo{
        return $this->belongsTo(Account::class,'sender_account_id');
    }

    public function recipient_account(): BelongsTo{
        return $this->belongsTo(Account::class,'recipient_account_id');
    }

    public function initiated_by(): BelongsTo{
        return $this->belongsTo(User::class,'initiated_by');
    }
    
}
