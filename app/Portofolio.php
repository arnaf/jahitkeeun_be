<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    protected $fillable = [
        'desc', 'photo1', 'photo2', 'photo3', 'photo4', 'photo5', 'taylor_id'
    ];

    protected $hidden = [

    ];
    
}
