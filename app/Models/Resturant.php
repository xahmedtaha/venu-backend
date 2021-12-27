<?php

namespace App\Models;

use App\Traits\HasCommonTexts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

use Auth;
use Illuminate\Support\Facades\Storage;

class Resturant extends Model
{
    //
    use SoftDeletes,HasCommonTexts;

    protected $guarded = ['id'];

    public $appends = ['name','logo_url'];

    protected $casts = [
        'discount' => 'float',
        'vat_on_total' => 'integer',
        'vat_value' => 'float',
        'service' => 'float',
        'is_active' => 'integer',
    ];

    public $display_name = "";

    protected static function boot()
    {
        parent::boot();
        self::retrieved(function($resturant){
            if(Auth::guard('web')->check())
            {
                $resturant->display_name = Auth::user()->lang=='ar'?$resturant->name_ar:$resturant->name_en;
                // $resturant->attributes["name"] = Auth::user()->lang=='ar'?$resturant->name_ar:$resturant->name_en;
            }
        });

        self::deleted(function($resturant){
            $resturant->rates()->delete();
            $resturant->items()->delete();
        });

    }

    public function branches()
    {
        return $this->hasMany(Branch::class,'resturant_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,'resturants_categories');
    }

    public function images()
    {
        return $this->hasMany(ResturantImage::class);
    }

    public function itemCategories()
    {
        return $this->hasMany(ResturantItemCategory::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function owners()
    {
        return $this->hasMany(ResturantOwner::class);
    }

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function calculateRate()
    {
        $rates = $this->rates;
        if(count($rates))
        {
            $sum = $rates->sum('rate')+5;
            $rate = $sum / (count($rates)+1);
            return $rate;
        }
        else
        {
            return 5;
        }

    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function getLogoUrl()
    {
        return url(Storage::url($this->logo));
    }

    public function Place()
    {
        return $this->belongsTo(Place::class);
    }

    public function cities()
    {
        return $this->belongsToMany(City::class,'resturant_cities');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function visits()
    {
        return $this->hasMany(ResturantUserVisits::class);
    }

    public function getVisitsCount()
    {
        return $this->visits()->count();
    }

    public function getLogoUrlAttribute()
    {
        return url(Storage::url($this->logo));
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class)->withDefault();
    }

    public function itemLists()
    {
        return $this->hasMany(Lists::class);
    }
}
 