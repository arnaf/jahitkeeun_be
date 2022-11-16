<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'name', 'photo', 'addressFrom','addressTo', 'price'
    ];

    protected $hidden = [

    ];
}
