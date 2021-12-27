<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteConfig extends Model
{
    protected $primaryKey = 'key';
    protected $guarded = [];

    public static function getValue($key)
    {
        $conf = static::find($key);
        return $conf->value ?? null;
    }

    public static function get($key)
    {
        $conf = static::find($key);
        return $conf;
    }

    public static function set($key,$value)
    {
        $conf = static::find($key);
        if($conf)
        {
            $conf->update(['value'=>$value]);
        }
        else
        {
            $conf = static::create(['key'=>$key,'value'=>$value]);
        }
    }
}
