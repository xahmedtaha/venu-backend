<?php

namespace App\Models;

use App\Traits\HasCommonTexts;
use Illuminate\Database\Eloquent\Model;

class ItemSide extends Model
{
    use HasCommonTexts;
    protected $guarded = ['id'];
    public $appends = ['name'];

}
