<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class ResturantImage extends Model
{
    //
    protected $fillable = ['image'];

    public $appends = ['full_url'];

    public function getFullUrlAttribute()
    {
        return url(Storage::url($this->logo));
    }
}
