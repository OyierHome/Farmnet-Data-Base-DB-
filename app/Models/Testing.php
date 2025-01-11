<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testing extends Model
{
    protected $fillable = ['user_id' , 'stock_type' , 'test_type' , 'data'];
    protected $casts = [
        'data' => 'array', // This tells Laravel to handle `data` as a JSON array
    ];
}
