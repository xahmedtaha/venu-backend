@extends('layouts.adminPanel.admin')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">تعديل سبب التعليق او الشكوى</span>
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
        <form action="{{route('userFeedbackReason.update',$userFeedbackReason->id)}}" method="POST" class="form-horizontal">
            <div class="form-body">
                @method('put')
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-md-1 control-label">الاسم بالعربية</label>
                    <div class="col-md-4">
                        @error('name_ar')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" name="name_ar" required value="{{$userFeedbackReason->name_ar}}" class="form-control" placeholder="الاسم بالعربية">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-1 control-label">الاسم بالانجيليزية</label>
                    <div class="col-md-4">
                        <input type="text" name="name_en" value="{{$userFeedbackReason->name_en}}" class="form-control" placeholder="الاسم بالانجيليزية">
                        {{-- <span class="help-block"> A block of help text. </span> --}}
                    </div>
                </div>

            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-4">
                        <button type="submit" class="btn green"><i class="fa fa-save"></i>حفظ</button>
                        <a href="" class="btn default">الغاء</a>
                    </div>
                </div>
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>
@endsection
