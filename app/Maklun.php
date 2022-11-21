<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maklun extends Model
{
    protected $fillable = [
        'title', 'desc', 'price', 'dueTime','status', 'maklun_maker_id'
    ];

    protected $hidden = [

    ];


    public function maklunApply()
    {
        return $this->hasMany(MaklunApplies::class);
    }
}
