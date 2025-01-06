<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisiment extends Model
{
    protected $fillable = [
        'user_id',
        'crop_type',
        'type',
        'problem',
        'diagnosis',
        'management',
        'product_name',
        'product_image',
        'benefits',
        'amount',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function add_booking()
    {
        return $this->hasMany(AddBooking::class);
    }
}
