@extends('layouts.adminPanel.admin')
@section('content')
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">اضافة منتج</span>
            <span class="caption-helper">{{Translator::get('add_product')}}</span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @can('update terms')
        <form action="{{route('terms.store')}}" enctype="multipart/form-data" class="form-horizontal" method="POST">
        @endcan
            <div class="form-body">
                {{ csrf_field() }}

                <label>الشروط و الاحكام بالعربية<label>
                <textarea name="terms_ar" id='editor_ar'>
                    {{$terms_ar?$terms_ar->value:''}}
                </textarea>
            </div>
            <div class="form-body">
                {{ csrf_field() }}

                <label>الشروط و الاحكام بالانجليزية<label>
                <textarea name="terms_en" id='editor_en'>
                    {{$terms_en?$terms_en->value:''}}
                </textarea>
            </div>
            @can('update terms')
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-4">
                        <button type="submit" class="btn green"><i class="fa fa-save"></i>حفظ</button>
                    </div>
                </div>
            </div>
        </form>
        @endcan
        <!-- END FORM-->
    </div>
</div>
@endsection
@section('javascript')
<script src="//cdn.ckeditor.com/4.12.1/full/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor_ar');
    CKEDITOR.replace('editor_en');
</script>
@endsection
