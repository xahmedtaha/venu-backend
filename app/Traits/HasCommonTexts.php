<?php

namespace App\Traits;

trait HasCommonTexts
{
    public function getNameAttribute()
    {
        return $this->{'name_'.app()->getLocale()};
    }

    public function getDescAttribute()
    {
        return $this->{'description_'.app()->getLocale()};
    }
}
