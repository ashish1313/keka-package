<?php

namespace Successive\Keka;

use Illuminate\Support\ServiceProvider;

class KekaServiceProvider extends ServiceProvider{


    public function boot(){
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'keka');
    }

    public function register(){

    }
}