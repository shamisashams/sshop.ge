<?php

namespace App\Listeners;

use App\Events\UserLoggedin;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Cart\Facade\Cart;

class CartMerge
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserLoggedin  $event
     * @return void
     */
    public function handle(Login $event)
    {
        //
        Cart::mergeCart($event->user);
    }
}
