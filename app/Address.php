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

    public function province()
    {
        return $this->hasOne(Province::class);
    }

    public function regency()
    {
        return $this->hasOne(Regency::class);
    }

    public function district()
    {
        return $this->hasOne(District::class);
    }

    public function village()
    {
        return $this->hasOne(Village::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

}
