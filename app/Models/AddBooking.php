<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddBooking extends Model
{
    protected $fillable = [
        'user_id',
        'advertisiment_id',
        'page',
        'section',
        'from_time',
        'to_time',
        'status',
        'price',
        'payment_status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function advertisiment()
    {
        return $this->belongsTo(Advertisiment::class);
    }

}
