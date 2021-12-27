@extends('layouts.adminPanel.admin')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">اضافة فرع</span>
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

        <form autocomplete="off" action="{{isset($branch->id) ? route('resturants.branches.update',['resturant'=>$resturant->id,'branch'=>$branch->id]) : route('resturants.branches.store',['resturant'=>$resturant->id])}}" enctype="multipart/form-data" class="form-horizontal" method="POST">
            <div class="form-body">
                 {{csrf_field() }}
                @isset($branch->id)
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
                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">الاسم بالعربية</label>
                    <div class="col-md-8">
                        @error('name_ar')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="name_ar" value="{{$branch->name_ar}}" required class="form-control" placeholder="الاسم بالعربية">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">الاسم بالانجليزية</label>
                    <div class="col-md-8">
                        @error('name_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="name_en" value="{{$branch->name_en}}" class="form-control" placeholder="الاسم بالانجليزية">
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
                            <label class="p-r-small col-sm-2 control-label">latitude</label>
                            <div class="form-group col-sm-4">
                                <input value="{{$branch->lat}}" name="lat" class="form-control"  id="us2-lat" />
                            </div>
                            <label class="p-r-small col-sm-2 control-label">longitude</label>
                            <div class="form-group col-sm-4">
                                <input value="{{$branch->lng}}" name="lng" class="form-control"  id="us2-lon" />
                            </div>
                        </div>
                    <div class="col-xs-offset-2" id="us2" style="width: 550px; height: 400px;"></div>
                    <div class="clearfix">&nbsp;</div>

                    <div class="clearfix"></div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">كلمة سر الاوردرات</label>
                    <div class="col-md-8">
                        @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="password" autocomplete="new-password" id="password-input" name="password" value="" class="form-control" placeholder="كلمة سر الاوردرات">
                        <span class="help-block"> احتفظ بكلمة السر </span>
                    </div>
                </div>
                <!-- Location picker -->
                <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
                <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
                <script type="text/javascript" src='https://maps.google.com/maps/api/js?key=AIzaSyAQjWhZI8BLtadn3QU0PYhNLMjpkNUV8zg&sensor=true'></script>
                <script src="{{asset('mappicker/locationpicker.jquery.js')}}"></script>
                <script>
                    $('#us2').locationpicker({
                        location: {
                            latitude: {{$branch->lat??30.0291295}},
                            longitude:{{$branch->lng??31.4110415}}
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

                {{-- <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">(%)الخصم</label>
                    <div class="col-md-8">
                        @error('discount')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="number" required name="discount" value="{{$branch->discount}}" class="form-control" >
                    </div>
                </div> --}}
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
    // $('.vat_radio').click(function ()
    // {
    //     let vat_flag = $("input[name='vat_on_total']");
    //     console.log(vat_flag);

    //     if(vat_flag.prop('checked')==false)
    //     {
    //         $('#vat_value').attr('disabled','true');
    //         $('#vat_value').hide();
    //         $('#vat_value_div').hide();

    //     }
    //     else
    //     {
    //         $('#vat_value').removeAttr('disabled');
    //         $('#vat_value').show();
    //         $('#vat_value_div').show();
    //     }
    // });
});
</script>
@endsection
