<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnterpriseCropProduction extends Model
{
    protected $fillable = [
        'user_id',
        'crop_name',
        'country',
        'production_cost_plan',
        'production_cost_actual',
        'ploughing_plan',
        'ploughing_actual',
        'seed_plan',
        'seed_actual',
        'fertilizer_plan',
        'fertilizer_actual',
        'herbicide_plan',
        'herbicide_actual',
        'pesticide_plan',
        'pesticide_actual',
        'labour_plan',
        'labour_actual',
        'packaging_plan',
        'packaging_actual',
        'storage_plan',
        'storage_actual',
        'transport_plan',
        'transport_actual',
        'variety_plan',
        'variety_actual',
        'equipment_plan',
        'equipment_actual',
        'land_size_plan',
        'land_size_actual',
    ];
}
