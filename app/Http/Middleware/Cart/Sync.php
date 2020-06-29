<?php

namespace App\Http\Middleware\Cart;

use Closure;
use App\Cart\Cart;

class Sync
{
    protected $cart;
   
    public function __construct(Cart $cart)
    {
       $this->cart = $cart;
    }

    public function handle($request, Closure $next)
    {
        $this->cart->sync();

        if($this->cart->hasChanged())
        {
            return response()->json([
               'message' => 'Oh, no some items in your cart have changed. Please review your changes before your placing your order.'
            ], 409);
        }
        return $next($request);
    }
}
