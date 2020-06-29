<?php

namespace Tests\Unit\Collections;

use Tests\TestCase;
use App\Models\User;
use App\Models\Collections\ProductVariationCollection;
use App\Models\ProductVariation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductVariationCollectionTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_can_syncing_array()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            $product = factory(ProductVariation::class)->create(),[
             'quantity' => $quantity = 2
            ]
         );

        $collection = new ProductVariationCollection($user->cart);

        $this->assertEquals($collection->forSyncing(), [
           $product->id => [
             'quantity' => $quantity
           ]
        ]);
    }
}
