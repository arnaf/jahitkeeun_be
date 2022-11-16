<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'invoice', 'totalPayment', 'paymentStatus', 'order_status','address',
        'estimationDate','deliveries_id','payment_method_id','shipping_method_id',
        'user_id'
    ];

    protected $hidden = [

    ];
}
