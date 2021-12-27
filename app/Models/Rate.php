<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends Model
{
    protected $guarded = ['id'];
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resturant()
    {
        return $this->belongsTo(Resturant::class);
    }

}
