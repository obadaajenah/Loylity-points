<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'bonus',
        'gems',
        'expiration_period',
        'golden_offers_number',
        'silver_offers_number',
        'bronze_offers_number',
        'new_offers_number'
    ];

    public function PartnerBundle(){
        return $this->hasMany('App\Models\PartnerBundle');
    }
}
