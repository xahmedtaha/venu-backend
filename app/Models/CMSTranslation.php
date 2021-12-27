<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;



class CMSTranslation extends Model

{



    /**

     * The table associated with the model.

     *

     * @var string

     */

    public $timestamps = false;

    protected $table = 'admin_translation';

    protected $fillable = ['lang_code', 'langkey', 'text',];







public static function getmainlang($langkey) {

              $db_query = DB::table('admin_translation')->where('lang_code','en')->where('langkey',$langkey)->first(); 

               if($db_query){

              	 return $db_query->text;

              }else {

              	 return false;

              }  

 

}















}