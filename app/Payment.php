<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'paymentAmount',
        'order_id'
    ];

    protected $hidden = [

    ];
}
