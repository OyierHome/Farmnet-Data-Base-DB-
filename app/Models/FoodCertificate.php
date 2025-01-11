<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodCertificate extends Model
{
    protected $fillable = ['user_id' , 'data'];
    protected $casts = [
        'data' => 'array',
    ];
}
