@extends('layouts.adminPanel.admin')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">اضافة اصناف</span>
            <span class="caption-helper">{{Translator::get('add_category_caption')}}</span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="{{route('itemCategories.store',$resturant->id)}}" class="form-horizontal" method="POST">
            <div class="form-body">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-md-2 control-label">المطعم</label>
                    <div class="col-md-4">
                        <input type="text" readonly class="form-control" value="{{$resturant->name}}">
                        <input type="hidden" name="resturant_id" value="{{$resturant->id}}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">الاسم بالعربية</label>
                    <div class="col-md-4">
                        <input type="text" name="name_ar" required class="form-control" placeholder="الاسم بالعربية">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">الاسم بالانجيليزية</label>
                    <div class="col-md-4">
                        <input type="text" name="name_en" class="form-control" placeholder="الاسم بالانجيليزية">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-4">
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
