<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segmentation extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type'
    ];

    public function Customer(){
        return $this->hasMany('App\Models\Customer');
    }

    public function Offer(){
        return $this->hasMany('App\Models\Offer');
    }

}
