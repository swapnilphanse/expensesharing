<?php

namespace App\Http\Controllers;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {


         $id = Auth::user()->id;
        
       
        $record = DB::table('iexpense')
        ->select(DB::raw("SUM(iamount) as count"),'date')
        ->join('add_expenses', 'add_expenses.expense_id','=','iexpense.expense_id')
        ->where('iexpense.user_id','=',$id)
        ->orderBy("date")
        ->groupBy(DB::raw("MONTH(date)"))
        ->get()->toArray();

        
        $record = array_column($record, 'count');
     
         

        $data = DB::table('add_expenses')
                ->join('iexpense','iexpense.expense_id','=','add_expenses.expense_id')
                ->select('add_expenses.expense_id','add_expenses.ename','add_expenses.category','add_expenses.type','add_expenses.amount','add_expenses.date','iexpense.paid_by')
                ->where('iexpense.user_id','=',$id)
                ->get();

        return view('dashboard',compact('data'))
        ->with('record',json_encode($record,JSON_NUMERIC_CHECK));
    }

    

}
