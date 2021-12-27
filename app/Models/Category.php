<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Auth;
class Category extends Model
{
    //
    use SoftDeletes,HasTranslations;
    public $display_name = "";
    protected $guarded = ['id','display_name'];
    public $fillable = ['name_ar','name_en'];
    public $translatable = ['name'];

    protected static function boot()
    {
        parent::boot();
        self::retrieved(function($category){
            if(Auth::guard('web')->check())
                $category->display_name = Auth::user()->lang=='ar'?$category->name_ar:$category->name_en;
        });
    }

    public function resturants()
    {
        return $this->belongsToMany(Resturant::class,'resturants_categories');
    }
}
