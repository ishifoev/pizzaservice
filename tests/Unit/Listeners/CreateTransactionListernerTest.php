<?php

namespace Tests\Unit\Listeners;

use App\Models\Order;
use App\Events\Order\OrderPaid;
use App\Listeners\Order\CreateTransaction;
use App\Models\User;
use App\Listeners\Order\EmptyCart;
use App\Models\ProductVariation;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTransactionListenerTest extends TestCase
{
    
    public function test_it_creates_a_transaction()
    {
        $event = new OrderPaid(
          $order = factory(Order::class)->create([
            'user_id' => factory(User::class)->create()
          ])
        );

        $listener = new CreateTransaction();

        $listener->handle($event);

        $this->assertDatabaseHas('transactions', [
            'order_id' => $order->id,
            'total' => $order->total()->amount()
        ]);
    }
}
