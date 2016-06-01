<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    protected $table = 'device_tokens';
    
    protected $fillable = [
        'device_code', 'user_code', 'verification_url', 'expires_in', 
        'interval',        
    ];
    
    public function accessToken() {
        return $this->belongsTo('App\AccessToken', 'access_token_id');
    }        
}
