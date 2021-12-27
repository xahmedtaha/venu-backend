<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Auth;

class Place extends Model
{
    use SoftDeletes;
    protected $guarded = ["id"];

    public $display_name = "";

    protected static function boot()
    {
        parent::boot();
        self::retrieved(function($place){
            if(Auth::guard('web')->check())
            {
                $place->display_name = Auth::user()->lang=='ar'?$place->name_ar:$place->name_en;
            }
        });
        
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
