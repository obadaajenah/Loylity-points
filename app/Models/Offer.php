<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'partner_id',
        'segmentation_id',
        'valueInBonus',
        'valueInGems',
        'quantity',
        'img_url'
    ];

    public function Partner(){
        return $this->belongsTo('App\Models\Partner');
    }

    public function Segmentation(){
        return $this->belongsTo('App\Models\Segmentation');
    }

}
