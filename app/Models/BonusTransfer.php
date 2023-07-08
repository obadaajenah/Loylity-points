<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonusTransfer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_user_id',
        'receiver_user_id',
        'value',
        'type',
        'exp_date'
    ];

    public function senderUser(){
        return $this->belongsTo('App\Models\User','sender_user_id');
    }
    public function receiverUser(){
        return $this->belongsTo('App\Models\User','receiver_user_id');
    }
}
