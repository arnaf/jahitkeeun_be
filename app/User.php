<?php

namespace App;
use App\Admin;
use App\Service;
use App\Client;
use App\Taylor;
use App\Convection;
use App\Address;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected $guard_name = 'api';


    public function client()
    {
        return $this->hasOne(Client::class);
    }

    // public function service()
    // {
    //     return $this->hasOneThrough(Taylor::class, Service::class,'');
    // }

    public function convection()
    {
        return $this->hasOne(Convection::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function address()
    {
        return $this->hasMany(Address::class);
    }

    public function cart()
    {
        return $this->belongsToMany(Service::class, 'carts')->withPivot('quantity');

    }



}
