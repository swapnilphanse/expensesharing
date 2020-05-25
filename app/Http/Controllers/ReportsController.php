<?php

namespace App\Http\Controllers;

use DB;
use Auth;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function Chartjs(){


        $id = Auth::user()->id;

        $record = DB::table('iexpense')
                ->select(DB::raw("SUM(iamount) as count"),'date')
                ->join('add_expenses', 'add_expenses.expense_id','=','iexpense.expense_id')
                ->where('iexpense.user_id','=',$id)
                ->where('add_expenses.category','=','Miscellaneous')
                ->orderBy("date")
                ->groupBy(DB::raw("MONTH(date)"))
                ->get()->toArray();
                
                $record = array_column($record, 'count');
                
                  // return view('reports')
                  // ->with('record',json_encode($record,JSON_NUMERIC_CHECK)); 
                  
                  


        $record4 = DB::table('iexpense')
                ->select(DB::raw("SUM(iamount) as count"),'date')
                ->join('add_expenses', 'add_expenses.expense_id','=','iexpense.expense_id')
                ->where('iexpense.user_id','=',$id)
                ->where('add_expenses.category','=','Fees')
                ->orderBy("date")
                ->groupBy(DB::raw("MONTH(date)"))
                ->get()->toArray();
                
                $record4 = array_column($record4, 'count');
                
                  return view('reports')
                  ->with('record','record4',json_encode(array($record,$record4),JSON_NUMERIC_CHECK)); 

      }
}
