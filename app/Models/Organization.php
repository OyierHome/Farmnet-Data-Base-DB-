<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = ['user_id', 'org_name', 'org_country', 'org_phone', 'org_email', 'org_password', 'service_provider', 'offtake_partner', 'input_supplier', 'development_partner', 'education', 'institude', 'community', 'invester'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
