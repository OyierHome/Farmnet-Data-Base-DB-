<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CropInventory extends Model
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
        'herbicides_qty',
        'herbicides_price',
        'pesticide_qty',
        'pesticide_price',
        'labour_qty',
        'labour_price',
        'packaing_qty',
        'packaing_price',
        'storage_qty',
        'storage_price',
        'transport_qty',
        'transport_price',
        'trees_qty',
        'trees_price',
        'equipment_qty',
        'equipment_price',
        'tools_qty',
        'tools_price',
        'feeders_qty',
        'feeders_price',
        'land_size_qty',
        'land_size_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
