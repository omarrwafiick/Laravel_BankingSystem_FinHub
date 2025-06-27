<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use SoftDeletes;
    protected $fillable = [ 
        'sender_account_id', 
        'recipient_account_id',
        'amount',  
        'reference',
        'status'
    ]; 
    public function sender_account(): BelongsTo{
        return $this->belongsTo(Account::class,'sender_account_id');
    }

    public function recipient_account(): BelongsTo{
        return $this->belongsTo(Account::class,'recipient_account_id');
    }
 
    
}
