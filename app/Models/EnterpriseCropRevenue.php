<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnterpriseCropRevenue extends Model
{
    protected $fillable = [
        'user_id',
        'crop_name',
        'country',
        'production_cost_plan',
        'production_cost_actual',
        'cash_sale_plan',
        'cash_sale_actual',
        'credit_sale_plan',
        'credit_sale_actual',
        'service_plan',
        'service_actual',
        'advertisement_plan',
        'advertisement_actual',
        'donation_plan',
        'donation_actual',
        'farm_visit_plan',
        'farm_visit_actual',
        'royalty_plan',
        'royalty_actual',
        'incentive_plan',
        'incentive_actual',
        'bonus_plan',
        'bonus_actual',
        'research_plan',
        'research_actual',
        'training_plan',
        'training_actual',
        'land_size_plan',
        'land_size_actual',
    ];
}
