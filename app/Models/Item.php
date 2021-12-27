<?php

namespace App\Models;

use App\Traits\HasCommonTexts;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Item extends Model
{
    //
    use SoftDeletes,HasCommonTexts;

    protected $guarded = ["id"];

    public $appends = ['name','images_url','desc'];

    public function lists()
    {
        return $this->belongsToMany(Lists::class,'list_items','list_id','item_id');
    }

    public function resturant()
    {
        return $this->belongsTo(Resturant::class);
    }

    public function images()
    {
        return $this->hasMany(ItemImage::class);
    }

    public function category()
    {
        return $this->belongsTo(ResturantItemCategory::class,"category_id")->withDefault();
    }

    public function getImagesUrlAttribute()
    {
        $imagesArr = array();
        foreach($this->images as $image)
        {
            $imageUrl = $image->full_url;
            array_push($imagesArr,$imageUrl);
        }
        return $imagesArr;
    }


    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

    public function sides()
    {
        return $this->hasMany(ItemSide::class);
    }

    public function isAvailableAtBranch($branchId)
    {
        return $this->branches()->where('branch_id',$branchId)->first()->is_available ?? true;
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class,'branch_items','item_id','branch_id')
                    ->withPivot(['is_available']);
    }

    public function scopeBranch(Builder $query,$branchId)
    {
       return $query->join('branch_items',function ($joinQuery) use ($branchId) {
                    $joinQuery->on('items.id','=','branch_items.item_id')->where('branch_items.branch_id','=',$branchId);
               })->select('items.*','branch_items.is_available','branch_items.branch_id');
    }

    public function attachToResturantBranches()
    {
        $branches = $this->resturant->branches()->pluck('id')->toArray();
        $this->branches()->attach($branches);
    }
}
