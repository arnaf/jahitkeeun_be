<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name', 'price', 'service_categories_id', 'taylor_id'
    ];

    protected $hidden = [

    ];
}
