<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable
{
    use HasRoles,Notifiable,SoftDeletes,HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','level'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $guard_name = 'web';
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getResturants()
    {
        if($this->level=="SuperAdmin")
            return Resturant::all();
        else
            return $this->resturants;
    }
    public function getResturantsQuery()
    {
        if($this->level=="SuperAdmin")
            return Resturant::query();
        else
            return $this->resturants()->getQuery();
    }

    public function resturants()
    {
        return $this->belongsToMany(Resturant::class,'employee_resturants','employee_id','resturant_id');
    }

    public function getItems()
    {
        if($this->level=="SuperAdmin")
            return Item::all();
        else
            return Item::query()->whereIn('resturant_id',$this->resturants()->pluck('resturants.id')->toArray())->get();
    }

}
