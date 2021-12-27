<?php

namespace App\Http\Controllers;

use App\Models\Resturant;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Place;
use App\Models\Rate;
use App\Models\Theme;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\json_encode;
use Auth;
use Google\Cloud\Storage\Connection\Rest;

class ResturantController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view resturants'])->only(['index']);
        $this->middleware(['permission:add resturants'])->only(['create','store']);
        $this->middleware(['permission:update resturants'])->only(['edit','update']);
        $this->middleware(['permission:delete resturants'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $resturants = Auth::user()->getResturants();
        return view('resturant.all',compact('resturants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $resturant = new Resturant();
        $colors    = new Theme;
        return view('resturant.form',compact('resturant','colors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validationRules = [
            "name_ar"         => "required",
            "open_time"       => "required",
            "close_time"      => "required",
            "vat_on_total"    => "required",
            "phone_number"    => "required",
            "description_ar"  => "required",
            "description_en"  => "required",
            "logo"            => "required",
            "discount"        => "required",
            "primary_color"   => "size:6",
            "accent_color"    => "size:6",
            "drawer_icon_color"               => "required",
            "app_bar_color"                   => "required",
            "menu_word_color"                 => "required",
            "cart_icon_color"                 => "required",
            "cart_badge_color"                => "required",
            "cart_badge_text_color"           => "required",
            "most_selling_text"               => "required",
            "menu_category_text"              => "required",
            "slider_picture_selection"        => "required",
            "price_text_color"                => "required",
            "action_button_color"             => "required",
            "selected_navigation_bar_color"   => "required",
            "unselected_navigation_bar_color" => "required",
            "background_color"                => "required"
        ];
        if($request->hasFile('images'))
        {
            for($i=0;$i<count($request->images);$i++)
            {
                $validationRules["images.".$i] = 'mimes:jpeg,bmp,png';
            }
        }
        $validator = Validator::make($request->all(),$validationRules,[

        ]);

        if($validator->fails())
        {
            return Redirect::back()->withInput(Input::all())->withErrors($validator->errors());
        }

        $colorsArr=[
            "app_bar_color"                   => $request->app_bar_color,
            "drawer_icon_color"               => $request->drawer_icon_color,
            "menu_word_color"                 => $request->menu_word_color,
            "cart_icon_color"                 => $request->cart_icon_color,
            "cart_badge_color"                => $request->cart_badge_color,
            "cart_badge_text_color"           => $request->cart_badge_text_color,
            "most_selling_text"               => $request->most_selling_text,
            "menu_category_text"              => $request->menu_category_text,
            "slider_picture_selection"        => $request->slider_picture_selection,
            "price_text_color"                => $request->price_text_color,
            "action_button_color"             => $request->action_button_color,
            "selected_navigation_bar_color"   => $request->selected_navigation_bar_color,
            "unselected_navigation_bar_color" => $request->unselected_navigation_bar_color,
            "background_color"                => $request->background_color
        ];
        $colors = Theme::create($colorsArr);

        $resturant = Resturant::create($request->
                                except('categories',
                                        'cities',
                                        'images',
                                        'drawer_icon_color',
                                        'app_bar_color',
                                        'menu_word_color',
                                        'cart_icon_color',
                                        'cart_badge_color',
                                        'cart_badge_text_color',
                                        'most_selling_text',
                                        'menu_category_text',
                                        'slider_picture_selection',
                                        'price_text_color',
                                        'action_button_color',
                                        'selected_navigation_bar_color',
                                        'unselected_navigation_bar_color',
                                        'background_color'
                                        ));

        if($request->hasFile('images'))
        {
            foreach($request->images as $image)
            {
                $imageFile = $image->store('public/resturant_images');
                $resturant->images()->create(['image'=>$imageFile]);
            }
        }
        if($request->hasFile('logo'))
        {
            $logoFile = $request->logo->store('public/resturant_images');
            $resturant->update(["logo"=>$logoFile]);
        }
        $resturant->theme_id = $colors->id;
        $resturant->save();


        return redirect()->route('resturants.index')->withSuccess('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Resturant  $resturant
     * @return \Illuminate\Http\Response
     */
    public function show(Resturant $resturant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Resturant  $resturant
     * @return \Illuminate\Http\Response
     */
    public function edit(Resturant $resturant)
    {
        $colors = $resturant->theme;
        if(Auth::user()->level!="SuperAdmin")
        {
            if(!Auth::user()->resturants->contains($resturant->id))
                return "";
        }

        return view('resturant.form',compact('resturant','colors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Resturant  $resturant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resturant $resturant)
    {
        //Validation

        $validationRules = [
            "name_ar"         => "required",
            "open_time"       => "required",
            "close_time"      => "required",
            "vat_on_total"    => "required",
            "phone_number"    => "required",
            "description_ar"  => "required",
            "description_en"  => "required",
            "discount"        => "required",
            "drawer_icon_color"               => "required",
            "app_bar_color"                   => "required",
            "menu_word_color"                 => "required",
            "cart_icon_color"                 => "required",
            "cart_badge_color"                => "required",
            "cart_badge_text_color"           => "required",
            "most_selling_text"               => "required",
            "menu_category_text"              => "required",
            "slider_picture_selection"        => "required",
            "price_text_color"                => "required",
            "action_button_color"             => "required",
            "selected_navigation_bar_color"   => "required",
            "unselected_navigation_bar_color" => "required",
            "background_color"                => "required"
        ];
        if($request->hasFile('images'))
        {
            for($i=0;$i<count($request->images);$i++)
            {
                $validationRules["images.".$i] = 'mimes:jpeg,bmp,png';
            }
        }

        $validator = Validator::make($request->all(),$validationRules,[

        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }

        $colorsArr=[
            "app_bar_color"                   => $request->app_bar_color,
            "drawer_icon_color"               => $request->drawer_icon_color,
            "menu_word_color"                 => $request->menu_word_color,
            "cart_icon_color"                 => $request->cart_icon_color,
            "cart_badge_color"                => $request->cart_badge_color,
            "cart_badge_text_color"           => $request->cart_badge_text_color,
            "most_selling_text"               => $request->most_selling_text,
            "menu_category_text"              => $request->menu_category_text,
            "slider_picture_selection"        => $request->slider_picture_selection,
            "price_text_color"                => $request->price_text_color,
            "action_button_color"             => $request->action_button_color,
            "selected_navigation_bar_color"   => $request->selected_navigation_bar_color,
            "unselected_navigation_bar_color" => $request->unselected_navigation_bar_color,
            "background_color"                => $request->background_color
        ];

        $colors = Theme::find($resturant->theme_id);
        $colors->update($colorsArr);
        $resturant->update($request->except('categories',
                                            'cities',
                                            'images',
                                            'drawer_icon_color',
                                            'app_bar_color',
                                            'menu_word_color',
                                            'cart_icon_color',
                                            'cart_badge_color',
                                            'cart_badge_text_color',
                                            'most_selling_text',
                                            'menu_category_text',
                                            'slider_picture_selection',
                                            'price_text_color',
                                            'action_button_color',
                                            'selected_navigation_bar_color',
                                            'unselected_navigation_bar_color',
                                            'background_color'
                                            ));

        if($request->hasFile('images'))
        {
            foreach($request->images as $image)
            {
                $imageFile = $image->store('resturant_images');
                $resturant->images()->create(['image'=>$imageFile]);
            }
        }

        if($request->hasFile('logo'))
        {
            $logoFile = $request->logo->store('resturant_images');
            $resturant->update(["logo"=>$logoFile]);
        }

        return bacK()->withSuccess('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Resturant  $resturant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resturant $resturant)
    {
        //
        $resturant->notifications()->delete();
        $resturant->delete();
        return back();
    }

    public function reviews()
    {
        $rates = Rate::all();
        return view('resturant.reviews',compact('rates'));
    }

    public function getCategories(Request $request)
    {
        $resturant = Resturant::find($request->resturant_id);
        $categories = $resturant->itemCategories;
        // dd($categories);
        $display_name = Auth::user()->lang=='ar'?'name_ar':'name_en';
        foreach($categories as $category)
        {
            $category["display_name"] = $category->$display_name;
        }
        return response()->json($categories,200);
    }
}
