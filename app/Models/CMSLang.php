<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CMSLang extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'admin_lang';
    protected $fillable = ['code', 'name', 'dir','is_main',];

}
