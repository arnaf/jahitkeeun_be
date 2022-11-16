<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'quantity','price', 'service_id', 'order_id',
        'photoClient1','photoClient2','photoClient3','photoClient4','photoClient5',
        'photoTaylor1','photoTaylor2','photoTaylor3','photoTaylor4','photoTaylor5',
    ];

    protected $hidden = [

    ];
}
