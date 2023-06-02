<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerBundle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'partner_id','bundle_id','price','start_date','end_date'
    ];

    public function Partner(){
        return $this->belongsTo('App\Models\Partner');
    }
    public function Bundle(){
        return $this->belongsTo('App\Models\Bundle');
    }
}
