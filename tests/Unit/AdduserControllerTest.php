<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use App\User;
use DB;
use App\Adduser;

class AdduserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    

   /** @test */
    public function user_can_see_add_user_page() {

        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->get('/search')->assertOk();
        
    }

    /** @test */
    public function user_can_add_another_user() {

        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        
        $user2 = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->post('adduser',[

            'userid' => $user->id,
            'contactid' => $user2->id,
        ]);

        $response->assertStatus(302);

    }
}
