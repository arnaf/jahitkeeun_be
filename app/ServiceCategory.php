<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $table = 'service_categories';
    protected $fillable = [
        'name','photo'
    ];

    protected $hidden = [

    ];

}
