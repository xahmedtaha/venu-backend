<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatus extends Model
{
    //
    use SoftDeletes;

    public $guarded = ["id"];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
