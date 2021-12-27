<?php

namespace App\Helpers; 

use Session;

use Auth;

use App\Models\CMSTranslation;

use App\Models\SiteLang;

class Translator {



    public static function get($langkey){ 

            //echo  Auth::user()->name;      

            // $current_lang = config('user_lang');  
            // $is_live_lang = session('cmslangcode'); 
            $code = 'ar';
            if(Auth::check()){
                $code = Auth::user()->lang;
            }
            // $cmslang =  CMSTranslation::where('lang_code','ar')->where('langkey',$langkey)->first();
            $cmslang = CMSTranslation::where('lang_code',$code)->where('langkey',$langkey)->first();
            if ($cmslang) {
                 return $cmslang->text;  
            }else{
                return false;
            } 
    }

    public static function getlangname($langcode=NULL){  
            $langname =  SiteLang::where('code',$langcode)->first(); 
            if ($langname) {
            	 return $langname->name;  
            }else{
            	return false;
            } 

    }

}