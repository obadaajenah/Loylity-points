<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'nickName',
        'segmentation_id',
        'cur_bonus',
        'total_bonus',
        'cur_gems',
        'total_gems'
    ];

    public function User(){
        return $this->belongsTo('App\Models\User');
    }

    public function Segmentation(){
        return $this->belongsTo('App\Models\Segmentation');
    }

    public function Bonus2Gems(){
        return $this->hasMany('App\Models\Bonus2Gems');
    }

    public function Gems2Cash(){
        return $this->hasMany('App\Models\Gems2Cash');
    }

}
