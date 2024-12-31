<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CropProductionRecord extends Model
{
    protected $fillable = [
        'user_id',
        'crop_name',
        'country',
        'ploughing_qty',
        'ploughing_price',
        'seed_qty',
        'seed_price',
        'fertilizer_qty',
        'fertilizer_price',
        'herbicide_qty',
        'herbicide_price',
        'pesticide_qty',
        'pesticide_price',
        'labour_qty',
        'labour_price',
        'packaging_qty',
        'packaging_price',
        'storage_qty',
        'storage_price',
        'transport_qty',
        'transport_price',
        'variety_qty',
        'variety_price',
        'equipment_qty',
        'equipment_price',
        'land_size_qty',
        'land_size_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
