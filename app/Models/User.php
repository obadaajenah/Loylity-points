<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens , HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname','lname','role_id', 'email','phone_number', 'password', 'img_url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Role(){
        return $this->belongsTo('App\Models\Role');
    }

    public function Customer(){
        return $this->hasMany('App\Models\Customer');
    }

    public function Partner(){
        return $this->hasMany('App\Models\Customer');
    }

    public function RequestsPartner(){
        return $this->hasMany('App\Models\RequestsPartner');
    }

    public function BonusTransferSender(){
        return $this->hasMany('App\Models\BonusTransfer','sender_user_id');
    }

    public function BonusTransferReceiver(){
        return $this->hasMany('App\Models\BonusTransfer','receiver_user_id');
    }

    public function GemsTransferSender(){
        return $this->hasMany('App\Models\GemsTransfer','sender_user_id');
    }

    public function GemsTransferReceiver(){
        return $this->hasMany('App\Models\GemsTransfer','receiver_user_id');
    }
}
