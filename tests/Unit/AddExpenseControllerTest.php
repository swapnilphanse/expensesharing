<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\User;
use DB;
use App\Adduser;
use App\AddExpense;
use Carbon\Carbon;

class AddExpenseControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function user_can_see_add_expense_page() {

        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->get('/addexpense/create')->assertOk();
        
    }

    /** @test */
    public function user_can_add_expense() {


        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        
        $id = array($user1->id,$user2->id);
       
        $this->actingAs($user);


        $response = $this->post('adduser',[

            'userid' => $user->id,
            'contactid' => $user1->id
        ]);

        $response2 = $this->post('adduser',[

            'userid' => $user->id,
            'contactid' => $user2->id
        ]);
         
        $response3 =$this->post('/addexpense',[
           
            
            'name' => $id,
            'split' => '50%',
            'amount' => '3000',
            'type' => 'half',
            'ename' =>  'testexpense2',
            'category' => 'Miscellaneous',

        ]);
    
     
        $response3->assertStatus(302);



    }


    /** @test*/

    public function user_can_view_added_expense() {

        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        
        $id = array($user1->id,$user2->id);
       
        $this->actingAs($user);


        $response = $this->post('adduser',[

            'userid' => $user->id,
            'contactid' => $user1->id
        ]);

        $response2 = $this->post('adduser',[

            'userid' => $user->id,
            'contactid' => $user2->id
        ]);
         
        $response3 =$this->post('/addexpense',[
           
            
            'name' => $id,
            'split' => '50%',
            'amount' => '3000',
            'type' => 'half',
            'ename' =>  'testexpense2',
            'category' => 'Miscellaneous',

        ]);
    
     
        $response3->assertStatus(302);
        $exp  = DB::table('add_expenses')->where('ename', 'testexpense2')->first();
        
            $exp2 = DB::table('users')->where('id',$exp->added_by)->first(); 

       $response4 = $this->get(route('addexpense.show',$exp->expense_id));
       $this->assertEquals('testexpense2',$exp->ename);
       $this->assertEquals('3000',$exp->amount);
       $this->assertEquals($user->name,$exp2->name);

       
    }
}
