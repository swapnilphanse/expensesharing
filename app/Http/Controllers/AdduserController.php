<?php

// Swapnil Phanse
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdduserController extends Controller
{

   public function __construct()
   {
       $this->middleware('auth');
   }
   
     public function store(Request $request) { 


      request()->validate([
            
         'userid' => ['required'],
         'contactid' => ['required'],
      ]);

        $userid = $request->input('userid');
        
        $contactid = $request->input('contactid');
       
        
        $data=array('userID'=>$userid,"contactID"=>$contactid);
        DB::table('contact')->insert($data);
        $data1=array('userID'=>$contactid,"contactID"=>$userid);
        DB::table('contact')->insert($data1);
       // dd('User added successfully.');
        return back()->withStatus(__('User added successfully.'));
         
       
     }
}
