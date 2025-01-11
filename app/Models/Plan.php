<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['user_id','data'];
    protected $casts = [
        'data' => 'array', // This tells Laravel to handle `data` as a JSON array
    ];
}
