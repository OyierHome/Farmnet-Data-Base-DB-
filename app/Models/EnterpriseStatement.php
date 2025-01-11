<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnterpriseStatement extends Model
{
    protected $fillable = ['user_id' , 'data'];
    protected $casts = [
        'data' => 'array',
    ];
}
