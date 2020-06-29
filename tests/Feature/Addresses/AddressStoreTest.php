<?php

namespace Tests\Feature\Addresses;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressStoreTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_fails_authenticated()
    {
        $this->json('POST', 'api/addresses')

        ->assertStatus(401);
    }

    public function test_it_requires_a_name()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'POST', 'api/addresses')

        ->assertJsonValidationErrors([
            'name'
        ]);
    }

    public function test_it_requires_address_line_one()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'POST', 'api/addresses')

        ->assertJsonValidationErrors([
            'address_1'
        ]);
    }

    public function test_it_requires_a_city()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'POST', 'api/addresses')

        ->assertJsonValidationErrors([
            'city'
        ]);
    }

    public function test_it_requires_a_postal_code()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'POST', 'api/addresses')

        ->assertJsonValidationErrors([
            'postal_code'
        ]);
    }


    public function test_it_requires_a_country()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'POST', 'api/addresses')

        ->assertJsonValidationErrors([
            'country_id'
        ]);
    }

    public function test_it_requires_a_vald_country()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'POST', 'api/addresses',[
           'country_id' => 1
        ])

        ->assertJsonValidationErrors([
            'country_id'
        ]);
    }

    public function test_it_stores_an_address()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'POST', 'api/addresses',$payload = [
           'name' => 'Alex Malikov',
           'address_1' => 'Aini 26 app7',
           'city' => 'Dushanbe',
           'postal_code' => '734400',
           'country_id' => factory(Country::class)->create()->id
        ]);

        $this->assertDatabaseHas('addresses', array_merge($payload,[
           'user_id' => $user->id,
        ]));

    }

    public function test_it_return_an_address_when_created()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user,'POST', 'api/addresses',$payload = [
           'name' => 'Alex Malikov',
           'address_1' => 'Aini 26 app7',
           'city' => 'Dushanbe',
           'postal_code' => '734400',
           'country_id' => factory(Country::class)->create()->id
        ]);
        $response->assertJsonFragment([
           'id'=>json_decode($response->getContent())->data->id
        ]);
    }

}
