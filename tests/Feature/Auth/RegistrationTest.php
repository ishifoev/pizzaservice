<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_requires_a_name()
    {
        $this->json('POST', 'api/auth/register')
             ->assertJsonValidationErrors(['name']);
    }

    public function test_it_requires_a_email()
    {
        $this->json('POST', 'api/auth/register')
             ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_valid_email()
    {
        $this->json('POST', 'api/auth/register',[
         'email' => 'nope'
        ])
             ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_unique_email()
    {
        $user = factory(User::class)->create();

        $this->json('POST', 'api/auth/register',[
         'email' => $user->email
        ])
             ->assertJsonValidationErrors(['email']);
    }


    public function test_it_requires_a_password()
    {
        $this->json('POST', 'api/auth/register')
             ->assertJsonValidationErrors(['name']);
    }
    public function test_it_registers_a_user()
    {
        $this->json('POST', 'api/auth/register',[
          'name' => $name = 'Alex',
          'email' => $email = 'alex.malikov94@gmail.com',
          'password' => 'secret'
        ]);

        $this->assertDatabaseHas('users', [
           'email'=> $email,
           'name' => $name

        ]);
    }

    public function test_it_return_a_user_on_registration()
    {
        $this->json('POST', 'api/auth/register',[
          'name' => 'Alex',
          'email' => $email = 'alex.malikov94@gmail.com',
          'password' => 'secret'
        ])

        ->assertJsonFragment([
          'email' => $email
        ]);

     
    }


}
