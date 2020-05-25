<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function register_returns_form_view()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    /** @test */
    public function register_returns_validation_error()
    {
        $response = $this->post('register', []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'email', 'phone', 'password']);
    }

    /** @test */
    public function register_creates_and_authenticates_a_user()
    {
        $this->withoutExceptionHandling();

        Event::fake();

        $response = $this->post('register', [
            'name' => 'testuser',
            'phone' => 1234567890,
            'email' => 'testuser@test.com',
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
        ]);

        
        $response->assertRedirect(route('home'));
        $this->assertCount(1, $users = User::all());
        $this->assertAuthenticatedAs($user = $users->first());
        $this->assertEquals('testuser', $user->name);
        $this->assertEquals(1234567890, $user->phone);
        $this->assertEquals('testuser@test.com', $user->email);
        
        $this->assertTrue(Hash::check('testpassword', $user->password));
        Event::assertDispatched(Registered::class, function ($e) use ($user) {
            return $e->user->id === $user->id;
        });
    }


    /** @test */
    public function user_cannot_register_without_username() {

        $phone = $this->faker->phoneNumber;
        $email = $this->faker->unique()->safeEmail;
        $password = "testpassword";

        $response = $this->post('register',[
            'name'=> '',
            'phone' => $phone,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertSessionHasErrors(['name']);
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertTrue(session()->hasOldInput('phone'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();

    }

    /** @test */
    public function user_cannot_register_without_email() {

        $name = $this->faker->name;
        $phone = $this->faker->phoneNumber;
        $password="testpassword";

        $response = $this->post('register',[
            'name' => $name,
            'phone' => $phone,
            'email' => '',
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('phone'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();

    }

    /** @test */
    public function user_cannot_register_without_phone() {

        $name = $this->faker->name;
        $email = $this->faker->unique()->safeEmail;

        $response = $this->post('register',[
            'name' => $name,
            'phone' => '',
            'email' => $email,
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
        ]);

        $response->assertSessionHasErrors(['phone']);
        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function user_cannot_register_with_invalid_email() {

        $name = $this->faker->name;
        $email = 'invalid-email';
        $phone = $this->faker->phoneNumber;

        $response = $this->post('register',[
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('phone'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function user_cannot_register_without_password() {

        $name = $this->faker->name;
        $phone = $this->faker->phoneNumber;
        $email = $this->faker->unique()->safeEmail;

        $response = $this->post('register',[
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertTrue(session()->hasOldInput('phone'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function user_cannot_register_without_password_confirmation() {

        $name = $this->faker->name;
        $email = $this->faker->unique()->safeEmail;
        $phone = $this->faker->phoneNumber;

        $response = $this->post('register',[
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'password' => 'testpassword',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertTrue(session()->hasOldInput('phone'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function user_cannot_register_without_password_matching() {

        $name = $this->faker->name;
        $email = $this->faker->unique()->safeEmail;
        $phone = $this->faker->phoneNumber;

        $response = $this->post('register',[
            'name' => $name, 
            'phone' => $phone,
            'email' => $email,
            'password' => 'testpassword',
            'password_confirmation' => 'test',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertTrue(session()->hasOldInput('phone'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
}    