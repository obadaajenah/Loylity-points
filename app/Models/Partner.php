<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'gems','bonus','Details'
    ];
    
    public function User(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function Offer(){
        return $this->hasMany('App\Models\Offer');
    }

    public function PartnerBundle(){
        return $this->hasMany('App\Models\PartnerBundle');
    }

}
