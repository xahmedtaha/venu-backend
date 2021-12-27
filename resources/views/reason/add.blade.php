@extends('layouts.adminPanel.admin')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">اضافة سبب التعليق او الشكوى</span>
            <span class="caption-helper">{{Translator::get('add_category_caption')}}</span>
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
        <form action="{{route('userFeedbackReason.store')}}" class="form-horizontal" method="POST">
            <div class="form-body">
                {{ csrf_field() }}
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
                        <a href="" class="btn red"><i class="fa fa-close"></i>الغاء</a>
                    </div>
                </div>
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>
@endsection
