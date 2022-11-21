<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaklunApplies extends Model
{
    protected $fillable = [
        'status', 'bid', 'taylor_id', 'maklun_id', 'desc'
    ];

    protected $hidden = [

    ];

    public function taylor()
    {
        return $this->hasOne(Taylor::class);
    }

    public function maklun()
    {
        return $this->hasOne(Maklun::class);
    }


}
