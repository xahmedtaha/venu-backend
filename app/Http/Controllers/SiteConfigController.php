<?php

namespace App\Http\Controllers;

use App\Models\SiteConfig;
use Illuminate\Http\Request;

class SiteConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view terms'])->only(['create']);
        $this->middleware(['permission:update terms'])->only(['store']);
    }
    public function create()
    {
        $terms_ar = SiteConfig::find("terms_ar");
        $terms_en = SiteConfig::find("terms_en");
        return view('termsAndConditions.terms',compact('terms_ar','terms_en'));
    }

    public function store(Request $request)
    {
        $terms_ar = SiteConfig::find("terms_ar");
        $terms_en = SiteConfig::find("terms_en");
        if($terms_ar)
        {
            $terms_ar->value = $request->terms_ar;
        }
        else
        {
            $terms_ar = new SiteConfig();
            $terms_ar->key = "terms_ar";
            $terms_ar->value = $request->terms_ar;
            $terms_ar->save();
        }

        if($terms_en)
        {
            $terms_en->value = $request->terms_en;
        }
        else
        {
            $terms_en = new SiteConfig();
            $terms_en->key = "terms_en";
            $terms_en->value = $request->terms_en;
            $terms_en->save();
        }


        return back();
    }
}
