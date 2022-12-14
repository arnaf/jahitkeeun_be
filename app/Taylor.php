<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taylor extends Model
{
    protected $fillable = [
        'dateBirth', 'placeBirth', 'photo', 'user_id', 'phone', 'status', 'rating', 'completedTrans'
    ];

    protected $hidden = [

    ];

    public function maklunApply()
    {
        return $this->hasMany(MaklunApplies::class);
    }

}
