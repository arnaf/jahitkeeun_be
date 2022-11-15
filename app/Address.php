<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'fullAddress', 'posCode', 'province_id', 'regency_id', 'district_id', 'village_id', 'lat', 'long', 'addresslabel_id', 'user_id'
    ];

    protected $hidden = [

    ];

    public function addressLabel()
    {
        return $this->hasOne(AaddressLabel::class);
    }

}
