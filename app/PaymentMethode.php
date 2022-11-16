<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethode extends Model
{
    protected $table = 'payment_methods';
    protected $fillable = [
        'name','photo'
    ];

    protected $hidden = [

    ];

}
