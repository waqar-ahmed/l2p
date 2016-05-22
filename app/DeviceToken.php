<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    protected $table = 'device_tokens';
    
    protected $fillable = [
        'device_token', 'user_code', 'verification_url', 'expires_in', 
        'interval',        
    ];
    
    public function user() {
        return $this->belongsTo('App\User');
    }
}
