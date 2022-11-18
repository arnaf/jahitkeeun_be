<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name', 'price', 'service_categories_id', 'taylor_id'
    ];

    protected $hidden = [

    ];

    public function service_categories()
    {
        return $this->hasOne(ServiceCategory::class);
    }

    public function taylor()
    {
        return $this->hasMany(Taylor::class);
    }
}
