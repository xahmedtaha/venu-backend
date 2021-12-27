<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    //
    use SoftDeletes;
    public $guarded = ["id"];

    public function city()
    {
        return $this->belongsTo(City::class)->withTrashed();
    }
    public function place()
    {
        return $this->belongsTo(Place::class)->withTrashed();
    }
}
