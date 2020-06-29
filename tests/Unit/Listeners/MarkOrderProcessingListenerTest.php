<?php

namespace Tests\Unit\Listeners;

use App\Models\Order;
use App\Events\Order\OrderPaid;
use App\Listeners\Order\MarkOrderProcessing;
use App\Models\User;
use App\Listeners\Order\EmptyCart;
use App\Models\ProductVariation;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MarkOrderProcessingListenerTest extends TestCase
{
    
    public function test_it_marks_order_as_processing()
    {
        $event = new OrderPaid(
          $order = factory(Order::class)->create([
            'user_id' => factory(User::class)->create()
          ])
        );

        $listener = new MarkOrderProcessing();

        $listener->handle($event);

        $this->assertEquals($order->fresh()->status, Order::PROCESSING);
    }
}
