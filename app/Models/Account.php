<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes; 
    protected $fillable = [
        'id',
        'user_id',
        'account_number',  
        'balance',   
        'type',            
        'status',
        'currency',
    ]; 

    public function owner(): BelongsTo{
        return $this->belongsTo(User::class,'user_id');
    }

    public function transactions(): HasMany{
        return $this->hasMany(Transaction::class);
    }
}
