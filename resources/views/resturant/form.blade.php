@extends('layouts.adminPanel.admin')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">اضافة مطعم</span>
            {{-- <span class="caption-helper">{{Translator::get('add_category_caption')}}</span> --}}
        </div>
        {{-- <div class="actions">
            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                <i class="icon-cloud-upload"></i>
            </a>
            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                <i class="icon-wrench"></i>
            </a>
            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                <i class="icon-trash"></i>
            </a>
        </div> --}}
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->

        <form action="{{isset($resturant->id) ? route('resturants.update',$resturant->id) : route('resturants.store')}}" enctype="multipart/form-data" class="form-horizontal" method="POST">
            <div class="form-body">
                 {{csrf_field() }}
                @isset($resturant->id)
                    @method('PUT')
                @endisset
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group col-md-12">
                    @error('is_active')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">Enable</label>
                    <div class="col-md-1">
                        <input type="checkbox" name="is_active" {{$resturant->is_active? "checked":""}} value="1" class="form-control">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">الاسم بالعربية</label>
                    <div class="col-md-8">
                        @error('name_ar')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="name_ar" value="{{old('name_ar',$resturant->name_ar)}}" required class="form-control" placeholder="الاسم بالعربية">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">الاسم بالانجليزية</label>
                    <div class="col-md-8">
                        @error('name_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="name_en" value="{{old('name_en',$resturant->name_en)}}" class="form-control" placeholder="الاسم بالانجليزية">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    @error('description_ar')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-4 control-label">الوصف بالعربية</label>
                    <div class="col-md-8">
                        <textarea name="description_ar" required class="form-control" id="" cols="30" rows="10">{{old('description_ar',$resturant->description_ar)}}</textarea>
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    @error('description_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-4 control-label">الوصف بالانجليزية</label>
                    <div class="col-md-8">
                        <textarea name="description_en" required class="form-control" id="" cols="30" rows="10">{{old('description_en',$resturant->description_en)}}</textarea>
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group col-md-6">

                    <label class="col-md-4 control-label"> لوجو المطعم </label>
                    <div class="col-md-8">
                        @error('logo')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="file" name="logo" id="customFile">
                        @if($resturant->id)
                        <label class="col-md-8 control-label">   لتعديل اللوجو قم باضافه صوره  </label>
                        @endif
                    </div>
                </div>
{{--                <div class="form-group col-md-6">--}}

{{--                    <label class="col-md-4 control-label"> صور المطعم </label>--}}
{{--                    <div class="col-md-8">--}}
{{--                        @error('images')--}}
{{--                            <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                        @enderror--}}
{{--                        <input type="file" name="images[]" multiple id="customFile">--}}
{{--                        @if($resturant->id)--}}
{{--                        <label class="col-md-8 control-label">   لتعديل الصوره قم باضافه صوره  </label>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}

                {{-- <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">{{Translator::get('place')}}</label>
                    <div class="col-md-8">
                        @error('place')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" required name="place" class="form-control" placeholder="{{Translator::get('place')}}">
                        <span class="help-block"> A block of help text. </span>
                    </div>
                </div> --}}

                {{-- <div class="form-horizontal">
                        <div class="form-group col-md-8 col-sm-12">
                            <label class="col-sm-1 control-label">Radius:</label>

                            <div class="col-sm-2">
                                <input type="text" name="map_radius" class="form-control" id="us2-radius" />
                            </div>
                        </div>
                    <div class="m-t-small">
                            <label class="p-r-small col-sm-2 control-label">{{Translator::get('select_location')}}</label>
                            <div class="form-group col-sm-4">
                                <input type="hidden" name="lat" class="form-control"  id="us2-lat" />
                            </div>
                            <label class="p-r-small col-sm-2 control-label">Long.:</label>
                            <div class="form-group col-sm-4">
                                <input type="hidden" name="long" class="form-control"  id="us2-lon" />
                            </div>
                        </div>
                    <div class="col-xs-offset-2" id="us2" style="width: 550px; height: 400px;"></div>
                    <div class="clearfix">&nbsp;</div>
;
                    <div class="clearfix"></div>
                </div>

                <!-- Location picker -->
                <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
                <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
                <script type="text/javascript" src='https://maps.google.com/maps/api/js?key=AIzaSyAQjWhZI8BLtadn3QU0PYhNLMjpkNUV8zg&sensor=true'></script>
                <script src="{{asset('mappicker/locationpicker.jquery.js')}}"></script>
                <script>
                    $('#us2').locationpicker({
                        location: {
                            latitude: 26.574093380827254,
                            longitude:31.737801551818848
                        },
                        radius: 300,
                        inputBinding: {
                            latitudeInput: $('#us2-lat'),
                            longitudeInput: $('#us2-lon'),
                            radiusInput: $('#us2-radius'),
                            locationNameInput: $('#us2-address')
                        },
                        enableAutocomplete: true
                    });
                </script> --}}

                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">(%)الخصم</label>
                    <div class="col-md-8">
                        @error('discount')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="number" required name="discount" value="{{old('discount',$resturant->discount)}}" class="form-control" >
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

                <div class="form-group col-md-12">
                        <label class="col-md-2">ساعات العمل</label>
                        <div class="form-group col-md-5">
                            <label class="col-md-4 control-label">من</label>
                            <div class="col-md-8">
                                @error('open_time')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <input type="time" required name="open_time" value="{{old('open_time',$resturant->open_time)}}" class="form-control" placeholder="{{Translator::get('open_time')}}">
                                {{-- <span class="help-block"> A block of help text. </span> --}}
                            </div>
                        </div>
                        <div class="form-group col-md-5">
                            <label class="col-md-4 control-label">الى</label>
                            <div class="col-md-8">
                                @error('close_time')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <input type="time" required name="close_time" value="{{old('close_time',$resturant->close_time)}}" class="form-control" placeholder="{{Translator::get('close_time')}}">
                                {{-- <span class="help-block"> A block of help text. </span> --}}
                            </div>
                        </div>
                    </div>

                </div>


                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">ضريبة قيمة مضافة</label>
                    <div class="col-md-8">
                        @error('vat_on_total')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        {{-- <input type="number" required name="" class="form-control" placeholder="{{Translator::get('vat_on_total')}}"> --}}
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline1" {{old('vat_on_total',$resturant->vat_on_total) == 1 ? 'checked' : ''}} value="1" name="vat_on_total" class="custom-control-input vat_radio">

                            <label class="custom-control-label"  for="customRadioInline1">نعم</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline2" {{old('vat_on_total',$resturant->vat_on_total) == 0 ? 'checked' : ''}} value="0" name="vat_on_total" class="custom-control-input vat_radio">

                            <label class="custom-control-label" for="customRadioInline2">لا</label>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-6" id="vat_value_div" style="{{$resturant->vat_on_total != 1?'display:none':''}}">
                    <label class="col-md-4 control-label">% قيمة الضريبة</label>
                    <div class="col-md-8">
                        @error('vat_value')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="number" {{old('vat_on_total',$resturant->vat_on_total) != 1?'disabled':''}} required id="vat_value" name="vat_value" value="{{old('vat_value',$resturant->vat_value)}}" class="form-control" placeholder="14">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">% قيمة الخدمة</label>
                    <div class="col-md-8">
                        @error('vat_value')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="number" name="service" value="{{old('service',$resturant->service)}}" class="form-control" placeholder="12">
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">رقم الهاتف</label>
                    <div class="col-md-8">
                        @error('phone_number')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="number" required name="phone_number" value="{{old('phone_number',$resturant->phone_number)}}" class="form-control" placeholder="{{Translator::get('phone_number')}}">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>


                {{-- /..................colors..................... --}}
                <div class="form-group col-md-12">
                    <h4>الالوان</h4>
                </div>
                <div class="form-group col-md-6">
                    <div class="col-md-8">
                        @error('drawer_icon_color')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="drawer_icon_color" value="{{old('drawer_icon_color',$colors->drawer_icon_color)}}" required class="form-control" placeholder="اللون ">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                    <label class="col-md-4 control-label"> Drawer icon color</label>
                </div>
                <div class="form-group col-md-6">
                    <div class="col-md-8">
                        @error('app_bar_color')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="app_bar_color" value="{{old('app_bar_color',$colors->app_bar_color)}}" required class="form-control" placeholder="اللون">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                    <label class="col-md-4 control-label">App bar color</label>
                </div>
                <div class="form-group col-md-6">
                    <div class="col-md-8">
                        @error('menu_word_color')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="menu_word_color" value="{{old('menu_word_color',$colors->menu_word_color)}}" required class="form-control" placeholder="اللون">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                    <label class="col-md-4 control-label">Menu word color</label>
                </div>
                <div class="form-group col-md-6">
                    <div class="col-md-8">
                        @error('cart_icon_color')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="cart_icon_color" value="{{old('cart_icon_color',$colors->cart_icon_color)}}" required class="form-control" placeholder="اللون">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                    <label class="col-md-4 control-label">Cart icon color</label>
                </div>
                <div class="form-group col-md-6">
                    <div class="col-md-8">
                        @error('cart_badge_color')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="cart_badge_color" value="{{old('cart_badge_color',$colors->cart_badge_color)}}" required class="form-control" placeholder="اللون">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                    <label class="col-md-4 control-label">Cart badge color</label>
                </div>
                <div class="form-group col-md-6">
                    <div class="col-md-8">
                        @error('cart_badge_text_color')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="cart_badge_text_color" value="{{old('cart_badge_text_color',$colors->cart_badge_text_color)}}" required class="form-control" placeholder="اللون">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                    <label class="col-md-4 control-label">Cart badge text color</label>
                </div>
                <div class="form-group col-md-6">
                    <div class="col-md-8">
                        @error('most_selling_text')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="most_selling_text" value="{{old('most_selling_text',$colors->most_selling_text)}}" required class="form-control" placeholder="اللون">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                    <label class="col-md-4 control-label">Most selling text</label>
                </div>
                <div class="form-group col-md-6">
                    <div class="col-md-8">
                        @error('menu_category_text')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="menu_category_text" value="{{old('menu_category_text',$colors->menu_category_text)}}" required class="form-control" placeholder="اللون">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                    <label class="col-md-4 control-label">Menu category text</label>
                </div>
                <div class="form-group col-md-6">
                    <div class="col-md-8">
                        @error('slider_picture_selection')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="slider_picture_selection" value="{{old('slider_picture_selection',$colors->slider_picture_selection)}}" required class="form-control" placeholder="اللون">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                    <label class="col-md-4 control-label">Slider picture selection</label>
                </div>
                <div class="form-group col-md-6">
                    <div class="col-md-8">
                        @error('price_text_color')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="price_text_color" value="{{old('price_text_color',$colors->price_text_color)}}" required class="form-control" placeholder="اللون">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                    <label class="col-md-4 control-label">Price text color</label>
                </div>
                <div class="form-group col-md-6">
                    <div class="col-md-8">
                        @error('action_button_color')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="action_button_color" value="{{old('action_button_color',$colors->action_button_color)}}" required class="form-control" placeholder="اللون">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                    <label class="col-md-4 control-label">Action button color</label>
                </div>
                <div class="form-group col-md-6">
                    <div class="col-md-8">
                        @error('selected_navigation_bar_color')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="selected_navigation_bar_color" value="{{old('selected_navigation_bar_color',$colors->selected_navigation_bar_color)}}" required class="form-control" placeholder="اللون">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                    <label class="col-md-4 control-label">Selected navigation bar color</label>
                </div>
                <div class="form-group col-md-6">
                    <div class="col-md-8">
                        @error('unselected_navigation_bar_color')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="unselected_navigation_bar_color" value="{{old('unselected_navigation_bar_color',$colors->unselected_navigation_bar_color)}}" required class="form-control" placeholder="اللون">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                    <label class="col-md-4 control-label">Unselected navigation bar color</label>
                </div>
                <div class="form-group col-md-6">
                    <div class="col-md-8">
                        @error('background_color')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="background_color" value="{{old('background_color',$colors->background_color)}}" required class="form-control" placeholder="اللون">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                    <label class="col-md-4 control-label">Background color</label>
                </div>



            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-5 col-md-6">
                        <button type="submit" class="btn green"><i class="fa fa-save"></i>حفظ</button>
                        <button type="reset" class="btn red"><i class="fa fa-close"></i>الغاء</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- END FORM-->
    </div>

</div>
@endsection
@section('javascript')
<script>
$(document).ready(function ()
{
    $('.vat_radio').click(function ()
    {
        let vat_flag = $("input[name='vat_on_total']");
        console.log(vat_flag);

        if(vat_flag.prop('checked')==false)
        {
            $('#vat_value').attr('disabled','true');
            // $('#vat_value').hide();
            $('#vat_value_div').hide();

        }
        else
        {
            $('#vat_value').removeAttr('disabled');
            // $('#vat_value').show();
            $('#vat_value_div').show();
        }
    });
});
</script>
@endsection
