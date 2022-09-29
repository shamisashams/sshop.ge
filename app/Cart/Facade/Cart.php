<?php

namespace App\Cart\Facade;

use Illuminate\Support\Facades\Facade;

class Cart extends Facade{

    protected static function getFacadeAccessor()
    {
        return 'cart';
    }
}
