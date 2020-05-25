<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\AddExpense;
use App\IExpense;
use Carbon\Carbon;

class AddExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expense.addexpense');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            
            'name' => ['required'],
            'amount' => ['required','numeric'],
            'category' =>['required'],
            'split' => ['required'],
            'ename' => ['required','string','min:5']
    ]);

    
        $split = $request->input('split');
        $names = $request->input('name');
        $currentuserid = array_push($names,Auth::user()->id);

        if($split == '50%') {

            $newamount = $request->input('amount')/count($names);
        
            $type = 'half';
        
        }
       
        $exp_id = rand(0,100000);

        $addexpense = new AddExpense ([

        'expense_id' =>  $exp_id,
        'added_by' => Auth::user()->id,
        'amount' => $request->input('amount'),
        'category' => $request->input('category'),
        'type' => $type,
        'ename' =>  $request->input('ename'),
        'date' => date('Y-m-d H:i:s'),

        ]);

       
        $addexpense->save();
        
        $expid = AddExpense::find($exp_id);

        
         for($i = 0;$i <count($names);$i++) { 

                
                if($expid->added_by == $names[$i]){
                
               
                  $iexpense = new IExpense ([

                    'expense_id' => $exp_id,
                    'user_id'=>$names[$i],
                    'iamount'=>$newamount,
                    'paid_by'=>true,

                  ]);

                }

                else {
                
                    $iexpense = new IExpense ([

                        'expense_id' => $exp_id,
                        'user_id'=>$names[$i],
                        'iamount'=>$newamount,
                        'paid_by'=>false,
    
                      ]);

               

                }
               
                $iexpense->save();
        }
       // dd('Expense Added Successfully');
       return back()->withStatus(__('Expense added successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $data = DB::table('add_expenses')
        ->join('iexpense','iexpense.expense_id','=','add_expenses.expense_id')
        ->join('users','users.id','=','iexpense.user_id')
        ->select('users.id','users.name','iexpense.iamount','add_expenses.amount','add_expenses.category','add_expenses.ename','add_expenses.added_by','iexpense.paid_by')
        ->where('add_expenses.expense_id', '=',$id)
        //->where('expense.settled','=',false)
        ->get();

        return view('viewexpense',compact('data'));
    }

   
}
