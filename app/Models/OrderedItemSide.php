<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderedItemSide extends Model
{
    protected $guarded = ['id'];

    public $appends = ['name'];


    public function side()
    {
        return $this->belongsTo(ItemSide::class,'side_id');
    }

    public function getNameAttribute()
    {
        return $this->side->{'name_'.app()->getLocale()};
    }
}
