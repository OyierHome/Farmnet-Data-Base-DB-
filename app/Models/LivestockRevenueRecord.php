<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LivestockRevenueRecord extends Model
{
    protected $fillable = ['user_id', 'crop_name', 'country', 'cash_sale_qty', 'cash_sale_price', 'credit_sale_qty', 'credit_sale_price', 'services_qty', 'services_price', 'advertisiment_qty', 'advertisiment_price', 'donation_qty', 'donation_price', 'farm_visit_qty', 'farm_visit_price', 'royality_qty', 'royality_price', 'incentives_qty', 'incentives_price', 'bonuses_qty', 'bonuses_price', 'research_qty', 'research_price', 'traning_qty', 'traning_price', 'hospitality_qty', 'hospitality_price', 'intrests_qty', 'intrests_price', 'land_size_qty', 'land_size_price'];

    public function user()
    {
        return $this->belongsTo(User::class);

    }
}
