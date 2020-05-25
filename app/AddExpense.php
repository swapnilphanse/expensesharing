<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddExpense extends Model
{
    
    

    public $timestamps = false;

    protected  $primaryKey = 'expense_id';

   
    public $incrementing = false;

    
    protected $fillable = [
        'expense_id',
        'added_by',
        'name',
        'category',
        'amount',
        'ename',
        'type',
        'date',
        'split',
    ];


   
}
