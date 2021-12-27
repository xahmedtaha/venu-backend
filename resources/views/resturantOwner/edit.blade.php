@extends('layouts.adminPanel.admin')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">{{Translator::get('edit_resturant_owner_account')}}</span>
            <span class="caption-helper">{{Translator::get('edit_category_caption')}}</span>
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
        <form action="{{route('resturantOwners.update',$resturantOwner->id)}}" class="form-horizontal" method="POST">
            <div class="form-body">
                {{ csrf_field() }}
                @method('PUT')
                <div class="form-group">
                    @error('resturant')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">المطعم</label>
                    <div class="col-md-4">
                        <select name="resturant_id" required class="form-control select2" id="">
                            @foreach ($resturants as $resturant)
                                <option value="{{$resturant->id}} {{$resturant->id==$resturantOwner->resturant_id?'selected':''}}">{{$resturant->display_name}}</option>
                            @endforeach
                        </select>
                        {{-- <input type="text" name="resturant" required class="form-control" placeholder="المطعم"> --}}
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group">
                    @error('name_ar')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">الاسم بالعربية</label>
                    <div class="col-md-4">
                        <input type="text" value="{{$resturantOwner->name_ar}}" name="name_ar" required class="form-control" placeholder="الاسم بالعربية">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group">
                    @error('name_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">الاسم بالانجيليزية</label>
                    <div class="col-md-4">
                        <input type="text" name="name_en" value="{{$resturantOwner->name_en}}" class="form-control" placeholder="الاسم بالانجيليزية">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group">
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">{{Translator::get('email')}}</label>
                    <div class="col-md-4">
                        <input type="email" value="{{$resturantOwner->email}}" name="email" class="form-control" placeholder="{{Translator::get('email')}}">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

                <div class="form-group">
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">{{Translator::get('password')}}</label>
                    <div class="col-md-4">
                        <input type="password" name="password" id="password" class="form-control" placeholder="{{Translator::get('password')}}">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group">
                    @error('confirm_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label class="col-md-2 control-label">{{Translator::get('confirm_password')}}</label>
                    <div class="col-md-4">
                        <input type="confirm_password" name="confirm_password" id="confirm_password" class="form-control" placeholder="{{Translator::get('confirm_password')}}">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-4">
                        <button type="submit" class="btn green"><i class="fa fa-save"></i>حفظ</button>
                        <a href="{{route('resturantOwners.index')}}" class="btn red"><i class="fa fa-close"></i>الغاء</a>
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
    function validatePassword()
    {
        if($("#password").val()==$("#confirm_password").val())
        {
            $("form").submit();
        }
        else
        {
            alert("{{Translator::get('confirm_password')}}");
        }
    }
</script>
@endsection
