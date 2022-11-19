<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaklunApplies extends Model
{
    protected $fillable = [
        'status', 'bid', 'taylor_id', 'maklun_id'
    ];

    protected $hidden = [

    ];

   
}
