<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationDocument extends Model
{  
    protected $fillable = [
        'user_id',
        'type',           
        'file_path',
    ];
}
