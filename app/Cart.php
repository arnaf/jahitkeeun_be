<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'quantity', 'service_id', 'user_id'
    ];

    protected $hidden = [

    ];
}
