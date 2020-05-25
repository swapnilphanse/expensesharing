<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IExpense extends Model
{
        public $timestamps = false;

        protected $table = 'iexpense';

        protected $fillable = [

            'expense_id',
            'user_id',
            'iamount',
            'paid_by'
        ];

}
