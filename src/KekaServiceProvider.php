<?php

namespace Successive\Keka;

use Illuminate\Support\ServiceProvider;

/**
 * Class KekaServiceProvider
 * @package Successive\Keka
 */
class KekaServiceProvider extends ServiceProvider{


    public function boot(){
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'keka');
        $this->mergeConfigFrom(
            __DIR__.'/config/constants.php', 'keka-package'
        );
    }

    public function register(){

    }
}
