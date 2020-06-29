<?php

namespace Tests\Feature\PaymentMethods;

use Tests\TestCase;
use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentIndexTest extends TestCase
{
    
    public function test_it_if_the_user_is_not_authenitcated()
    {
        $this->json('GET', 'api/payment-methods')
             ->assertStatus(401);
    }

    public function test_it_returns_a_collection_of_payment_methods()
    {
        $user = factory(User::class)->create();

        $payment = factory(PaymentMethod::class)->create([
             'user_id' => $user->id
        ]);

        $this->jsonAs($user, 'GET', 'api/payment-methods')
             ->assertJsonFragment([
                 'id' => $payment->id
             ]);
    }
}
