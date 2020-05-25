<?php
// Swapnil Phanse
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;

class SearchController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index() {

        dd('Search User Page');
        return view('users.search');
    }

    public function search(Request $request) {


         if($request -> ajax()) {
            $currentuserid = Auth::user()->id;
            $output = "";
            $usr = DB::table('users')-> where('phone','LIKE','%'.$request->search."%")->get();

            if($usr) {
               
                foreach($usr as $key => $userid) {

                    $output .= '<tr>'.
                    '<td>' .$userid->name.'</td>'.
                    '<td>' .$userid->email.'</td>'.
                    '<input type="hidden" name="contactid" value="'.$userid->id.'">'.
                    '<input type="hidden" name="userid" value="'.$currentuserid.'">'.
                    '<td><button type="submit" class="btn btn-primary btn-lg btn-block mb-3">Add User</button></td>'.
                    '</tr>';
                }
                
                return Response($output);
                

            }
         }

         return view('users.search');
    }

}




