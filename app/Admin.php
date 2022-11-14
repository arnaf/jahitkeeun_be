<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'dateBirth', 'placeBirth', 'photo', 'user_id', 'phone', 'status',
    ];

    protected $hidden = [

    ];
}
