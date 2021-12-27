<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class UserFeedbackReason extends Model
{
    use SoftDeletes;
    public $display_name = "";
    public $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();
        self::retrieved(function($reason)
        {
            if(Auth::guard('web')->check())
            {
                $reason->display_name = Auth::user()->lang=='ar'?$reason->name_ar:$reason->name_en;
                // $resturant->attributes["name"] = Auth::user()->lang=='ar'?$resturant->name_ar:$resturant->name_en;
            }
        });
    }
}
