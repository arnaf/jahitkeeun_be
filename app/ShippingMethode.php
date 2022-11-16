<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingMethode extends Model
{
    protected $table = 'shipping_methods';
    protected $fillable = [
        'name','photo'
    ];

    protected $hidden = [

    ];

}
