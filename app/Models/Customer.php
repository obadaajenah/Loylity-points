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
        'user_id','nickName','segmentation_id','cur_bonus','total_bonus','cur_gems','total_gems'
    ];

    public function User(){
        return $this->belongsTo('App\Models\Users');
    }

    public function Segmentation(){
        return $this->belongsTo('App\Models\Segmentations');
    }
}
