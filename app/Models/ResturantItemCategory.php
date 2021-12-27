<?php

namespace App\Models;

use App\Traits\HasCommonTexts;
use Illuminate\Database\Eloquent\Model;
use Auth;

class ResturantItemCategory extends Model
{
    use HasCommonTexts;

    public $guarded = ['id'];
    
    protected $casts = [
        'resturant_id' => 'integer',
    ];

    public $appends = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class,'category_id');
    }

    public function resturant()
    {
        return $this->belongsTo(Resturant::class);
    }
}
