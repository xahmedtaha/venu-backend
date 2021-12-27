<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    //
    protected $guarded = ["id"];
    
    public function product()
    {
        return $this->belongsTo(SubProduct::class,'product_id')->withTrashed();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

