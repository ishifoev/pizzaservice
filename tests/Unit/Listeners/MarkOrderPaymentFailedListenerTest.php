<?php

namespace Tests\Unit\Listeners;

use App\Models\Order;
use App\Events\Order\OrderPaymentFailed;
use App\Listeners\Order\MarkOrderPaymentFailed;
use App\Models\User;
use App\Listeners\Order\EmptyCart;
use App\Models\ProductVariation;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MarkOrderPaymentFailedListenerTest extends TestCase
{
    
    public function test_it_marks_order_as_payment_failed()
    {
        $event = new OrderPaymentFailed(
          $order = factory(Order::class)->create([
            'user_id' => factory(User::class)->create()
          ])
        );

        $listener = new MarkOrderPaymentFailed();

        $listener->handle($event);

        $this->assertEquals($order->fresh()->status, Order::PAYMENT_FAILED);
    }
}
