<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use App\Models\User;
use App\Models\ProductVariation;
use App\Models\ShippingMethod;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartIndexTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_fails_if_unauthenicated()
    {
        $response = $this->json('GET', 'api/cart')
             ->assertStatus(401);  
    }

    public function test_it_show_products_in_the_user_cart()
    {
        $user = factory(User::class)->create();

        $user->cart()->sync(
          $product = factory(ProductVariation::class)->create()
        );

        $response = $this->jsonAs($user,'GET', 'api/cart')
                         ->assertJsonFragment([
                          'id' => $product->id
                         ]);

    }

    public function test_it_show_if_the_cart_empty()
    {
        $user = factory(User::class)->create();

    
        $response = $this->jsonAs($user,'GET', 'api/cart')
                         ->assertJsonFragment([
                          'empty' => true
                         ]);

    }

    public function test_it_show_formatted_subtotal()
    {
        $user = factory(User::class)->create();

    
        $response = $this->jsonAs($user,'GET', 'api/cart')
                         ->assertJsonFragment([
                          'subtotal' => '£0.00'
                         ]);

    }

    public function test_it_show_formatted_total()
    {
        $user = factory(User::class)->create();

    
        $response = $this->jsonAs($user,'GET', 'api/cart')
                         ->assertJsonFragment([
                          'total' => '£0.00'
                         ]);

    }

    public function test_it_show_formatted_total_with_shipping()
    {
        $user = factory(User::class)->create();

        $shipping = factory(ShippingMethod::class)->create([
          'price' => 1000
        ]);

    
        $response = $this->jsonAs($user,'GET', "api/cart?shipping_method_id={$shipping->id}")
                         ->assertJsonFragment([
                          'total' => '£10.00'
                         ]);

    }


}
