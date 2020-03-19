<?php

namespace Successive\Keka;

use Illuminate\Support\ServiceProvider;

/**
 * Class KekaServiceProvider
 * @package Successive\Keka
 */
class KekaServiceProvider extends ServiceProvider{


    public function boot(){
        $this->publishes([
            __DIR__ . '/config/keka.php' => config_path('keka.php')
        ]);
    }

    public function register(){

    }
}
