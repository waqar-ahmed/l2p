<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AccessToken extends Authenticatable
{
    protected $table = 'access_tokens';    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'access_token', 'refresh_token', 'expires_in', 'token_type',        
    ];        
    
    public function deviceToken() {
        return $this->hasOne('App\DeviceToken', 'access_token_id');
    }
    
    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function($accessToken) { // before delete() method call this
             $accessToken->deviceToken()->delete();             
        });
    }        
}
