<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adduser extends Model
{
    protected $table = 'contact';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        
        'userid',
        'contactid',
        
    ];


}
