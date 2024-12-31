<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LivestockProductionRecord extends Model
{
    protected $fillable = ['user_id', 'crop_name', 'country', 'equipment_qty', 'equipment_price', 'seed_qty', 'seed_price', 'feeds_qty', 'feeds_price', 'suppliements_qty', 'suppliements_price', 'pesticide_qty', 'pesticide_price', 'labour_qty', 'labour_price', 'packaing_qty', 'packaing_price', 'storage_qty', 'storage_price', 'transport_qty', 'transport_price', 'spray_qty', 'spray_price', 'variety_qty', 'variety_price', 'tool_qty', 'tool_price', 'model_qty', 'model_price', 'range_qty', 'range_price', 'land_size_qty', 'land_size_price'];

    public function user()
    {
        return $this->belongsTo(User::class);

    }
}
