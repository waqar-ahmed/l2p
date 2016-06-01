<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'access_token', 'refresh_token', 'expires_in', 'token_type',        
    ];    
    
    public function deviceToken() {
        return $this->hasOne('App\DeviceToken');
    }
}
