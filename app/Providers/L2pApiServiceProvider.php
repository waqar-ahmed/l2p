<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Description of L2pApiServiceProvider
 *
 * @author odgiiv
 */
class L2pApiServiceProvider extends ServiceProvider{
    
    public function register() {
        $this->app->bind('App\Services\L2pRequestManager', 'App\Services\RequestManagerGuzzle');
        $this->app->bind('App\Services\L2pTokenManager', 'App\Services\TokenManager');
    }

}
