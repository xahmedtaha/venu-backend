<?php

namespace App\Models;

use App\Traits\HasCommonTexts;
use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    use HasCommonTexts;
    protected $guarded = ['id'];
    protected $appends = ['name'];

    public function items()
    {
        return $this->belongsToMany(Item::class,'list_items','list_id','item_id');
    }

}

