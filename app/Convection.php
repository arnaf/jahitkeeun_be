<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convection extends Model
{
    protected $fillable = [
        'dateBirth', 'placeBirth', 'photo', 'user_id', 'phone', 'status',
    ];

    protected $hidden = [

    ];
}
