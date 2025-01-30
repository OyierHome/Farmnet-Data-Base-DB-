<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRight extends Model
{
    protected $fillable = ['user_id', 'right'];

    protected $casts = [
        'right' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
