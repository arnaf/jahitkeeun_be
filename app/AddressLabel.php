<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressLabel extends Model
{
    protected $table = 'address_labels';
    protected $fillable = [
        'name',
    ];

    protected $hidden = [

    ];

}
