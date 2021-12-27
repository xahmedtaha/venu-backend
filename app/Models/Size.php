<?php

namespace App\Models;

use App\Models\SubProductImage;
use App\Traits\HasCommonTexts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class Size extends Model
{
    use SoftDeletes,HasCommonTexts;

    public $guarded = ['id'];

    public $appends = ['name','desc'];

    public function images()
    {
        return $this->hasMany(SubProductImage::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function getImagesUrlArr()
    {
        $imagesArr = array();
        foreach($this->images as $image)
        {
            $imageUrl = env("APP_URL")."api/getPhoto/".$image->image;
            array_push($imagesArr,$imageUrl);
        }
        return $imagesArr;
    }
}
