<?php

namespace App;
use App\Admin;
use App\Client;
use App\Taylor;
use App\Convection;

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
        'name', 'email', 'password',
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

    public function taylor()
    {
        return $this->hasOne(Taylor::class);
    }

    public function convection()
    {
        return $this->hasOne(Convection::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }



}
