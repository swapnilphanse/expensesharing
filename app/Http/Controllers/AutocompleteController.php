<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\User;

class AutocompleteController extends Controller
{
    public function autocomplete(Request $request)
    {

            $id = Auth::user()->id;

            $search = trim($request->search);

            if (empty($search)) {
                return \Response::json([]);
            }

            $data =  User::orderby('name','asc')
            ->select(DB::raw('users.id,users.name'))
            ->where('users.name','LIKE','%'.$search.'%')
            ->whereIN('users.id' ,function($query) use ($id)
            {
                $query->select(DB::raw('contact.contactid'))
                ->from('contact')
                ->join ('users', 'users.id', '=', 'contact.userID')
               
                ->where('contact.userID',$id);
                
            })
            
            ->get();

            $names = array();

            foreach ($data as $d) {
                $names[] = array(
                    'id' => $d->id,
                    'text' => $d->name
                );
            }
            echo json_encode($names);
      exit;
    }
}
