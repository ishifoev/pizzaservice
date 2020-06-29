<?php

namespace App\Listeners\Order;

use App\Events\Order\OrderPaid;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateTransaction
{
   
    public function handle(OrderPaid $event)
    {
        $event->order->transactions()->create([
           'total' => $event->order->total()->amount()
        ]);
    }
}
