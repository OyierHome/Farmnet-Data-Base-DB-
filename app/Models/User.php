<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'sur_name',
        'country',
        'phone',
        'email',
        'password',
        'stock_type',
        'verify_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function organization()
    {
        return $this->hasOne(Organization::class);
    }
    public function cropProductionRecords()
    {
        return $this->hasMany(CropProductionRecord::class);
    }
    public function cropRevenueRecords()
    {
        return $this->hasMany(cropRevenueRecord::class);
    }
<<<<<<< HEAD
    public function livestockProductionRecords()
    {
        return $this->hasMany(LivestockProductionRecord::class);
    }
    public function livestockRevenueRecords()
    {
        return $this->hasMany(LivestockRevenueRecord::class);
    }
    public function livestockInventoryRecords()
    {
        return $this->hasMany(LivestockInventory::class);
    }
    public function cropInventoryRecords()
    {
        return $this->hasMany(CropInventory::class);
    }
=======
>>>>>>> ae4bcff0aa80d991d7d0fd374b31a0c584ca7e3b
}
