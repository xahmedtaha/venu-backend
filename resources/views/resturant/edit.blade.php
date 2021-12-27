@extends('layouts.adminPanel.admin')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">{{Translator::get('add_resturant')}}</span>
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
        <form action="{{route('resturants.update',$resturant->id)}}" enctype="multipart/form-data" class="form-horizontal" method="POST">
            <div class="form-body">
                {{ csrf_field() }}
                @method('PUT')

                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">الاسم بالعربية</label>
                    <div class="col-md-8">
                        @error('name_ar')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" value="{{$resturant->name_ar}}" name="name_ar" required class="form-control" placeholder="الاسم بالعربية">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">الاسم بالانجيليزية</label>
                    <div class="col-md-8">
                        @error('name_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" value="{{$resturant->name_en}}" name="name_en" class="form-control" placeholder="الاسم بالانجيليزية">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group">
                    @error('description_ar')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">الوصف بالعربية</label>
                    <div class="col-md-4">
                        <textarea name="description_ar" required class="form-control" id="" cols="30" rows="10">{{$resturant->description_ar}}</textarea>
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group">
                    @error('description_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">الوصف بالانجليزية</label>
                    <div class="col-md-4">
                        <textarea name="description_en" required class="form-control" id="" cols="30" rows="10">{{$resturant->description_en}}</textarea>
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group">

                    <label class="col-md-2 control-label"> {{Translator::get('resturant_logo')}} </label>
                    <div class="col-md-6">
                        @error('logo')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="file" name="logo" multiple id="customFile">
                    </div>
                </div>
                <div class="form-group">

                    <label class="col-md-2 control-label"> {{Translator::get('resturant_images')}} </label>
                    <div class="col-md-6">
                        @error('images')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="file" name="images[]" multiple id="customFile">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">{{Translator::get('category')}}</label>
                    <div class="col-md-8">
                        @error('category_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <select name="categories[]" multiple required class="form-control select2" id="">
                            @foreach ($categories as $category)
                                <option {{$resturant->categories->contains('id',$category->id)?'selected':''}} value="{{$category->id}}">{{$category->display_name}}</option>
                            @endforeach
                        </select>
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">المدينة</label>
                    <div class="col-md-8">
                        @error('place')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <select name="place_id" required id="places" class="form-control">
                            @foreach ($places as $place)
                                <option {{$resturant->place_id == $place->id? 'selected':''}} value="{{$place->id}}">{{$place->display_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">المكان</label>
                    <div class="col-md-8">
                        @error('place')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <select name="cities[]" multiple required id="cities" class="form-control select2">
                            @foreach ($cities as $city)
                                <option {{$resturant->cities->contains('id',$city->id) ? 'selected':''}} value="{{$city->id}}">{{$city->display_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">{{Translator::get('place')}}</label>
                    <div class="col-md-8">
                        @error('place')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" value="{{$resturant->place}}" required name="place" class="form-control" placeholder="{{Translator::get('place')}}">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

                <div class="form-horizontal">
                        {{-- <div class="form-group col-md-8 col-sm-12">
                            <label class="col-sm-1 control-label">Radius:</label>

                            <div class="col-sm-2">
                                <input type="text" name="map_radius" class="form-control" id="us2-radius" />
                            </div>
                        </div> --}}
                        <div class="m-t-small">
                                <label class="p-r-small col-sm-2 control-label">{{Translator::get('select_location')}}</label>
                                <div class="form-group col-sm-4">
                                    <input type="hidden" name="lat" class="form-control"  id="us2-lat" />
                                </div>
                                {{-- <label class="p-r-small col-sm-2 control-label">Long.:</label> --}}
                                <div class="form-group col-sm-4">
                                    <input type="hidden" name="long" class="form-control"  id="us2-lon" />
                                </div>
                            </div>
                        <div class="col-xs-offset-2" id="us2" style="width: 550px; height: 400px;"></div>
                        <div class="clearfix">&nbsp;</div>

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
                                latitude: {{$resturant->lat}},
                                longitude:{{$resturant->long}}
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
                    </script>

                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">{{Translator::get('delivery_time')}}</label>
                    <div class="col-md-8">
                        @error('delivery_time')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="number" value="{{$resturant->delivery_time}}" required name="delivery_time" class="form-control" placeholder="{{Translator::get('delivery_time')}}">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">تكلفة الديليفيرى</label>
                    <div class="col-md-8">
                        @error('delivery_cost')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="number" value="{{$resturant->delivery_cost}}" required name="delivery_cost" class="form-control" placeholder="{{Translator::get('delivery_time')}}">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">(%)الخصم</label>
                    <div class="col-md-8">
                        @error('discount')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="number" value="{{$resturant->discount}}" required name="discount" class="form-control" >
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">{{Translator::get('open_time')}}</label>
                    <div class="col-md-8">
                        @error('open_time')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="time" required value="{{$resturant->open_time}}" name="open_time" class="form-control" placeholder="{{Translator::get('open_time')}}">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">{{Translator::get('close_time')}}</label>
                    <div class="col-md-8">
                        @error('close_time')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="time" required value="{{$resturant->close_time}}" name="close_time" class="form-control" placeholder="{{Translator::get('close_time')}}">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">{{Translator::get('vat_on_total')}}</label>
                    <div class="col-md-8">
                        @error('vat_on_total')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        {{-- <input type="number" required name="" class="form-control" placeholder="{{Translator::get('vat_on_total')}}"> --}}
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline1" {{$resturant->vat_on_total=='1'?'checked':''}} value="1" name="vat_on_total" class="custom-control-input vat_radio">

                            <label class="custom-control-label"  for="customRadioInline1">{{Translator::get('yes')}}</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline2" {{$resturant->vat_on_total=='0'?'checked':''}} value="0" name="vat_on_total" class="custom-control-input vat_radio">

                            <label class="custom-control-label" for="customRadioInline2">{{Translator::get('no')}}</label>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-6" @if($resturant->vat_on_total==0)style="display:none"@endif id="vat_value_div">
                    <label class="col-md-4 control-label">{{Translator::get('vat_value')}}</label>
                    <div class="col-md-8">
                        @error('vat_value')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="number" id="vat_value" value="{{$resturant->vat_value}}" required name="vat_value" class="form-control" placeholder="{{Translator::get('vat_value')}}">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">{{Translator::get('phone_number')}}</label>
                    <div class="col-md-8">
                        @error('phone_number')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="number" required value="{{$resturant->phone_number}}"  name="phone_number" class="form-control" placeholder="{{Translator::get('phone_number')}}">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>



            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-5 col-md-6">
                        <button type="submit" class="btn green"><i class="fa fa-save"></i>حفظ</button>
                        <a href="" class="btn red"><i class="fa fa-close"></i>الغاء</a>
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
    $('#places').change(function ()
    {
        var place_id = $("#places").val();
        $.get("{{url('/admin/places/')}}/"+place_id,
        function (data)
        {
            var cities = $("#cities");
            cities.html('');
            for(var i = 0; i < data.length;i++ )
            {
                var option = '<option value="'+data[i].id+'">'+data[i].display_name+'</option>'
                cities.append(option);
            }
        })
    });
    $('.vat_radio').click(function ()
    {
        let vat_flag = $("input[name='vat_on_total']");
        console.log(vat_flag);

        if(vat_flag.prop('checked')==false)
        {
            $('#vat_value').attr('disabled','true');
            $('#vat_value').hide();
            $('#vat_value_div').hide();

        }
        else
        {
            $('#vat_value').removeAttr('disabled');
            $('#vat_value').show();
            $('#vat_value_div').show();
        }
    });
});
</script>
@endsection
