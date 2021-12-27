<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Auth;

class City extends Model
{
    use SoftDeletes;
    
    protected $guarded = ['id'];

    public $display_name = "";

    protected static function boot()
    {
        parent::boot();
        self::retrieved(function($city){
            if(Auth::guard('web')->check())
            {
                $city->display_name = Auth::user()->lang=='ar'?$city->name_ar:$city->name_en;
            }
        });
        
    }


    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function resturants()
    {
        return $this->belongsToMany(Resturant::class,'resturant_cities');
    }
}
