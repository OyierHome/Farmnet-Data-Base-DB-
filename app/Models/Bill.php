<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = ['user_id' , 'bill_type' , 'country' , 'data'];
    protected $casts = [
        'data' => 'array', // This tells Laravel to handle `data` as a JSON array
    ];
}
