<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CropRevenueRecord extends Model
{

    protected $fillable = ['user_id', 'crop_name', 'country'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
